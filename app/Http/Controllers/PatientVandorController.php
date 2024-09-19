<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PatientVandor;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class PatientVandorController extends Controller
{
    public function patientVandorListPage(){
        return view("backend.pages.patient_vendors.vendor-list-page");
    }

    public function getPatientVandorList(Request $request) {
        if ($request->ajax()) {
            $data = PatientVandor::orderByDesc("updated_at")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editUrl = route('dashboard.edit-patient-vandor', $row->id);
                    $deleteUrl = route('dashboard.delete-patient-vandor', $row->id);
                    $viewUrl = route('dashboard.view-patient-vandor', $row->id);
                    $patienUrl = route('dashboard.get-vandor-patients');
                    
                   
                    $btn = '<button type="button" id="viewBtn" data-url="' . $viewUrl . '" class="btn btn-info btn-sm mb-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#viewPatientVandorModal">
                                View
                            </button>';
                    $btn .= '<a href="' . $patienUrl . '" class="btn btn-success btn-sm mb-2">Patients</a>';
                    
                    $btn .= '<button type="button" id="editBtn" data-url="' . $editUrl . '" class="btn btn-primary btn-sm mb-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#editPatientVandorModal">
                                Edit
                            </button>';
                    
                    $btn .= '<form id="delete-form-' . $row->id . '" action="' . $deleteUrl . '" method="POST" style="display: inline;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="button" class="btn badge-danger btn-sm" onclick="confirmDelete(' . $row->id . ')">Delete</button>
                             </form>';
                    
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function viewPatientVandor($id){
        $data = PatientVandor::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    

    public function createPatientVandor(Request $request){
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:patient_vandors',
                'phone' => 'required|unique:patient_vandors',
                'address' => 'required',
                'contact_person' => 'required',
            ]);
            
            $userId = $request->session()->get("id");
            $token = random_bytes(32);
            $secret_key = random_bytes(32);
            
            $data = PatientVandor::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'fax' => $request->fax,
                'contact_person' => $request->contact_person,
                'token' => $token,
                'secret_key' => $secret_key,
                'created_by' => $userId,
                'updated_by' => $userId,
                'status' => "active",
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Vendor created successfully.',
                'data' => $data 
            ]);
            
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], );
        }
    }

    // public function createPatientVandor(Request $request){
    //     try {
    //         // Validate the request data
    //         $validator = Validator::make($request->all(), [
                
    //             'name' => 'required|string|max:255',
    //             'email' => 'required|email|unique:patient_vandors,email',
    //             'phone' => 'required|string|max:20|unique:patient_vandors,phone',
    //             'address' => 'required|string',
    //             'contact_person' => 'required|string|max:255',
    //         ]);

    //         // Check if validation fails
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Validation failed',
    //                 'errors' => $validator->errors()
    //             ], 422); // Unprocessable Entity
    //         }

    //         $userId = $request->session()->get("id");

    //         // Create a new PatientVendor
    //         $patientVendor = PatientVandor::create([
    //             'user_id' => $userId,
    //             'name' => $request->input('name'),
    //             'email' => $request->input('email'),
    //             'phone' => $request->input('phone'),
    //             'address' => $request->input('address'),
    //             'fax' => $request->input('fax'),
    //             'contact_person' => $request->input('contact_person'),
    //         ]);

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Patient Vendor created successfully.',
    //             'data' => $patientVendor
    //         ]);
    //     } catch (Exception $e) {
    //         // Handle any exceptions that occur during the creation
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ], 500); // Internal Server Error
    //     }
    // }
    
    
    public function editPatientVandor($id){
        $data = PatientVandor::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function activePatientVandor(){
        return view('backend.pages.patient_vendors.active-vendor-page');
    }

    public function activePatientVandorList(Request $request){
        if ($request->ajax()){
            $data = PatientVandor::where("status", "active")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $inActiveUrl = route('dasboard.patient-vandor-inactive', $row->id);
                    $deleteUrl = route('dashboard.delete-patient-vandor', $row->id);
                    $btn = '<form id="inactive-form-'.$row->id.'" action="'.$inActiveUrl.'" method="POST" style="display: inline;">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="button" class="btn badge-warning btn-sm mb-2" onclick="confirmInactive('.$row->id.')">Inactive</button>
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

    public function updatePatientVandor(Request $request){
        try {
            
        
        $data = PatientVandor::findOrFail($request->id);
        $data->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'fax' => $request->fax,
            'contact_person' => $request->contact_person,
            'status' => $request->status,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Patient Vendor updated successfully.',
            'data' => $data
        ]);
    }
    catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], );
    }
    }
    public function inactivePatientVandor(){
        return view('backend.pages.patient_vendors.inactive-vendor-page');
    }
    

    public function patientVandorInactive($id){
        $type = PatientVandor::findOrFail($id);
        $type->update([
            "status" => "inactive"
        ]);
        return redirect()->back()->with("success", "Patient Vendor Inactive Successfully");
    }
    public function inactivePatientVandorList(Request $request){
        if ($request->ajax()){
            $data = PatientVandor::where("status", "inactive")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $activeUrl = route('dasboard.patient-vandor-active', $row->id); 
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

    public function deletedPatientVandor(){
        return view('backend.pages.patient_vendors.deleted-vendor-page');
    }

    public function deletedPatientVandorList(Request $request){
        if ($request->ajax()){
            $data = PatientVandor::onlyTrashed()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $restoreUrl = route('dasboard.patient-vandor-restore', $row->id); 
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

    

    public function deletePatientVandor($id){
        $vandor = PatientVandor::findOrFail($id);
        $vandor->delete();
        toast('Patient Vendor has been deleted','success');
        return redirect()->back();
    }

    public function patientVandorActive($id){
        $type = PatientVandor::findOrFail($id);
        $type->update([
            "status" => "active"
        ]);
        return redirect()->back()->with("success", "Patient Vendor Active Successfully");
    }


    public function patientVandorRestore($id){
        $type = PatientVandor::onlyTrashed()->findOrFail($id);
        $type->restore();
        toast('Patient Vendor has been restored','success');
        return redirect()->back();
    }


    public function getPatientVandor(){
        return view('backend.pages.patient_vendors.view-vandor-patients-page');
    }
}
