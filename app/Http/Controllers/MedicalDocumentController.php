<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\MedicalDocument;
use Yajra\DataTables\DataTables;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MedicalDocumentController extends Controller
{

    public function index()
    {
        return view("backend.pages.patient.medicale-doc-page");
    }

    public function medicalDocumentList(Request $request)
    {
        if ($request->ajax()){
            $data = MedicalDocument::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $deleteUrl = route('dashboard.medical-documents-delete', $row->id);
                    $viewUrl = route('dashboard.medical-documents-view', $row->id);
                    $downlUrl = route('dashboard.medical-documents-download', $row->id);

                    $btn = '<a href="'.$downlUrl.'" class="btn badge-success btn-sm ml-2">Download</a>';
                    $btn .= '<button type="button" id="" data-url="'.$viewUrl.'" class="viewBtn btn btn-primary btn-sm ml-1" data-toggle="modal" data-target="#documentModal">
                                <div>View</div>
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

    private function getAllowedExtensions($file_type)
    {
        switch ($file_type) {
            case 'image':
                return ['jpg', 'jpeg', 'png'];
            case 'pdf':
                return ['pdf'];
            case 'doc':
                return ['doc', 'docx'];
            case 'zip':
                return ['zip'];
            default:
                return [];
        }
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip',
                'file_type' => 'required|string|in:image,pdf,doc,zip',
            ]);
            
            $patient_id = $request->session()->get("id");
            $uploaded_by = $request->session()->get("id");
            $patient_mobile = $request->session()->get("name");
            $file_type = $request->file_type;
            $docName = $request->input('file_name');
    
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileExtension = $file->getClientOriginalExtension();
                    
                    $allowedExtensions = $this->getAllowedExtensions($file_type);
    
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        return redirect()->back()->with('error', 'Invalid file type for selected category');
                    }
                    $fileName = time() . '_' . $file->getClientOriginalName();
    
                    $filePath = "uploads/patient/{$patient_mobile}/{$fileName}";
                    $file->move(public_path("uploads/patient/{$patient_mobile}"), $fileName);
    
                    MedicalDocument::create([
                        'patient_id' => $patient_id,
                        'file_type' => $fileExtension,
                        'file_name' => $docName,
                        'asset_path' => $filePath,
                        'uploaded_by' => $uploaded_by,
                    ]);
                }
            }
    
            return response()->json([
                'status' => 'success',
                'message' => 'Documents uploaded successfully',  
            ], 200);
        } 
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 200);
        }
        
    }

    public function destroy($id)
    {
        $document = MedicalDocument::findOrFail($id);
        $document->delete();
        return redirect()->back()->with('success', 'Document deleted successfully');
    }

    public function download($id): BinaryFileResponse
    {
        $document = MedicalDocument::findOrFail($id);
        $filePath = public_path($document->asset_path);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found');
        }

        return response()->download($filePath);
    }

    public function view($id)
    {
        $document = MedicalDocument::findOrFail($id);

        $filePath = public_path($document->asset_path);

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $mimeType = mime_content_type($filePath);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->file_name . '"'
        ]);
    }


}
