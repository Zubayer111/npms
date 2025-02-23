<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Medicine;
use App\Models\MedicineDose;
use Illuminate\Http\Request;
use App\Models\PatientAdvice;
use App\Models\DoctorsProfile;
use App\Models\PatientsProfile;
use Illuminate\Support\Facades\DB;
use App\Models\PatientPrescription;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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
        Log::info('Retrieved user ID from session.', ['userID' => $userID]);

        // Adding the prescription to the cart
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

        Log::info('Medicine added to cart.', [
            'userID' => $userID,
            'medicine_name' => $request->input('medicine_name'),
            'patient_id' => $request->input('patient_id'),
            'dose' => $request->input('dose') ?? $request->input('cust_dose'),
            'duration' => $request->input('duration'),
            'duration_unit' => $request->input('duration_unit'),
            'instruction' => $request->input('instruction'),
        ]);

        // Fetching all prescriptions in the cart
        $allPrescriptions = Cart::session($userID)->getContent();
        Log::info('Fetched all prescriptions from the cart.', [
            'userID' => $userID,
            'prescriptions' => $allPrescriptions->toArray(),
        ]);

        // Rendering the view
        $html = view('backend.components.prescriptions.table.medicine-list', compact('allPrescriptions'))->render();
        Log::info('Rendered prescription table view.', ['html_length' => strlen($html)]);

        // Returning JSON response
        return response()->json(['html' => $html]);
    }

    public function postDisplayToCart(Request $request) 
    {
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
        $userID = $request->session()->get('id');
        Log::info('Started saving prescription.', ['userID' => $userID]);

        $cartContent = Cart::session($userID)->getContent();

        if (!$cartContent || $cartContent->isEmpty()) {
            Log::warning('Attempted to save a prescription with an empty cart.', ['userID' => $userID]);
            return response()->json(['error' => 'Please Add Patient Medicines...'], 400);
        }

        DB::beginTransaction();
        try {
            // Log cart content for debugging
            Log::info('Cart content retrieved.', ['cartContent' => $cartContent->toArray()]);

            $firstItem = $cartContent->first();
            Log::info('Processing patient advice.', ['patient_id' => $firstItem->attributes->patient_id]);
            $prescription_id = date('Ymdhis');
            
            // Save Patient Advice
            $advice = PatientAdvice::create([
                "patient_id" => $firstItem->attributes->patient_id,
                "prescription_id" => $prescription_id,
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
            Log::info('Patient advice saved.', ['advice_id' => $advice->id]);

            // Save Patient Prescriptions
            foreach ($cartContent as $medicine) {
                Log::info('Saving prescription for medicine.', [
                    'medicine_name' => $medicine->name,
                    'patient_id' => $medicine->attributes->patient_id
                ]);

                PatientPrescription::create([
                    "patient_id" => $medicine->attributes->patient_id,
                    "prescription_id" => $prescription_id,
                    "medicine_name" => $medicine->name,
                    "dose" => $medicine->attributes->dose,
                    "cust_dose" => $medicine->attributes->cust_dose ?? null,
                    "duration_unit" => $medicine->attributes->duration_unit,
                    "instruction" => $medicine->attributes->instruction,
                    "duration" => $medicine->attributes->duration,
                    "created_by" => $userID,
                    "updated_by" => $userID
                ]);
            }
            // Clear Cart
            Cart::session($userID)->clear();
            Log::info('Cart cleared for user.', ['userID' => $userID]);

            DB::commit();
            Log::info('Prescription saved successfully.', ['userID' => $userID]);

            return response()->json(['message' => 'Prescription saved successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to save prescription.', [
                'userID' => $userID,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Failed to save prescription.', 'details' => $e->getMessage()], 500);
        }
    }

    public function prescritionsListPage() {
       return view("backend.pages.prescriptions.all-prescriptions");
    }

    public function getPrescritionsList(Request $request) {
        if($request->ajax()) {
            $userID = $request->session()->get('id');
            $prescriptions = PatientAdvice::with('patient')
                                            ->where('created_by', $userID)
                                            ->get();
            return DataTables::of($prescriptions)
                ->addIndexColumn()
                ->addColumn('patient_name', function ($row) {
                    return $row->patient ? $row->patient->first_name . ' ' .  $row->patient->last_name : 'N/A'; // Adjust 'name' to the actual column for the patient's name
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d-M-Y H:i'); // Format as 'DD-MM-YYYY HH:MM'
                })
                ->addColumn('action', function($row){
                    $activeUrl = route('dashboard.view-prescritions', [
                        'id' => $row->patient_id,
                        'data' => $row->prescription_id,
                    ]);
                    
                    $btn = '<a href="'.$activeUrl.'" class="btn badge-success btn-sm">View Prescription</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    } 

    public function viewPrescriptions(Request $request, $id, $data) {
        try {
            $userID = $request->session()->get('id');
            $doctor = DoctorsProfile::where('user_id', $userID)->first();
    
            // Check if the input date is valid
            if (!strtotime($data)) {
                return redirect()->back()->withErrors(['error' => 'Invalid date format.']);
            }
            // Format the date for display
            
            $formattedDate = Carbon::parse($data)->format('d M, Y'); 

            // Fetch patient and data
            $patient = PatientsProfile::findOrFail($id);
            $prescriptionData = PatientPrescription::where('patient_id', $id)
                ->where('prescription_id', $data)
                ->get();
            $advice = PatientAdvice::where('patient_id', $id)
                ->where('prescription_id', $data)
                ->first();
    
            // Calculate age
            $dob = $patient->dob;
            $age = Carbon::parse($dob)->age;
    
            // Pass data to the view
            return view('backend.pages.prescriptions.prescription', compact(
                'patient',
                'prescriptionData',
                'advice',
                'formattedDate',
                'doctor',
                'age'
            ));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error viewing prescription', ['error' => $e->getMessage(), 'patient_id' => $id, 'prescription_id' => $data]);
    
            // Redirect back with error message
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve prescriptions.']);
        }
    }
    
    
    

}
