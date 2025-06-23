<?php

namespace App\Http\Requests;

use App\Models\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ApplicationUpdateRequest extends FormRequest
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
        $rules = [];

        // Get FSIC type from request
        $fsicType = $this->input('fsic_type');
        $requirements = config("fsic_requirements.$fsicType", []);

        // Define required files based on the fsicType
        $requiredFiles = [
            0 => [ // Occupancy
                'endorsement_from_office_of_the_building_official_obo',
                'certificate_of_completion',
                'certified_true_copy_of_assessment_fee_for_certificate_occupancy_from_obo'
            ],
            1 => [ // New Business
                'certified_true_copy_of_valid_certificate_of_occupancy',
                'assessment_of_business_permit_fee_tax_assessment_bill_from_bplo',
                'affidavit_of_undertaking_no_substantial_changes'
            ],
            2 => [ // Renewal Business
                'assessment_of_the_business_permit_fee_tax_assessment_bill_from_bplo'
            ]
        ];

        foreach ($requirements as $requirement) {
            $inputName = Str::snake(str_replace(['(', ')', '/'], '', $requirement)); // Normalize name

            // Check if file is required or optional
            if (in_array($inputName, $requiredFiles[$fsicType] ?? [])) {
                $rules[$inputName] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            } else {
                $rules[$inputName] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            }
        }

        return $rules;
    }
}
