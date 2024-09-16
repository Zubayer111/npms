<?php

namespace App\Http\Controllers;

use App\Http\Requests\Patient\PatientMedicalRequest;
use Exception;
use Illuminate\Http\Request;
use App\Models\MedicalDocument;
use App\Traits\UploadTrait;
use Yajra\DataTables\DataTables;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MedicalDocumentController extends Controller
{

    use UploadTrait;

    public function index()
    {
        return view("backend.pages.patient.medicale-doc-page");
    }

    // public function medicalDocumentList(Request $request)
    // {
    //     if (request()->ajax()) {
    //         $query =  MedicalDocument::where('patient_id', $request->session()->get("id"))->query();
            

    //         $table = DataTables::of($query);

    //         // $table->editColumn('actions', function ($row) {
    //         //     $actionTemplate = 'dentist-office._actions_template';
    //         //     $routeKey = 'dentist-office';
    //         //     return view($actionTemplate, compact('row', 'routeKey'));
    //         // });
    //         // $table->rawColumns(['person_name', 'person_email']);

    //         return $table->make(true);
    //     }

    //     return view('dashboard.medical-documents-page');
    // }


    public function medicalDocumentList(Request $request)
{
    if ($request->ajax()) {
        $query = MedicalDocument::where('patient_id', $request->session()->get('id'));

        return DataTables::of($query)
            ->editColumn('created_at', function ($row) {
                return \DateTime::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('jS F, Y H:i:s A');
            })
            ->addColumn('actions', function ($row) {
                return view('backend.components.dashboard.profile.tab-content.patient._medical_document_action', compact('row'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    return view('dashboard.medical-documents-page');
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
    public function store(PatientMedicalRequest $request)
    {
        try {
            $patient_id = $request->session()->get("id");

            if($request->hasFile('file')) {
                $file = $request->file('file');
                if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                    $file_path = $this->uploadImageToLocal($file, '/patient/'.$patient_id.'/files/', 'file_');
                } else {
                    $file_path = $this->uploadFile($file, '/patient/'.$patient_id.'/files/', 'file_');
                }
            }

            MedicalDocument::create([
                'patient_id' => $patient_id,
                'file_type' => $request->file_type,
                'file_name' => $request->file_name,
                'asset_path' => $file_path,
                'uploaded_by' => $patient_id,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Documents uploaded successfully'
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
