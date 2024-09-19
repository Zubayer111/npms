<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\MedicineGroup;
use Yajra\DataTables\DataTables;

class MedicineGroupeController extends Controller
{
    public function medicineGroupListPage(){
        return view("backend.pages.medicine_group.group-list-page");
    }

    public function getMedicineGroupList(Request $request){
        if ($request->ajax()){
            $data = MedicineGroup::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('dashboard.edit-medicine-group', $row->id);
                    $deleteUrl = route('dashboard.delete.group', $row->id);
                    $btn = '<button type="button" id="editBtn" data-url="'.$editUrl.'" class="btn btn-primary btn-sm" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#editGroupModal">
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

    public function createMedicineGroupPage(){
        return view("backend.pages.medicine_group.create-group-page");
    }

    public function activeMedicineGroup(){
        return view("backend.pages.medicine_group.active-group-page");
    }

    public function activeMedicineGroupList(Request $request){
        if ($request->ajax()){
            $data = MedicineGroup::where("status", "active")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $inActiveUrl = route('dasboard.group-inactive', $row->id);
                    $deleteUrl = route('dashboard.delete.group', $row->id);
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

    public function inactiveMedicineGroup(){
        return view("backend.pages.medicine_group.inactive-group-page");
    }

    public function inactiveMedicineGroupList(Request $request){
        if ($request->ajax()){
            $data = MedicineGroup::where("status", "inactive")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $activeUrl = route('dasboard.group-active', $row->id); 
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

    public function deletedMedicineGroup(){
        return view("backend.pages.medicine_group.deleted-group-page");
    }

    public function deletedMedicineGroupList(Request $request){
        if ($request->ajax()){
            $data = MedicineGroup::onlyTrashed()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $restoreUrl = route('dasboard.group-restore', $row->id); 
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
    public function createMedicineGroup(Request $request){
        try {
            $request->validate([
                "group_name" => "required|string",
                "description" => "required|string"
            ]);
            $userId = $request->session()->get("id");
            MedicineGroup::create([
                "group_name" => $request->input("group_name"),
                "description" => $request->input("description"),
                "status" => "active",
                "created_by" => $userId,
                "updated_by" => $userId
            ]);
            return response()->json([
                "status" => "success",
                "message" => "Medicine Group Created Successfully"
            ]);
        }
        
        catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 500);
        }
        
    }

    public function editMedicineGroup($id){
        $data = MedicineGroup::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function updateMedicineGroup(Request $request){

        try {
            $request->validate([
                "group_name" => "required|string",
                "description" => "required|string"
            ]);
            $group = MedicineGroup::findOrFail($request->input("group_id"));
            $group->group_name = $request->input("group_name");
            $group->description = $request->input("description");
            $group->status = $request->input("status");
            $group->save();
            return response()->json([
                "status" => "success",
                "message" => "Medicine Group Updated Successfully"
            ]);
        }
        
        catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteMedicineGroup($id){
        $group = MedicineGroup::findOrFail($id);
        $group->delete();
        toast('Medicine Group has been deleted','success');
        return redirect()->back();
    }

    public function groupInactive($id){
        $group = MedicineGroup::findOrFail($id);
        $group->status = "inactive";
        $group->save();
        toast('Medicine Group has been deactivated','success');
        return redirect()->back();
    }

    public function groupActive($id){
        $group = MedicineGroup::findOrFail($id);
        $group->status = "active";
        $group->save();
        toast('Medicine Group has been activated','success');
        return redirect()->back();
    }

    public function groupRestore($id){
        $group = MedicineGroup::withTrashed()->findOrFail($id);
        $group->restore();
        toast('Medicine Group has been restored','success');
        return redirect()->back();
    }

    public function checkGroupName(Request $request){
        $groupName = $request->input("group_name");
        $group = MedicineGroup::where("group_name", $groupName)->exists();
        return response()->json(["exists" => $group]);
    }
}
