<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PhoneNumber;
use App\Rules\Email;
use Illuminate\Validation\Rules\Password;

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
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters() 
                    ->numbers() 
                    ->symbols() 
                    ->uncompromised() 
            ]
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
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải ít nhất :min ký tự.',
            'password.mixedCase' => 'Mật khẩu phải bao gồm cả chữ hoa và chữ thường.',
            'password.letters' => 'Mật khẩu phải chứa ít nhất một chữ cái.',
            'password.numbers' => 'Mật khẩu phải chứa ít nhất một số.',
            'password.symbols' => 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt.',
            'password.uncompromised' => 'Mật khẩu này đã bị rò rỉ. Vui lòng chọn mật khẩu khác.'
        ];
    }
}
