<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Diseases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class DiseasesController extends Controller
{
    public function diseaseListPage()
    {
        return view("backend.pages.disease.disease-list-page");
    }

    public function getDiseaseList(Request $request)
    {
        if ($request->ajax()){
            $data = Diseases::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('dashboard.edit-disease', $row->id);
                    $deleteUrl = route('dashboard.delete.disease', $row->id);
                    $btn = '<button type="button" id="editBtn" data-url="'.$editUrl.'" class="btn btn-primary btn-sm" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#editDisease">
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

    public function createDiseasePage()
    {
        return view("backend.pages.disease.create-disease-page");
    }

    public function activeDisease(){
        return view("backend.pages.disease.active-disease-page");
    }

    public function activeDiseaseList(Request $request){
        if ($request->ajax()){
            $data = Diseases::where("status", "active")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $inActiveUrl = route('dasboard.disease-inactive', $row->id);
                    $deleteUrl = route('dashboard.delete.disease', $row->id);
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

    public function diseaseInactive($id){
        $disease = Diseases::findOrFail($id);
        $disease->status = "inactive";
        $disease->save();
        return redirect()->back()->with("success", "Disease Inactive Successfully");
    }

    public function inactiveDisease(){
        return view("backend.pages.disease.inactive-disease-page");
    }

    public function inactiveDiseaseList(Request $request){
        if ($request->ajax()){
            $data = Diseases::where("status", "inactive")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $activeUrl = route('dasboard.disease-active', $row->id); 
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

    public function diseaseActive($id){
        $disease = Diseases::findOrFail($id);
        $disease->status = "active";
        $disease->save();
        return redirect()->back()->with("success", "Disease Active Successfully");
    }

    public function createDisease(Request $request)
    {
        try {
            $request->validate([
                "disease_name" => "required|unique:diseases,disease_name",
                "description" => "required",
            ]);
    
            $userId = $request->session()->get("id");
            
            Diseases::create([
                "disease_name" => $request->input("disease_name"),
                "description" => $request->input("description"),
                'created_by' => $userId,
                'updated_by' => $userId,
                "status" => "active",
            ]);
            return response()->json([
                "status" => "success",
                "message" => "Disease Created Successfully"
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" =>  $e->getMessage()
            ], 500);
        }
    }

    public function editDisease($id)
    {
        $data = Diseases::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    

    public function updateDisease(Request $request)
    {
        try {
            $request->validate([
                "disease_name" => "required",
                "description" => "required",
            ]);
    
            $id = $request->input("disease_id");
            Diseases::where("id", $id)->update([
                "disease_name" => $request->input("disease_name"),
                "description" => $request->input("description"),
                "status" => $request->input("status"),
            ]);

            return response()->json([
                "status" => "success",
                "message" => "Disease Updated Successfully"
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" =>  $e->getMessage()
            ], 500);
        }
    }

    public function deleteDisease($id)
    {
        $disease = Diseases::findOrFail($id);
        $disease->delete();
        return redirect()->back()->with("success", "Disease Deleted Successfully");
    }

    public function deletedDisease(){    
        return view("backend.pages.disease.deleted-disease-page");
    }

    public function deletedDiseaseList(Request $request){
        if ($request->ajax()){
            $data = Diseases::onlyTrashed()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $restoreUrl = route('dasboard.disease-restore', $row->id); 
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

    public function diseaseRestore($id){
        $disease = Diseases::onlyTrashed()->where("id", $id)->first();
        $disease->restore();
        return redirect()->back()->with("success", "Disease Restore Successfully");
    }

    public function checkDiseaseName(Request $request)
    {
        $disease_name = $request->input('disease_name');
        $exists = Diseases::where('disease_name', $disease_name)->exists();
        return response()->json(['exists' => $exists]);
    }
}
