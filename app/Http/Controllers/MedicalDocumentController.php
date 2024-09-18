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
                return \DateTime::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('jS F, Y');

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

    public function uploadImageToLocal($file, $path, $prefix)
        {
            $file_name = $prefix . time() . '.' . $file->getClientOriginalExtension();
            $storage_path = $file->storeAs($path, $file_name, 'public');

            return $storage_path ? "/storage/" . $storage_path : null;
        }

        public function uploadFile($file, $path, $prefix)
        {
            $file_name = $prefix . time() . '.' . $file->getClientOriginalExtension();
            $storage_path = $file->storeAs($path, $file_name, 'public');

            return $storage_path ? "/storage/" . $storage_path : null;
        }


    public function store(PatientMedicalRequest $request)
        {
            try {
                $patient_id = $request->session()->get("id");

                // Check if the request contains files
                if ($request->hasFile('file')) {
                    $file_paths = []; // To store all file paths if multiple uploads
                    
                    foreach ($request->file('file') as $file) {
                        $file_extension = $file->getClientOriginalExtension();

                        // Handle file upload based on its type
                        if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                            $file_path = $this->uploadImageToLocal($file, '/patient/'.$patient_id.'/files/', 'file_');
                        } else {
                            $file_path = $this->uploadFile($file, '/patient/'.$patient_id.'/files/', 'file_');
                        }

                        // Check if the file was successfully uploaded
                        if (!$file_path) {
                            throw new Exception('File upload failed.');
                        }

                        $file_paths[] = $file_path;

                        // Store each file's metadata in the database
                        MedicalDocument::create([
                            'patient_id' => $patient_id,
                            'file_type' => $request->file_type,
                            'file_name' => $request->file_name,
                            'file_extension' => $file_extension,
                            'asset_path' => $file_path, // Ensure the correct path is stored here
                            'uploaded_by' => $patient_id,
                        ]);
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Documents uploaded successfully',
                    'file_paths' => $file_paths // Return the file paths for confirmation
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
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
