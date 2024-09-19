<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\UserInfo;
use App\Events\UserCreated;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use App\Models\PatientsProfile;
use App\Models\Patients_profile;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientProfileRequest;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\File;

class PatientController extends Controller
{
    use UploadTrait;

    public function createPatientPage(){
        return view("backend.pages.patient.create-patient-page");
    }

    public function createPatient(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'phone' => 'required|string|min:10|unique:users',
                'type' => 'required|in:Patient',
            ]);

            // Create the user
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'type' => 'Patient', 
            ]);
            
            event(new UserCreated($user, $request->input('password')));

            PatientsProfile::create([
                'user_id' => $user->id,
                'reference_by' => $request->session()->get("id"),
                'reference_time' => now(),  
                'first_name' => $user->name,
                'phone_number' => $user->phone,
                'email' => $user->email,
                'created_by' => $request->session()->get("id")
            ]);

            
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Patient created successfully. An email has been sent to your email address.'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
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
        
        return view("backend.pages.dashboard.admin.patient-edit", compact("data"));
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

            if($request->hasFile('profile_photo')) {
                $profile_photo = $this->uploadImageToLocal($request->profile_photo, '/patient/'.$userId.'/profile_image/', 'image_', 100, 100, $request->file_path);
                $patienData["profile_photo"] = $profile_photo;
            }
                        
            $request->merge(["user_id" => $userId]);
            PatientsProfile::updateOrCreate(["user_id" => $userId], $patienData);
            User::where("id", $userId)->update(["name" => $patienData["first_name"], "email" => $patienData["email"]]);
            DB::commit();
            DB::log("PatientProfile Updated Successfully");
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
}
