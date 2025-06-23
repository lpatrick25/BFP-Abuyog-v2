<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/[A-Z]/', $value)) {
                        $fail('Password must include at least one uppercase letter.');
                    }
                    if (!preg_match('/\d/', $value)) {
                        $fail('Password must include at least one number.');
                    }
                    if (!preg_match('/[@$!%*?&]/', $value)) {
                        $fail('Password must include at least one special character (@$!%*?&).');
                    }
                },
            ],
            'password_confirmation' => 'required|string|min:6',
            'first_name' => 'required|string|max:20',
            'middle_name' => 'nullable|string|max:15',
            'last_name' => 'required|string|max:20',
            'extension_name' => 'nullable|string|max:5',
            'contact_number' => 'required|string|unique:clients,contact_number|regex:/^09\d{9}$/',
            'email' => 'required|email|max:30|unique:clients,email',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
