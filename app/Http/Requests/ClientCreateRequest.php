<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
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
            'password' => [
                'required',
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
                'unique:clients,contact_number',
                'regex:/^09\d{9}$/',
            ],
            'email' => 'required|email|max:30|unique:clients,email',
        ];
    }
}
