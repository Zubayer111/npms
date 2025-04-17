<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Diseases;
use App\Events\UserCreated;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\PatientAdvice;
use App\Helper\ResponseHelper;
use App\Models\DoctorsProfile;
use Illuminate\Support\Carbon;
use App\Models\MedicalDocument;
use App\Models\PatientsProfile;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\PatientPrescription;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\PatientIllnesHistory;
use App\Models\PatientPhysicalComplain;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Patient\PatientProfileRequest;

class PatientController extends Controller
{
    use UploadTrait;

    public function createPatientPage(){
        return view("backend.pages.patient.create-patient-page");
    }

    public function createPatient(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [ 
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'phone' => 'required|string|min:10|unique:users',
                'type' => 'required|in:Patient', 
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 400);
            }
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'type' => 'Patient', 
            ]);
            
            if($user){
            $profile = PatientsProfile::create([
                'user_id' => $user->id,
                'reference_by' => $request->session()->get("id"),
                'reference_time' => now(),  
                'first_name' => $user->name,
                'phone_number' => $user->phone,
                'email' => $user->email,
                'created_by' => $request->session()->get("id")
            ]);
            if($profile){
                event(new UserCreated($user, $request->input('password')));
            }
        }

            
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Patient created successfully. An email has been sent to your email address.'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error creating patient: " . $e);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function patientListPage(){
        return view("backend.pages.patient.patient-list-page");
    }

    public function getPatientList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "Patient")->orderByDesc("updated_at")->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $editUrl = route('dashboard.edit-patient', $row->id);
                    $deleteUrl = route('dasboard.user-delete', $row->id);
                    $viewUrl = route('dashboard.view-patient', $row->id);

                    $btn = '<a href="'.$viewUrl.'" class="btn btn-success btn-sm mr-2">View</a>';

                    $btn .= '<button type="button" id="editBtn" data-url="'.$editUrl.'" class="btn btn-primary btn-sm" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#editUserModal">
                                <div>Edit</div>
                            </button>';
                    $btn .= '<form id="delete-form-'.$row->id.'" action="'.$deleteUrl.'" method="POST" style="display: inline;">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="button" class="btn badge-danger btn-sm" onclick="confirmDelete('.$row->id.')">Delete</button>
                             </form>';
                    return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function viewPatient($id){
        $patient = User::findOrFail($id);
        $data = PatientsProfile::where('user_id', $patient->id)->first();
        $medcalDocuments = MedicalDocument::where("patient_id", $patient->id)->get();
        $diseases = Diseases::where("status", "active")->get();
        $ilnase = PatientIllnesHistory::where("patient_id", $patient->id)->get(); 

        // dd($ilnase);
        return view("backend.pages.patient.view-patient-page", compact("patient", "data", "medcalDocuments", "diseases"));
    }

    public function activePatient(){
        return view("backend.pages.patient.active-patient-page");
    }

    public function activePatientList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "Patient")->where("status", "active")->orderByDesc("updated_at")->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $inActiveUrl = route('dasboard.user-inactive', $row->id);
                $deleteUrl = route('dasboard.user-delete', $row->id);
                
                $btn = '<form id="inactive-form-'.$row->id.'" action="'.$inActiveUrl.'" method="POST" style="display: inline;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="button" class="btn badge-warning btn-sm" onclick="confirmInactive('.$row->id.')">Inactive</button>
                        </form>';
                $btn .= '<form id="delete-form-'.$row->id.'" action="'.$deleteUrl.'" method="POST" style="display: inline;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="button" class="btn badge-danger btn-sm" onclick="confirmDelete('.$row->id.')">Delete</button>
                        </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function inactivePatient(){
        return view("backend.pages.patient.inactive-patient-page");
    }

    public function inactivePatientList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "Patient")->where("status", "inactive")->orderByDesc("updated_at")->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $activeUrl = route('dasboard.user-active', $row->id);   
                    $btn = '<form id="active-form-'.$row->id.'" action="'.$activeUrl.'" method="GET" style="display: inline;">
                                '.csrf_field().'
                                '.method_field('GET').'
                                <button type="button" class="btn badge-success btn-sm" onclick="confirmActive('.$row->id.')">Active</button>
                            </form>';
                    
                    return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function deletedPatient(){
        return view("backend.pages.patient.deleted-patient-page");
    }

    public function deletedPatientList(Request $request){
        if ($request->ajax()) {
            $data = User::onlyTrashed()
                ->where("type", "Patient")
                ->where("status", "suspended")
                ->orderByDesc("deleted_at")
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $restoreUrl = route('dasboard.user-restore', $row->id);
                    $btn = '<form id="restore-form-'.$row->id.'" action="'.$restoreUrl.'" method="GET" style="display: inline;">
                                '.csrf_field().'
                                '.method_field('GET').'
                                <button type="button" class="btn badge-success btn-sm" onclick="restore('.$row->id.')">Restore</button>
                            </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function editPatient($id){
        $data = User::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    
    public function profileCreate(PatientProfileRequest $request) {
        try {
            DB::beginTransaction();
            $userId = $request->session()->get("id");
            $reference_by = User::where("id", $userId)->first();
            $title = $request->session()->get("type");
            $status = $request->session()->get("status");
            
            $patienData = [
                "user_id" => $userId,
                "reference_by" => $reference_by->id,
                "reference_note" => $request->input("reference_note"),
                "reference_time" => date("Y-m-d H:i:s", strtotime($request->reference_time)),
                "title" => $request->input("title"),
                "first_name" => $request->input("first_name"),
                "last_name" => $request->input("last_name"),
                "middle_name" => $request->input("middle_name"),
                "email" => $request->input("email"),
                "gender" => $request->input("gender"),
                "marital_status" => $request->input("marital_status"),
                "blood_group" => $request->input("blood_group"),
                "economical_status" => $request->input("economical_status"),
                "smoking_status" => $request->input("smoking_status"),
                "alcohole_status" => $request->input("alcohole_status"),
                "dob" => date("Y-m-d H:i:s", strtotime($request->dob)),
                "height" => $request->input("height"),
                "weight" => $request->input("weight"),
                "bmi" => $request->input("bmi"),
                "address_one" => $request->input("address_one"),
                "address_two" => $request->input("address_two"),
                "city" => $request->input("city"),
                "state" => $request->input("state"),
                "zipCode" => $request->input("zipCode"),
                "phone_number" => $request->input("phone_number"),
                "history" => $request->input("history"),
                "employer_details" => $request->input("employer_details"),
                "status" => $status,
                "patient_type" =>"system-patient",
            ];
            
            if ($request->hasFile("profile_photo")) {
                $img = $request->file("profile_photo");
                $file_name = $img->getClientOriginalName();
                $img_name = "{$userId}-{$file_name}";
                
                $img_url = $img->storeAs('uploads/patients', $img_name, 's3', ['visibility' => 'public']);
                
                if ($img_url) {
                    $patienData["profile_photo"] = Storage::disk('s3')->url($img_url);
                } else {
                    throw new \Exception("Failed to upload profile photo to S3.");
                }
            }
            
                        
            $request->merge(["user_id" => $userId]);
            PatientsProfile::updateOrCreate(["user_id" => $userId], $patienData);
           
            User::where("id", $userId)->update(["name" => $patienData["first_name"], "email" => $patienData["email"]]);
            DB::commit();
            Log::info("PatientProfile Updated Successfully");
            return redirect("/dashboard/profile")->with("success", "Profile Updated Successfully");
        }
        catch (\Exception $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'error');
            return redirect("/dashboard/profile");
        }
            
    }

    public function profileRead(Request $request, $id) {
        $userID = $request->session()->get("id");
        $data = PatientsProfile::where("user_id", $userID)->with("user")->first();
        return ResponseHelper::output("success",$data,200);
    }

    public function profileEdit(Request $request){
        $userID = $request->session()->get("id");
        $user = PatientsProfile::where("user_id", $userID)->with("user")->first();
        return view("backend.pages.dashboard.profile-edit-page",compact("user"));
    }

    public function profileDelete(Request $request, $id){
        $userID = $request->session()->get("id");
        $data = PatientsProfile::where("user_id", $userID)->findOrFail($id);
        $data->delete();
        return ResponseHelper::output("success","Profile Deleted Successfully",200);
    }

    public function updatePatient(Request $request){
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|min:10',
            ]);
            $userID = $request->input("id");
            $data = User::where("id", $userID)->first();
            $data->update([
                "name" => $request->input("name"),
                "email" => $request->input("email"),
                "phone" => $request->input("phone"),
                "type" => "Patient",
            ]);
            return redirect("/dashboard/patient-list")->with("success", "Patient Updated Successfully");
        }
        catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            Log::error("Error updating Patient: " . $e);
            return redirect("/dashboard/patient-list");
        }
    }

    public function editProfileAdmin($id){
        $user = PatientsProfile::findOrFail($id);
        return view("backend.pages.dashboard.admin.patient-edit", compact("user"));
    }

    public function profileCreateByAdmin(PatientProfileRequest $request)
    {
        try {
            DB::beginTransaction();
            $id = $request->input("id");
            $data = PatientsProfile::where("id", $id)->first();
            $patient = User::where("id", $data->user_id)->first();
            $userId = $request->session()->get("id");
            $reference_by = User::where("id", $userId)->first();
            $status = $request->session()->get("status");

            $request->validate([
                'first_name' => 'required|string|max:255',
                'email' => 'required|email',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'dob' => 'required|date',
                'gender' => 'required|string',
            ]);
            
            $patienData = [
                "user_id" => $patient->id,
                "reference_by" => $reference_by->id,
                "reference_note" => $request->input("reference_note"),
                "reference_time" => date("Y-m-d H:i:s", strtotime($request->reference_time)),
                "title" => $request->input("title"),
                "first_name" => $request->input("first_name"),
                "last_name" => $request->input("last_name"),
                "middle_name" => $request->input("middle_name"),
                "email" => $request->input("email"),
                "gender" => $request->input("gender"),
                "marital_status" => $request->input("marital_status"),
                "blood_group" => $request->input("blood_group"),
                "economical_status" => $request->input("economical_status"),
                "smoking_status" => $request->input("smoking_status"),
                "alcohole_status" => $request->input("alcohole_status"),
                "dob" => date("Y-m-d H:i:s", strtotime($request->dob)),
                "height" => $request->input("height"),
                "weight" => $request->input("weight"),
                "bmi" => $request->input("bmi"),
                "address_one" => $request->input("address_one"),
                "address_two" => $request->input("address_two"),
                "city" => $request->input("city"),
                "state" => $request->input("state"),
                "zipCode" => $request->input("zipCode"),
                "phone_number" => $request->input("phone_number"),
                "history" => $request->input("history"),
                "employer_details" => $request->input("employer_details"),
                "status" => $status,
                "patient_type" =>"system-patient",
            ];
            
            if ($request->hasFile("profile_photo")) {
                $img = $request->file("profile_photo");
                $file_name = $img->getClientOriginalName();
                $img_name = "{$id}-{$file_name}";
                
                $img_url = $img->storeAs('uploads/patients', $img_name, 's3', ['visibility' => 'public']);
                
                if ($img_url) {
                    $patienData["profile_photo"] = Storage::disk('s3')->url($img_url);
                } else {
                    throw new \Exception("Failed to upload profile photo to S3.");
                }
            }
            
                        
            $request->merge(["user_id" => $userId]);
            PatientsProfile::updateOrCreate(["user_id" => $patient->id], $patienData);
        
        
            User::where("id", $patient->id)->update(["name" => $patienData["first_name"], "email" => $patienData["email"]]);
            DB::commit();
            Log::info("PatientProfile Updated Successfully");
            return redirect("/dashboard/patient-list")->with("success", "Profile Updated Successfully");
        }
        catch (\Exception $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'error');
            Log::error("Error updating PatientProfile: " . $e);
            return redirect("/dashboard/patient-list");
        }
    }
    
    public function addComplain(Request $request, $id){
        try {
            $request->validate([
                'complain' => 'required|string|max:255',
            ]);
            $userID = $request->session()->get("id");
            
            $complainData = [
                "patient_id" => $id,
                "complain" => $request->input("complain"),
                "created_by" => $userID,
                "updated_by" => $userID,
            ];
            
            $data = PatientPhysicalComplain::create($complainData);
            return response()->json(
                ['status' => 'success',
                'message' => 'Complain Added Successfully',
                'data' => $data ]);
         }
         
        catch (Exception $e) {
            Log::error("Error adding complain: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
       
    public function getComplainList(Request $request, $id)
{
    if ($request->ajax()) {
        $data = PatientPhysicalComplain::with('creator')
            ->where("patient_id", $id)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_by', function($row) {
                return $row->creator ? $row->creator->name : 'N/A'; // Replace 'creator' with actual relation name
            })
            ->addColumn('action', function($row){
                $deleteUrl = route('dashboard.patient.complain-delete', $row->id);
                $btn = '<form id="delete-form-'.$row->id.'" action="'.$deleteUrl.'" method="POST" style="display: inline;">
                             '.csrf_field().'
                             '.method_field('DELETE').'
                             <button type="button" class="btn badge-danger btn-sm" onclick="confirmDelete('.$row->id.')">Delete</button>
                          </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}


    public function deleteComplain($id){
        $disease = PatientPhysicalComplain::findOrFail($id);
        $disease->delete();
        return redirect()->back()->with("success", "Complain Deleted Successfully");
    }

    public function addPatientIlnase(Request $request, $id, $pid){
        
        try {
            $userID = $request->session()->get("id");
    
            Log::info("Adding illness history", [
                'user_id' => $userID,
                'patient_id' => $pid,
                'disease_id' => $id
            ]);
    
            $data = PatientIllnesHistory::create([
                "patient_id" => $pid,
                "disease_id" => $id,
                "created_by" => $userID,
                "updated_by" => $userID,
            ]);
    
            Log::info("Illness history added successfully", ['data' => $data]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Illness Added Successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error("Error adding illness history", [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add illness history'
            ], 500);
        }
    }

    public function getIllnessList(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = PatientIllnesHistory::with('disease')
                ->where("patient_id", $id)
                ->withTrashed()
                ->get();

           return response()->json([
            "status" => "success",
            "data" => $data
           ]);
        }
    }   
    
    public function deleteIllness($id){
        $disease = PatientIllnesHistory::findOrFail($id);
        $disease->delete();
        return response()->json(['status' => 'success', 'message' => 'Illness removed successfully']);
    }

    public function restoreIllness($id)
{
    try {
        Log::info("Attempting to restore illness with ID: " . $id);

        $disease = PatientIllnesHistory::onlyTrashed()->where("id", $id)->first();

        if (!$disease) {
            Log::warning("Illness with ID: $id not found in deleted records.");
            return response()->json(['status' => 'error', 'message' => 'Illness not found'], 404);
        }

        $disease->restore();
        Log::info("Successfully restored illness with ID: " . $id);

        return response()->json(['status' => 'success', 'message' => 'Patient illness restored successfully']);
    } catch (\Exception $e) {
        Log::error("Error restoring illness: " . $e);
        return response()->json(['status' => 'error', 'message' => 'Failed to restore illness'], 500);
    }
}

public function viewPetientPrescritions(Request $request, $id, $prescription_id) {
    try {
        $patient = PatientsProfile::where('user_id', $id)->first();

        if (!$patient) {
            Log::error('Patient not found', ['user_id' => $id]);
            return redirect()->back()->withErrors(['error' => 'Patient profile not found.']);
        }

        if (!is_numeric($prescription_id)) {
            return redirect()->back()->withErrors(['error' => 'Invalid prescription ID.']);
        }

        $prescriptionData = PatientPrescription::where('patient_id', $patient->id)
            ->where('prescription_id', $prescription_id)
            ->get();

        $advice = PatientAdvice::where('patient_id', $patient->id)
            ->where('prescription_id', $prescription_id)
            ->first();

        if (!$advice) {
            Log::error('No advice found', ['patient_id' => $patient->id, 'prescription_id' => $prescription_id]);
            return redirect()->back()->withErrors(['error' => 'No advice found for this prescription.']);
        }

        $doctor = DoctorsProfile::where('user_id', $advice->created_by)->first();

        $formattedDate = Carbon::parse($advice->created_at)->format('d M, Y');

        $dob = $patient->dob;
        $age = Carbon::parse($dob)->age;

        return view('backend.pages.prescriptions.prescription', compact(
            'patient',
            'prescriptionData',
            'advice',
            'doctor',
            'formattedDate',
            'age'
        ));

    } catch (\Exception $e) {
        Log::error('Error viewing prescription', [
            'error' => $e->getMessage(),
            'patient_id' => $id,
            'prescription_id' => $prescription_id
        ]);

        return redirect()->back()->withErrors(['error' => 'Failed to retrieve prescriptions.']);
    }
}


}
