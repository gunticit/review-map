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
                    ->letters() 
                    // ->numbers() 
                    ->symbols() 
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
            // 'password.mixedCase' => 'Mật khẩu phải bao gồm cả chữ hoa và chữ thường.',
            'password.letters' => __('Mật khẩu phải chứa ít nhất một chữ cái.'),
            // 'password.numbers' => 'Mật khẩu phải chứa ít nhất một số.',
            'password.symbols' => __('Mật khẩu phải chứa ít nhất một ký tự đặc biệt.'),
            // 'password.uncompromised' => 'Mật khẩu này đã bị rò rỉ. Vui lòng chọn mật khẩu khác.'
            'confirmPassword.required' => 'Xác nhận mật khẩu là bắt buộc.',
            'confirmPassword.same' => 'Xác nhận mật khẩu phải khớp với mật khẩu.',
        ];
    }
}