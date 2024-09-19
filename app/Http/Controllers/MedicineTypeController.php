<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\MedicineType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class MedicineTypeController extends Controller
{
    public function medicineTypeListPage(){
        return view("backend.pages.medicine_type.medicine-type-list-page");
    }

    public function getMedicineTypeList(Request $request){
        if ($request->ajax()){
            $data = MedicineType::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('dashboard.edit-medicine-type', $row->id);
                    $deleteUrl = route('dashboard.delete.medicine-type', $row->id);
                    $btn = '<button type="button" id="editBtn" data-url="'.$editUrl.'" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editMedicineTypeModal">
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
    
    public function createMedicineTypePage(){
        return view("backend.pages.medicine_type.create-medicine-type-page");
    }

    public function createMedicineType(Request $request){ 
        try {
            $request->validate([
                "type_name" => "required",
                "description" => "required"
            ]);
            $userId = $request->session()->get("id");
            MedicineType::create([
                "type_name" => $request->input("type_name"),
                "description" => $request->input("description"),
                "created_by" => $userId,
                "updated_by" => $userId,
                "status" => "active"
            ]);
            return response()->json([
                "status" => "success",
                 "message" => "Medicine Type Created Successfully"
                ]);
        }
        catch (Exception $e) {
            return response()->json([
                "status" => "error",
                 "message" => $e->getMessage()
            ], 500);
        }
        //return redirect("/dashboard/medicine-type-list")->with("success", "Medicine Type Created Successfully");
     }

     public function editMedicineType($id){
        $data = MedicineType::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function updateMedicineType(Request $request){
        try {
            $request->validate([
                "type_name" => "required",
                "description" => "required"
            ]);
            $id = $request->input("type_id");
            $type = MedicineType::findOrFail($id);
            $type->update([
                "type_name" => $request->input("type_name"),
                "description" => $request->input("description"),
                "status" => $request->input("status")
            ]);
            return response()->json([
                "status" => "success",
                 "message" => "Medicine Type Updated Successfully"
                ]);
        }
        catch (Exception $e) {
            return response()->json([
                "status" => "error",
                 "message" => $e->getMessage()
            ], 500);
        }
    }

    public function deleteMedicineType($id){
        $type = MedicineType::findOrFail($id);
        $type->delete();
        return redirect()->back()->with("success", "Medicine Type Deleted Successfully");
    }

    public function activeMedicineType(){
        return view("backend.pages.medicine_type.active-medicine-type-page");
    }

    public function activeMedicineTypeList(Request $request){
        if ($request->ajax()){
            $data = MedicineType::where("status", "active")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $inActiveUrl = route('dasboard.medicine-type-inactive', $row->id);
                    $deleteUrl = route('dashboard.delete.medicine-type', $row->id);
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

    public function medicineTypeInactive($id){
        $type = MedicineType::findOrFail($id);
        $type->update([
            "status" => "inactive"
        ]);
        return redirect()->back()->with("success", "Medicine Type Inactive Successfully");
    }

    public function inactiveMedicineType(){
        $types = MedicineType::where("status", "inactive")->get();
        return view("backend.pages.medicine_type.inactive-medicine-type-page", compact("types"));
    }

    public function inactiveMedicineTypeList(Request $request){
        if ($request->ajax()){
            $data = MedicineType::where("status", "inactive")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $activeUrl = route('dasboard.medicine-type-active', $row->id); 
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

    public function medicineTypeActive($id){
        $type = MedicineType::findOrFail($id);
        $type->update([
            "status" => "active"
        ]);
        return redirect()->back()->with("success", "Medicine Type Active Successfully");
    }

    public function deletedMedicineType(){
        return view("backend.pages.medicine_type.deleted-medicine-type-page");
    }

    public function deletedMedicineTypeList(Request $request){
        if ($request->ajax()){
            $data = MedicineType::onlyTrashed()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $restoreUrl = route('dasboard.medicine-type-restore', $row->id); 
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

    public function medicineTypeRestore($id){
        $type = MedicineType::onlyTrashed()->findOrFail($id);
        $type->restore();
        return redirect()->back()->with("success", "Medicine Type Restored Successfully");
    }

    public function checkMedicineTypeName(Request $request){
        $typeName = $request->input("type_name");
        $type = MedicineType::where("type_name", $typeName)->exists();
        return response()->json(["exists" => $type]);
    }
        

}
