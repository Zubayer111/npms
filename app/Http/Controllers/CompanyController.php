<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\UserInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyController extends Controller
{
    public function createCompanyPage(){
        return view("backend.pages.company.create-company-page");
    }

    public function createCompany(Request $request){
        try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|string|min:10|unique:users',
            'type' => 'required',
        ]);
        
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'type' => $request->input('type'),
        ]);
        
        $email = $user->email;
        $count = User::where("email", "=", $email)->count();
        if($count==1){
             Mail::to($email)->send(new UserInfo( [
                "name" => $user->name,
                "email" => $user->email,
                "password" => $request->input('password'),
            ]));
           
            return response()->json([
                'status' => 'success',
                'message' => 'Doctor created successfully & An email has been sent to the provided email address',        
            ], 200);
        }
    } catch (Exception $e) {
        return response()->json([
            "status" => "error",
            "message" => $e->getMessage(),
        ], 500);
    }

    }
    public function companyListPage(){
        return view("backend.pages.company.company-list-page");
    }

    public function getCompanyList(Request $request){
        if ($request->ajax()) {
            $companies = User::where("type", "Company")->orderByDesc("updated_at")->get();
            return DataTables::of($companies)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('dashboard.edit-company', $row->id);
                    $deleteUrl = route('dasboard.user-delete', $row->id);
                    $viewUrl = route('dasboard.view-company', $row->id);

                    $btn = '<button type="button" id="viewBtn" data-url="'.$viewUrl.'" class="btn btn-success btn-sm m-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#viewUserModal">
                                <div>View</div>
                            </button>';
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

    public function viewCompany($id){
        $data = User::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function activeCompany(){
        return view("backend.pages.company.active-company-page");
    }

    public function activeCompanyList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "Company")->where("status", "active")->orderByDesc("updated_at")->get();
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

    public function inactiveCompany(){
        return view("backend.pages.company.inactive-company-page");
    }

    public function inactiveCompanyList(Request $request){
        if ($request->ajax()) {
            $data = User::where("type", "Company")->where("status", "inactive")->orderByDesc("updated_at")->get();
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

    public function deletedCompany(){
        return view("backend.pages.company.deleted-company-page");
    }

    public function deletedCompanyList(Request $request){
        if ($request->ajax()) {
            $data = User::onlyTrashed()
                ->where("type", "Company")
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

    public function editCompany($id){
        $data = User::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function updateCompany(Request $request){
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
            "type" => "Company",
        ]);
        return redirect("/dashboard/company-list")->with("success", "Doctor Updated Successfully");
    }
}
