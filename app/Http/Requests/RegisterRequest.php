<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PhoneNumber;
use App\Rules\Email;

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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users',
                new Email
            ],
            'telephone' => [
                'required', 
                'string', 
                'max:255', 
                'unique:users',
                new PhoneNumber
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('auth.name_required'),
            'email.required' => __('auth.email_required'),
            'email.email' => __('auth.email_invalid'),
            'role_id.required' => 'Role is required',
            'permission_id.required' => 'Permission is required',
            'telephone.required' => 'Telephone is required',
            'password.required' => 'Password is required',
        ];
    }
}
