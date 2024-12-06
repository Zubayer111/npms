<?php

namespace App\Http\Controllers;

use App\Models\DoctorsProfile;
use Log;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Medicine;
use App\Models\MedicineDose;
use Illuminate\Http\Request;
use App\Models\PatientAdvice;
use App\Models\PatientsProfile;
use Illuminate\Support\Facades\DB;
use App\Models\PatientPrescription;
use Darryldecode\Cart\Cart as CartCart;
use Yajra\DataTables\Facades\DataTables;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class PrescritionsController extends Controller
{
    public function newPrescritionsPage(){
        $patients = PatientsProfile::all(); 
        return view("backend.pages.prescriptions.new-prescriptions-page", compact("patients"));
    }

    public function dosesByType($id){
        $doses = MedicineDose::where("medicine_type",$id)->get();
        return response()->json($doses);
    }

    public function postAddToCart(Request $request) 
    {
        $userID = $request->session()->get('id');

        Cart::session($userID)->add([
            'id'       => uniqid(), 
            'name'     => $request->input('medicine_name'),
            'price'    => 0, 
            'quantity' => 1, 
            'attributes' => [
                'patient_id'    => $request->input('patient_id'),
                'dose'          => $request->input('dose') ?? $request->input('cust_dose'),
                'duration'      => $request->input('duration'),
                'duration_unit' => $request->input('duration_unit'),
                'instruction'   => $request->input('instruction'),
            ],
            'associatedModel' => null, 
        ]);

        $allPrescriptions = Cart::session($userID)->getContent();
        
        $html = view('backend.components.prescriptions.table.medicine-list', compact('allPrescriptions'))->render();

        return response()->json(['html' => $html]);
    }

    public function postDisplayToCart(Request $request) {
        $userID = $request->session()->get('id');
 
        $allPrescriptions = Cart::session($userID)->getContent();

        $html = view('backend.components.prescriptions.table.medicine-list', compact('allPrescriptions'))->render();

        return response()->json(['html' => $html]);
    }

    public function postRemoveToCart(Request $request) 
    {
        $userID = $request->session()->get('id'); 
        $medicineId = $request->input('id');
        $cart = Cart::session($userID);
        $item = $cart->get($medicineId);
        $cart->remove($medicineId);
        $allPrescriptions = $cart->getContent();
        $html = view('backend.components.prescriptions.table.medicine-list', compact('allPrescriptions'))->render();
        return response()->json(['html' => $html]);
    }


    public function postSavePrescription(Request $request)
    {
        // Retrieve cart content for the current session
        $userID = $request->session()->get('id');
        $cartContent = Cart::session($userID)->getContent();

        // Check if the cart is empty
        if (!$cartContent || $cartContent->isEmpty()) {
            return response()->json(['error' => 'Please Add Patient Medicines...'], 400);
        }

        // Begin database transaction
        DB::beginTransaction();
        try {
            // Get the first item to retrieve the patient ID
            $firstItem = $cartContent->first();
            // return $request->all();
            // Create a new PatientAdvice record
            $advice = PatientAdvice::create([
                "patient_id" => $firstItem->attributes->patient_id,
                "advice" => $request->input("advice"),
                "investigation" => $request->input("investigation"),
                "disease_description" => $request->input("disease_description"),
                "clinical_diagnosis" => $request->input("clinical_diagnosis"),
                "next_meeting_date" => $request->input("next_meeting_date"),
                "next_meeting_indication" => $request->input("next_meeting_indication"),
                "guide_to_prescription" => $request->input("guide_to_prescription"),
                "created_by" => $userID,
                "updated_by" => $userID
            ]);

            // Loop through cart items and create PatientPrescription records
            foreach ($cartContent as $medicine) {
                PatientPrescription::create([
                    "patient_id" => $medicine->attributes->patient_id,
                    "medicine_name" => $medicine->name,
                    "dose" => $medicine->attributes->dose,
                    "cust_dose" => $medicine->attributes->cust_dose,
                    "duration_unit" => $medicine->attributes->duration_unit,
                    "instruction" => $medicine->attributes->instruction,
                    "duration" => $medicine->attributes->duration,
                    "created_by" => $userID,
                    "updated_by" => $userID
                ]);
            }

            // Clear the cart
            Cart::session($userID)->clear();

            // Commit the transaction
            DB::commit();
            return response()->json(['message' => 'Prescription saved successfully!'], 200);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();
            return response()->json(['error' => 'Failed to save prescription.', 'details' => $e->getMessage()], 500);
        }
    }

    public function prescritionsListPage() {
       return view("backend.pages.prescriptions.all-prescriptions");
    }

    public function getPrescritionsList(Request $request) {
        if($request->ajax()) {
            $userID = $request->session()->get('id');
            $prescriptions = PatientAdvice::with('patient')->where('created_by', $userID)->get();
            return DataTables::of($prescriptions)
                ->addIndexColumn()
                ->addColumn('patient_name', function ($row) {
                    return $row->patient ? $row->patient->name : 'N/A'; // Adjust 'name' to the actual column for the patient's name
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d-M-Y H:i'); // Format as 'DD-MM-YYYY HH:MM'
                })
                ->addColumn('action', function($row){
                    $activeUrl = route('dashboard.view-prescritions', [
                        'id' => $row->id,
                        'date' => Carbon::parse($row->created_at)->format('Y-m-d'),
                    ]);
                    
                    $btn = '<a href="'.$activeUrl.'" class="btn badge-success btn-sm">View Prescription</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    } 

    public function viewPrescritions(Request $request, $id, $date) {
        $userID = $request->session()->get('id');
        $doctor = DoctorsProfile::find($userID);
        $formattedDate = Carbon::parse($date)->format('Y-m-d');
    
    // Retrieve the data
    $patient = PatientsProfile::find($id); // Assuming 'User' model represents patients
    $prescriptionData = PatientPrescription::where('patient_id', $id)
        ->whereDate('created_at', Carbon::parse($date)->toDateString())
        ->get();
    $advice = PatientAdvice::where('patient_id', $id)
        ->whereDate('created_at', Carbon::parse($date)->toDateString())
        ->first();

    // Pass data to the view
    return view('backend.pages.prescriptions.prescription', compact(
        'patient',
         'prescriptionData',
          'advice',
           'formattedDate',
           'doctor'
        ));
    }

}
