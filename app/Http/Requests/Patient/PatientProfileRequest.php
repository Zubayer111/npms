<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch($this->method())
        {
            case 'GET':
            {
                return [];
            }
            case 'POST':
            case 'PUT':
            {
                return [
                    // 'reference_time' => 'required|date',
                    // 'reference_note' => 'required|string',
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    // 'middle_name' => 'required|string',
                    // 'email' => 'required|email',
                    'gender' => 'required|in:Male,Female,Other',
                    // 'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                    // 'economical_status' => 'required|in:rich,middle class,poor',
                    // 'smoking_status' => 'required|in:smoker,non smoker',
                    // 'alcohole_status' => 'required|in:alcoholic,non alcoholic',
                    // 'marital_status' => 'required|in:Single,Married,Divorced,Widowed,Separated,Life Partner,Unmarried',
                    'dob' => 'required|date',
                    // 'height' => 'required|numeric',
                    // 'weight' => 'required|numeric',
                    // 'bmi' => 'required|numeric',
                    // 'address_one' => 'required|string',
                    // 'address_two' => 'required|string',
                    // 'city' => 'required|string',
                    // 'state' => 'required|string',
                    // 'zipCode' => 'required|string',
                    'phone_number' => 'required|string',
                    // 'history' => 'required|string',
                    // 'employer_details' => 'required|string',
                    // 'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ];
            }
            case 'DELETE':
            {
                return [];
            }

            default:break;
        }
        
    }
}
