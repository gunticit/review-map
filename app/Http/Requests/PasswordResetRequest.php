<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordResetRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Thay đổi thành logic xác thực nếu cần
    }

    public function rules()
    {
        return [
            'password' => [
                'required',
                'string',
                Password::min(6)
                    // ->mixedCase()
                    // ->letters() 
                    // ->numbers() 
                    // ->symbols() 
                    // ->uncompromised() 
            ],
            'confirmPassword' => 'required|same:password', // Đảm bảo confirmPassword trùng với password
        ];
    }
    public function messages(): array
    {
        return [
            'password.required' => __('Mật khẩu là bắt buộc.'),
            'password.min' => __('Mật khẩu phải ít nhất :min ký tự.'),
        ];
    }
}