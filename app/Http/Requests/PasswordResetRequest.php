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
                Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised(),
                // 'confirmed' // Bạn có thể bỏ comment nếu muốn sử dụng xác thực xác nhận mật khẩu
            ],
            'confirmPassword' => 'required|same:password', // Đảm bảo confirmPassword trùng với password
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu phải là một chuỗi.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.mixedCase' => 'Mật khẩu phải chứa cả chữ hoa và chữ thường.',
            'password.letters' => 'Mật khẩu phải chứa ít nhất một chữ cái.',
            'password.numbers' => 'Mật khẩu phải chứa ít nhất một số.',
            'password.symbols' => 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt.',
            'password.uncompromised' => 'Mật khẩu này đã bị lộ trong một vi phạm dữ liệu. Hãy chọn một mật khẩu khác.',
            'confirmPassword.required' => 'Xác nhận mật khẩu là bắt buộc.',
            'confirmPassword.same' => 'Xác nhận mật khẩu phải khớp với mật khẩu.',
        ];
    }
}