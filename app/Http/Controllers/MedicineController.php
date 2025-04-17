<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Medicine;
use App\Models\MedicineType;
use Illuminate\Http\Request;
use App\Models\MedicineGroup;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class MedicineController extends Controller
{
    public function medicineListPage(){
        $groups = MedicineGroup::where("status", "active")->get();
        $medicineTypes = MedicineType::where("status", "active")->get(); 
        $companys = User::where("type", "company")->get(); 
        return view('backend.pages.medicine.medicine-list-page', compact('groups', 'medicineTypes', 'companys'));
    }

    public function getMedicineList(Request $request){
        if ($request->ajax()){
            $data = Medicine::with(['group', 'type', 'brand', 'manufacturer'])
                ->whereIn('status', ['active', 'inactive'])
                ->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('dashboard.edit-medicine', $row->id);
                    $deleteUrl = route('dashboard.delete.medicine', $row->id);
                    $btn = '<a class="btn badge-info btn-sm m-1" href="'.$editUrl.'">Edit</a>';
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
    
    

    public function createMedicinePage(){
        $groups = MedicineGroup::where("status", "active")->get();
        $medicineTypes = MedicineType::where("status", "active")->get(); 
        $companys = User::where("type", "company")->get();    
        return view("backend.pages.medicine.create-medicine-page", compact("groups", "medicineTypes", "companys"));
    }

    public function activeMedicine(){
        return view("backend.pages.medicine.active-medicine-page");
    }

    public function activeMedicineList(Request $request){
        if ($request->ajax()){
            $data = Medicine::with(['group', 'type', 'brand', 'manufacturer'])
                ->whereIn('status', ['active'])
                ->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $inActiveUrl = route('dasboard.medicine-inactive', $row->id);
                    $deleteUrl = route('dashboard.delete.medicine', $row->id);
                    
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

    public function editMedicine($id){
        $medicine = Medicine::findOrFail($id);
        $groups = MedicineGroup::where("status", "active")->get();
        $medicineTypes = MedicineType::where("status", "active")->get();
        $companys = User::where("type", "company")->get();
        return view("backend.pages.medicine.edit-medicine-page", compact("medicine", "groups", "medicineTypes", "companys"));
    }

    public function inactiveMedicine(){
        return view("backend.pages.medicine.inactive-medicine-page");
    }

    public function inactiveMedicineList(Request $request){
        if ($request->ajax()){
            $data = Medicine::with(['group', 'type', 'brand', 'manufacturer'])
                ->whereIn('status', ['inactive'])
                ->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $activeUrl = route('dasboard.medicine-active', $row->id);   
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

    public function medicineActive($id){
        Medicine::where("id", $id)->update(["status" => "active"]);
        return redirect()->back()->with("success", "Medicine active successfully");
    }

    public function createMedicine(Request $request){
        try {
            $request->validate([
                'medicine_name' => 'required|string|max:255',
                'manufacturer_id' => 'required|exists:users,id',
                'brand_id' => 'required|exists:users,id',
                'type_id' => 'required|exists:medicine_types,id',
                'group_id' => 'required|exists:medicine_groups,id',
                'strength' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'use_for' => 'required|string|max:255',
            ]);
    
            $userId = $request->session()->get("id");
            $data = $request->all();

            $data["status"] = "active";
            $data["user_id"] = $userId;
    
            Medicine::create([
                "medicine_name" => $request->input("medicine_name"),
                "manufacturer_id" => $request->input("manufacturer_id"),
                "brand_id" => $request->input("brand_id"),
                "type_id" => $request->input("type_id"),
                "group_id" => $request->input("group_id"),
                "strength" => $request->input("strength"),
                "description" => $request->input("description"),
                "price" => $request->input("price"),
                "use_for" => $request->input("use_for"),
                "created_by" => $userId,
                "updated_by" => $userId,
            ]);
            return response()->json([
                "status" => "success",
                "message" => "Medicine created successfully"
            ], 201);
        }
        catch (Exception $e) {
            Log::error('Medicine Creation Failed: ' . $e);
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function updateMedicine(Request $request){
        try {
            $request->validate([
                'medicine_name' => 'required|string|max:255',
                'manufacturer_id' => 'required|exists:users,id',
                'brand_id' => 'required|exists:users,id',
                'type_id' => 'required|exists:medicine_types,id',
                'group_id' => 'required|exists:medicine_groups,id',
                'strength' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'use_for' => 'required|string|max:255',
                'status' => 'required|string|max:255',
            ]);
            $id = $request->input("id");
            
            Medicine::where("id", $id)->update([
                "medicine_name" => $request->input("medicine_name"),
                "manufacturer_id" => $request->input("manufacturer_id"),
                "brand_id" => $request->input("brand_id"),
                "type_id" => $request->input("type_id"),
                "group_id" => $request->input("group_id"),
                "strength" => $request->input("strength"),
                "description" => $request->input("description"),
                "price" => $request->input("price"),
                "use_for" => $request->input("use_for"),
                "status" => $request->input("status"),
            ]);
            return redirect("/dashboard/medicine-list")->with("success", "Medicine updated successfully");
        }
        catch (Exception $e) {
            Log::error('Medicine Update Failed: ' . $e);
            Alert::toast($e->getMessage(), 'error');
            return redirect("/dashboard/medicine-list")->with("error",$e->getMessage());
            
        }
        
    }

    public function deleteMedicine($id){
        Medicine::where("id", $id)->delete();
        return redirect()->back()->with("success", "Medicine deleted successfully");
    }

    public function medicineInactive($id){
        Medicine::where("id", $id)->update(["status" => "inactive"]);
        return redirect()->back()->with("success", "Medicine inactive successfully");
    }

    public function deletedMedicine(){
        return view("backend.pages.medicine.deleted-medicine-page");
    }

    public function deletedMedicineList(Request $request){
        if ($request->ajax()){
            $data = Medicine::with(['group', 'type', 'brand', 'manufacturer'])
            ->onlyTrashed()->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $restoreUrl = route('dasboard.medicine-restore', $row->id);
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

    public function medicineRestore($id){
        Medicine::where("id", $id)->restore();
        return redirect()->back()->with("success", "Medicine restore successfully");
    }

    public function checkMedicineName(Request $request){
        $medicineName = $request->input("medicine_name");
        $medicine = Medicine::where("medicine_name", $medicineName)->exists();
        return response()->json(["exists" => $medicine]);
    }
}
