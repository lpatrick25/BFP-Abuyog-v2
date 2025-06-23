<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstablishmentStoreRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:100',
            'representative_name' => 'nullable|string|max:100',
            'trade_name' => 'nullable|string|max:100',

            'total_building_area' => 'required|numeric|min:0',
            'number_of_occupant' => 'required|integer|min:1',

            'type_of_occupancy' => 'required|string|max:100',
            'type_of_building' => 'required|string|max:100',
            'nature_of_business' => 'required|string|max:100',

            'BIN' => 'nullable|string|unique:establishments,BIN|regex:/^\d{5}-\d{5}$/',
            'TIN' => 'nullable|string|unique:establishments,TIN|regex:/^\d{3}-\d{3}-\d{3}-\d{5}$/',
            'DTI' => 'nullable|string|unique:establishments,DTI|regex:/^\d{8}$/',
            'SEC' => 'nullable|string|unique:establishments,SEC|regex:/^PG\d{9}$/',

            'number_of_storey' => 'required|integer|min:0',
            'eminent_danger' => 'required|boolean|in:0,1',

            'address_brgy' => 'required|string|max:100',
            'address_ex' => 'nullable|string|max:100',

            'location_latitude' => 'required|numeric|between:-90,90',
            'location_longitude' => 'required|numeric|between:-180,180',

            'email' => 'required|email|max:255',
            'landline' => 'nullable|string|max:20',
            'contact_number' => 'required|string|max:15',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'BIN.required' => 'Business Identification Number is required.',
            'BIN.regex' => 'BIN format must be 99999-99999.',

            'TIN.regex' => 'TIN format must be 999-999-999-99999.',
            'DTI.regex' => 'DTI format must be exactly 8 digits (e.g., 12345678).',
            'SEC.regex' => 'SEC format must start with "PG" followed by 9 digits (e.g., PG123456789).',

            'DTI.required' => 'Department of Trade and Industry Registration is required.',

            'high_rise.required' => 'Please specify if this is a high-rise building.',
            'high_rise.in' => 'Invalid value for high-rise. Use 0 (No) or 1 (Yes).',

            'eminent_danger.required' => 'Please specify if this building is in imminent danger.',
            'eminent_danger.in' => 'Invalid value for imminent danger. Use 0 (No) or 1 (Yes).',

            'number_of_occupant.required' => 'The number of occupants is required.',
            'number_of_occupant.integer' => 'Number of occupants must be a whole number.',
            'number_of_occupant.min' => 'Number of occupants must be at least 1.',

            'location_latitude.between' => 'Latitude must be between -90 and 90 degrees.',
            'location_longitude.between' => 'Longitude must be between -180 and 180 degrees.',
        ];
    }
}
