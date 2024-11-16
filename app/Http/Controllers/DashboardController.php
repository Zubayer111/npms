<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AdminsProfile;
use App\Models\DoctorsProfile;
use App\Models\MedicalDocument;
use App\Models\PatientsProfile;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $sections = [
            'Admin' => 'admin',
            'Doctor' => 'doctor',
            'Patient' => 'patient',
            'Company' => 'company',
            'Patient Provider' => 'patient-provider',
        ];
        $today = Carbon::today();
        $todayPatientCount = User::whereDate("created_at", $today)->where("type","Patient")->count();
        $todayDoctorCount = User::whereDate("created_at", $today)->where("type","Doctor")->count();
        $adminCount = User::where("type","Admin")->count();
        $activeAdminCount = User::where("type","Admin")->where("status","active")->count();
        $inActiveAdminCount = User::where("type","Admin")->where("status","inactive")->count();
        $patientCount = User::where("type","Patient")->count();
        $activePatientCount = User::where("type","Patient")->where("status","active")->count();
        $inActivePatientCount = User::where("type","Patient")->where("status","inactive")->count();
        $deletedPatientCount = User::onlyTrashed()->where("type", "Patient")->where("status", "suspended")->orderByDesc("deleted_at")->count();
        $doctorCount = User::where("type","Doctor")->count();
        $activeDoctorCount = User::where("type","Doctor")->where("status","active")->count();
        $inActiveDoctorCount = User::where("type","Doctor")->where("status","inactive")->count();
        $companyCount = User::where("type","Company")->count();
        $activeCompanyCount = User::where("type","Company")->where("status","active")->count();
        $inActiveCompanyCount = User::where("type","Company")->where("status","inactive")->count();
        $todayCompanyCount = User::whereDate("created_at", $today)->where("type","Company")->count();
        $userName = session()->get("name");

        
        return view("backend.pages.dashboard.home-page", compact("adminCount","patientCount","doctorCount","companyCount","userName","activeAdminCount",
        "inActiveAdminCount","inActiveDoctorCount", "activePatientCount","inActivePatientCount",
        "deletedPatientCount", "inActiveCompanyCount","todayCompanyCount",
        "activeCompanyCount","activeDoctorCount","todayPatientCount"
        ,"todayDoctorCount","sections"));
    }

    public function profilePage(Request $request){
        if(session()->get("type") == "Admin"){
            $userID = $request->session()->get("id");
            $data = AdminsProfile::where("user_id", $userID)->with("user")->first();
            return view("backend.pages.dashboard.profile-page", compact("data"));
        }
        elseif(session()->get("type") == "Doctor"){
            $userID = $request->session()->get("id");
            $data = DoctorsProfile::where("user_id", $userID)->with("user")->first();
            return view("backend.pages.dashboard.profile-page", compact("data"));
        }
        // elseif(session()->get("type") == "Company"){
        //     $userID = $request->session()->get("id");
        //     $data = Company::where("user_id", $userID)->with("user")->first();
        //     return view("backend.pages.dashboard.profile-page", compact("data"));
        // }
        else{
            $userID = $request->session()->get("id");
            $data = PatientsProfile::where("user_id", $userID)->with("user")->first();
            $medcalDocuments = MedicalDocument::where("patient_id", $userID)->get();
            
            // return view("backend.pages.dashboard.profile-page", compact("data","medcalDocuments"));
            return view("backend.pages.dashboard.profile-page", compact("data"));
        }
    }

    public function profileEditPage(){
        return view("backend.pages.dashboard.profile-edit-page");
    }

    public function userListPage(){
        return view("backend.pages.user.user-list-page");
    }

    public function getUserList(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['id', 'name', 'email', 'phone','type', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('dasboard.user-edit', $row->id);
                    $deleteUrl = route('dasboard.user-delete', $row->id);
                    
                    $btn = '<button type="button" id="editBtn" data-url="'.$editUrl.'" class="btn btn-primary btn-sm" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#editUserModal">
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

    public function createUserPage(){
        return view("backend.pages.user.create-user-page");
    }

    
}
