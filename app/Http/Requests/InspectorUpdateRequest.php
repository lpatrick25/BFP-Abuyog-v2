<?php

namespace App\Http\Requests;

use App\Models\Inspector; // Ensure you import the Inspector model
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class InspectorUpdateRequest extends FormRequest
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
        // Fetch the correct ID from the route
        $inspectorId = $this->route('inspector') ?? $this->input('id');

        Log::info('Inspector ID:', ['id' => $inspectorId]); // Debugging

        return [
            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],
            'first_name' => 'required|string|max:20',
            'middle_name' => 'nullable|string|max:15',
            'last_name' => 'required|string|max:20',
            'extension_name' => 'nullable|string|max:5',
            'contact_number' => [
                'required',
                'string',
                'regex:/^09\d{9}$/',
                Rule::unique('inspectors', 'contact_number')->ignore($inspectorId),
            ],
            'email' => [
                'required',
                'email',
                'max:30',
                Rule::unique('inspectors', 'email')->ignore($inspectorId),
            ],
        ];
    }
}
