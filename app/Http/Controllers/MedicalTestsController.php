<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\MedicalTests;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MedicalTestsController extends Controller
{
    public function medicalTestListPage(){
        return view("backend.pages.test.test-list-page");
    }

    public function getMedicalTestList(Request $request){
        if ($request->ajax()){
            $data = MedicalTests::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('dashboard.edit-medical-test', $row->id);
                    $deleteUrl = route('dashboard.delete.medical-test', $row->id);
                    $btn = '<button type="button" id="editBtn" data-url="'.$editUrl.'" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editMedicalTest">
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

    public function createMedicalTestPage(){
        return view("backend.pages.test.create-test-page");
    }


    public function createMedicalTest(Request $request){
        try {
            $request->validate([
                "test_name" => "required|unique:medical_tests",
                "description" => "required",
            ]);
    
            $userId = $request->session()->get("id");
            MedicalTests::create([
                "user_id" => $userId,
                "test_name" => $request->input("test_name"),
                "description" => $request->input("description"),
                "status" => "active",
            ]);
            return response()->json([
                "status" => "success",
                "message" => "Test Created Successfully",
            ]);
        }
        catch (Exception $exception){
            return response()->json([
                "status" => "error",
                "message" => $exception->getMessage(),
            ]);
        }
    }

    public function checkMedicalTestName(Request $request){
        $testName = $request->input("test_name");
        $test = MedicalTests::where("test_name", $testName)->exists();
        return response()->json(["exists" => $test]);
    }

    public function editMedicalTest($id){
        $data = MedicalTests::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function updateMedicalTest(Request $request){
        try {
            $request->validate([
                "test_name" => "required",
                "description" => "required",
            ]);
            $test = MedicalTests::findOrFail($request->input("test_id"));
            $test->update([
                "test_name" => $request->input("test_name"),
                "description" => $request->input("description"),
                "status" => $request->input("status"),
            ]);
            return response()->json([
                "status" => "success",
                "message" => "Test Updated Successfully",
            ]);
        }
        catch (Exception $exception){
            return response()->json([
                "status" => "error",
                "message" => $exception->getMessage(),
            ]);
        }
    }

    public function deleteMedicalTest($id){
        $test = MedicalTests::findOrFail($id);
        $test->delete();
        return redirect()->back()->with("success", "Test Deleted Successfully");
    }

    public function activeMedicalTest(){
        return view("backend.pages.test.active-test-page");
    }

    public function activeMedicalTestList(Request $request){
        if ($request->ajax()){
            $data = MedicalTests::where("status", "active")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $inActiveUrl = route('dasboard.medical-test-inactive', $row->id);
                    $deleteUrl = route('dashboard.delete.medical-test', $row->id);
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

    public function medicalTestInactive($id){
        $test = MedicalTests::findOrFail($id);
        $test->update([
            "status" => "inactive",
        ]);
        return redirect()->back()->with("success", "Test Inactive Successfully");
    }

    public function inactiveMedicalTest(){
        return view("backend.pages.test.inactive-test-page");
    }

    public function inactiveMedicalTestList(Request $request){
        if ($request->ajax()){
            $data = MedicalTests::where("status", "inactive")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $activeUrl = route('dasboard.medical-test-active', $row->id);
                    $btn = '<form id="active-form-'.$row->id.'" action="'.$activeUrl.'" method="POST" style="display: inline;">
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

    public function medicalTestActive($id){
        $test = MedicalTests::findOrFail($id);
        $test->update([
            "status" => "active",
        ]);
        return redirect()->back()->with("success", "Test Active Successfully");
    }

    public function deletedMedicalTest(){
        return view("backend.pages.test.deleted-test-page");
    }

    public function deletedMedicalTestList(Request $request){
        if ($request->ajax()){
            $data = MedicalTests::onlyTrashed()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $restoreUrl = route('dasboard.medical-test-restore', $row->id);
                    $btn = '<form id="restore-form-'.$row->id.'" action="'.$restoreUrl.'" method="POST" style="display: inline;">
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

    public function medicalTestRestore($id){
        $test = MedicalTests::onlyTrashed()->findOrFail($id);
        $test->restore();
        return redirect()->back()->with("success", "Test Restored Successfully");
    }
}
