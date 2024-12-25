<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Models\User;
use App\Models\Admin;
use App\Mail\UserInfo;
use App\Events\UserCreated;
use Illuminate\Http\Request;
use App\Models\AdminsProfile;
use App\Helper\ResponseHelper;
use App\Models\Admins_profile;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function createAdminPage(){
        return view("backend.pages.admin.create-admin-page");
    }


    public function createAdmin(Request $request)
    {
       
        try {
            if($request->ajax()){   
                $validator = Validator::make($request->all(), [ 
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:8',
                    'phone' => 'required|string|min:10|unique:users',
                    'type' => 'required|in:Admin', 
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
                'type' => 'Admin',  
            ]);

            if($user){
                $profile = AdminsProfile::create([
                    'user_id' => $user->id,
                    'phone_number' => $user->phone,
                    'first_name' => $user->name,
                    'last_name' => $user->name,
                ]);

                if($profile){
                    event(new UserCreated($user, $request->input('password')));
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Admin created successfully. An email has been sent to the provided email address.',
            ], 200);
        }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Admin Creation Failed: ' . $e);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function adminListPage(){
        return view("backend.pages.admin.admin-list-page");
    }

    public function editAdminProfile($id){
        $user = AdminsProfile::findOrFail($id);
    
        return view("backend.pages.dashboard.admin.admin-edit", compact("user"));
    }

    public function getAdminList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "Admin")->select(['id', 'name', 'email', 'phone','type', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('dashboard.admin-edit', $row->id);
                    $deleteUrl = route('dasboard.user-delete', $row->id);
                    $viewUerl = route('dashboard.view-admin', $row->id);
                    
                    $btn = '<a href="'.$viewUerl.'" class="btn btn-info btn-sm mr-2">View</a>';
                    $btn .= '<button type="button" id="editBtn" data-url="'.$editUrl.'" class="btn btn-success btn-sm" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#editUserModal">
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

    public function viewAdmin($id){
        $admin = User::findOrFail($id);
        $pass = $admin->password;
        
        $data = AdminsProfile::where('user_id', $admin->id)->first();
        return view("backend.pages.admin.admin-view-page", compact("data","pass"));
    }

    public function activeAdmin(){
        return view("backend.pages.admin.active-admin-page");
    }

    public function activeAdminList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "Admin")->where("status", "active")->orderByDesc("updated_at")->get();
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
    

    public function inactiveAdmin(){
        return view("backend.pages.admin.inactive-admin-page");
    }

    public function inactiveAdminList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "Admin")->where("status", "inactive")->orderByDesc("updated_at")->get();
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

    public function deletedAdmin(){
            return view("backend.pages.admin.deleted-admin-page");
    }

    public function deletedAdminList(Request $request){
        if ($request->ajax()) {
            $data = User::onlyTrashed()
                ->where("type", "Admin")
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

    public function editAdmin($id){
        $data = User::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function profileCreate(Request $request)
    {
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
            ]);
        
            $userId = $request->session()->get("id");
            $status = $request->session()->get("status");
            $type = $request->session()->get("type");
        
            $refID = rand(10000, 99999);
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
                "status" => $status,
            ];
        
            if ($request->hasFile("profile_photo")) {
                $img = $request->file("profile_photo");
                $file_name = $img->getClientOriginalName();
                $img_name = "{$userId}-{$file_name}";
        
                // Store the file in S3
                $img_url = $img->storeAs('uploads/admin', $img_name, 's3', ['visibility' => 'public']);
        
                // Generate a public URL for the file
                $adminData["profile_photo"] = Storage::disk('s3')->url($img_url);
        
                // Delete the old file if provided
                if ($request->input("file_path")) {
                    $oldFilePath = str_replace(Storage::disk('s3')->url(''), '', $request->input("file_path"));
                    Storage::disk('s3')->delete($oldFilePath);
                }
            }
        
            $request->merge(["user_id" => $userId]);
        
            AdminsProfile::updateOrCreate(["user_id" => $userId], $adminData);
        
            return redirect("/dashboard/profile")->with("success", "Profile Updated Successfully");
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect("/dashboard/profile");
        }
        
    }


    // public function profileRead(Request $request, $id){
    //     $userID = $request->session()->get("id");
    //     $data = Admins_profile::where("user_id", $id)->with("user")->first();
    //     return view("backend.components.dashboard.profile.edit.admin-profile-edit",compact("data"));
    //     // return ResponseHelper::output("success",$data,200);
    // }

    public function profileEdit(Request $request){
        $userID = $request->session()->get("id");
        $user = AdminsProfile::where("user_id", $userID)->with("user")->first();
        return view("backend.pages.dashboard.profile-edit-page",compact("user"));
        // return ResponseHelper::output("success",$data,200);
    }

    public function profileDelete(Request $request, $id){
        $userID = $request->session()->get("id");
        $data = AdminsProfile::where("user_id", $userID)->findOrFail($id);
        $data->delete();
        return ResponseHelper::output("success","Profile Deleted Successfully",200);
    }

    public function updateAdmin(Request $request){
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
            "type" => "Admin",
        ]);
        return redirect("/dashboard/admin-list")->with("success", "Admin Updated Successfully");
    }
    catch (\Exception $e) {
        Alert::toast($e->getMessage(), 'error');
        return redirect("/dashboard/admin-list");
    }
    }

    public function profileCreateByAdmin(Request $request)
        {
            try {
                DB::beginTransaction();
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'address_one' => 'required|string',
                'address_two' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zip_code' => 'required|string',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Get the user ID and other constant fields
            $user = User::findOrFail($request->input('id'));
            $userId = $user->id;
            $type = "Admin";
            $refID = rand(10000, 99999);
            $status = "active";
            // Prepare the data to be inserted/updated
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
                "status" => $status,
            ];

            // Handle profile photo upload if present
            if ($request->hasFile("profile_photo")) {
                $img = $request->file("profile_photo");
                $file_name = $img->getClientOriginalName();
                $img_name = "{$userId}-{$file_name}";
                $img_url = "/uploads/admin/{$img_name}";

                // Save the new profile photo
                $img->move(public_path('/uploads/admin'), $img_name);
                $adminData["profile_photo"] = $img_url;

                // Delete the old profile photo if it exists
                if ($request->input("file_path")) {
                    $oldPhotoPath = public_path($request->input("file_path"));
                    if (File::exists($oldPhotoPath)) {
                        File::delete($oldPhotoPath);
                    }
                }
            }
            

            // Update or create admin profile
           $admin = AdminsProfile::updateOrCreate(["user_id" => $userId], $adminData);
           if ($admin) {
            $user->update([
                "name" => $request->input("first_name") . " " . $request->input("last_name"),
                "phone" => $request->input("phone_number")
            ]);
            }
            DB::commit();

            // Redirect with success message
            return redirect("/dashboard/admin-list")->with("success", "Profile Updated Successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'error');
            return redirect("/dashboard/admin-list");
        }
        }

}
