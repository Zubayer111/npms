<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\UserInfo;
use App\Models\Doctor;
use App\Events\UserCreated;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use App\Models\DoctorsProfile;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class DoctorController extends Controller
{
    public function doctorListPage(){
        return view("backend.pages.doctor.doctor-list-page");
    }

    public function getDoctorList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "=", "doctor")->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('dashboard.edit-doctor', $row->id);
                    $deleteUrl = route('dasboard.user-delete', $row->id);
                    $viewUerl = route('dashboard.view-doctor', $row->id);

                    $btn = '<a href="'.$viewUerl.'" class="btn btn-success btn-sm mr-2">View</a>';
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

    public function viewDoctor($id){
        $doctor = User::findOrFail($id);
        $data = DoctorsProfile::where('user_id', $doctor->id)->first();
        
        return view("backend.pages.doctor.view-doctor-page", compact("data"));
    }

    public function createDoctorPage(){
        return view("backend.pages.doctor.create-doctor-page");
    }

public function createDoctor(Request $request)
{
    DB::beginTransaction();
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|string|min:10|unique:users',
            'type' => 'required|in:Doctor',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'type' => $request->input('type'),
        ]);

       
        event(new UserCreated($user, $request->input('password')));

        
        DoctorsProfile::create([
            'user_id' => $user->id,
            'phone_number' => $user->phone,
            'first_name' => $user->name,
            'last_name' => $user->name,
        ]);

        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Doctor created successfully & An email has been sent to the provided email address',
        ], 200);
    } catch (Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}


    public function activeDoctor(){
        return view("backend.pages.doctor.active-doctor-page");
    }

    public function activeDoctorList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "Doctor")->where("status", "active")->orderByDesc("updated_at")->get();
            return Datatables::of($data)
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

    public function inactiveDoctor(){
        return view("backend.pages.doctor.inactive-doctor-page");
    }

    public function inactiveDoctorList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "Doctor")->where("status", "inactive")->orderByDesc("updated_at")->get();
            return Datatables::of($data)
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

    public function deletedDoctor(){
        return view("backend.pages.doctor.deleted-doctor-page",);
    }

    public function deletedDoctorList(Request $request){
        if ($request->ajax()) {
            $data = User::onlyTrashed()
                ->where("type", "Doctor")
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

    public function editDoctor($id){
        $data = User::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function profileCreate(Request $request){
        try {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'middle_name' => 'required|string',
                'phone_number' => 'required|string',
                'address_one' => 'required|string',
                'address_two' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zip_code' => 'required|string',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'degree' => 'required|string',
                'speciality' => 'required|string',
                'organization' => 'required|string',
            ]);
            
            $userId = $request->session()->get("id");
            $status = $request->session()->get("status");
            $refID = rand(10000, 99999);
            $type = $request->session()->get("type");
            $adminData = [
                "user_id" => $userId,
                "ref_id" => $refID,
                "title" => $type,
                "first_name" => $request->input("first_name"),
                "last_name" => $request->input("last_name"),
                "middle_name" => $request->input("middle_name"),
                "phone_number" => $request->input("phone_number"),
                "address_one" => $request->input("address_one"),
                "address_two" => $request->input("address_two"),
                "city" => $request->input("city"),
                "state" => $request->input("state"),
                "zip_code" => $request->input("zip_code"),
                "degree" => $request->input("degree"),
                "speciality" => $request->input("speciality"),
                "organization" => $request->input("organization"),
                "status" => $status,
            ];
            if ($request->hasFile("profile_photo")) {
                $img = $request->file("profile_photo");
                $time = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$userId}-{$time}-{$file_name}";
                $img_url = "uploads/doctor/{$img_name}";
                $img->move(public_path('uploads/doctor'), $img_name);
                $adminData["profile_photo"] = $img_url;
                if ($request->input("file_path")) {
                    File::delete($request->input("file_path"));
                }
            }

            $request->merge(["user_id" => $userId]);
            DoctorsProfile::updateOrCreate(["user_id" => $userId], $adminData);

            return redirect("/dashboard/profile")->with("success", "Profile Updated Successfully");
        }
        catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect("/dashboard/profile");
        }
            
    }

    public function profileRead(Request $request){
        $userID = $request->session()->get("id");
        $data = DoctorsProfile::where("user_id", $userID)->with("user")->first();
        return ResponseHelper::output("success",$data,200);
    }

    public function profileEdit(Request $request){
        $userID = $request->session()->get("id");
        $user = DoctorsProfile::where("user_id", $userID)->with("user")->first();
        return view("backend.pages.dashboard.profile-edit-page",compact("user"));
    }

    public function profileDelete(Request $request, $id){
        $userID = $request->session()->get("id");
        $data = DoctorsProfile::where("user_id", $userID)->findOrFail($id);
        $data->delete();
        return ResponseHelper::output("success","Profile Deleted Successfully",200);
    }

    public function updateDoctor(Request $request){
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
            "type" => "Doctor",
        ]);
        return redirect("/dashboard/doctor-list")->with("success", "Doctor Updated Successfully");
    }

    public function editProfileAdmin($id){
        $user = DoctorsProfile::findOrFail($id);
        return view("backend.pages.dashboard.admin.doctor-edit", compact("user"));
    }

    public function profileUpdateAdmin(Request $request){
        try {
            DB::beginTransaction();
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone_number' => 'required|string',
                'address_one' => 'required|string',
                'address_two' => 'nullable|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zip_code' => 'required|string',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'degree' => 'required|string',
                'speciality' => 'required|string',
                'organization' => 'required|string',
            ]);
    
            $user = User::findOrFail($request->input('id'));
            $userId = $user->id;
    
            $updated_by = $request->session()->get("id");
            $status = "active";
            $refID = rand(10000, 99999);  // Ensure uniqueness if necessary
            $type = "Doctor";
    
            $adminData = [
                "user_id" => $userId,
                "ref_id" => $refID,
                "title" => $type,
                "first_name" => $request->input("first_name"),
                "last_name" => $request->input("last_name"),
                "middle_name" => $request->input("middle_name"),
                "phone_number" => $request->input("phone_number"),
                "address_one" => $request->input("address_one"),
                "address_two" => $request->input("address_two"),
                "city" => $request->input("city"),
                "state" => $request->input("state"),
                "zip_code" => $request->input("zip_code"),
                "degree" => $request->input("degree"),
                "speciality" => $request->input("speciality"),
                "organization" => $request->input("organization"),
                "updated_by" => $updated_by,
                "status" => $status,
            ];
    
            if ($request->hasFile("profile_photo")) {
                $img = $request->file("profile_photo");
                $time = time();
                $file_name = preg_replace('/[^a-zA-Z0-9._-]/', '', $img->getClientOriginalName());
                $img_name = "{$userId}-{$time}-{$file_name}";
                $img_url = "uploads/doctor/{$img_name}";
                
                // Handle file move and potential errors
                try {
                    $img->move(public_path('uploads/doctor'), $img_name);
                    $adminData["profile_photo"] = $img_url;
    
                    if ($request->input("file_path") && File::exists($request->input("file_path"))) {
                        File::delete($request->input("file_path"));
                    }
                } catch (\Exception $e) {
                    throw new \Exception("File upload failed: " . $e->getMessage());
                }
            }
    
            // Ensure "user_id" is correctly set
            $request->merge(["user_id" => $userId]);
           $doctor = DoctorsProfile::updateOrCreate(["user_id" => $userId], $adminData);
           if ($doctor) {
            $user->update([
                "name" => $request->input("first_name") . " " . $request->input("last_name"),
                "phone" => $request->input("phone_number")
            ]);
            }
            DB::commit();
            return redirect("/dashboard/doctor-list")->with("success", "Profile Updated Successfully");
        }
        catch (\Exception $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'error');
            return redirect("/dashboard/doctor-list")->with("error", $e->getMessage());
        }
    }
    
}
