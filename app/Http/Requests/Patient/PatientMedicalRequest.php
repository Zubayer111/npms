<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientMedicalRequest extends FormRequest
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
            {
                return [
                    'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx',
                    'file_type' => 'required|string|in:image,pdf,doc',
                    'file_name' => 'required|string',
                ];
            }
            case 'PUT':
                {
                    return [
                        'id' => 'required|integer',
                        'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx',
                        'file_type' => 'required|string|in:image,pdf,doc',
                        'file_name' => 'required|string',
                    ];
                }
            case 'DELETE':
            {
                return [
                    'id' => 'required|integer',
                ];
            }

            default:break;
        }
    }
}
