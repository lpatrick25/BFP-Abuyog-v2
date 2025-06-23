<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends FormRequest
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
        $clientId = $this->route('client') ?? $this->input('id');

        Log::info('Client ID:', ['id' => $clientId]); // Debugging

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
                Rule::unique('clients', 'contact_number')->ignore($clientId),
            ],
            'email' => [
                'required',
                'email',
                'max:30',
                Rule::unique('clients', 'email')->ignore($clientId),
            ],
        ];
    }
}
