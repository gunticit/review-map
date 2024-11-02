<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_password' => ['required', 'incorrect'],
            'new_password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised(),
                // 'confirmed'
            ],
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'current_password.password' => 'Mật khẩu hiện tại không đúng.',
            'current_password.incorrect' => 'Mật khẩu không chính xác.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.mixedCase' => 'Mật khẩu mới phải chứa cả chữ hoa và chữ thường.',
            'new_password.letters' => 'Mật khẩu mới phải chứa ít nhất một ký tự chữ.',
            'new_password.numbers' => 'Mật khẩu mới phải chứa ít nhất một chữ số.',
            'new_password.symbols' => 'Mật khẩu mới phải chứa ít nhất một ký tự đặc biệt.',
            'new_password.uncompromised' => 'Mật khẩu mới không nên là mật khẩu phổ biến hoặc đã bị lộ.',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ];
    }
}
