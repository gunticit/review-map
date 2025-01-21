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
                Password::min(6)
            ],
            'password_confirm' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('Họ và tên là bắt buộc'),
            'email.required' => __('Email là bắt buộc'),
            'email.email' => __('Vui lòng nhập đúng định dạng email'),
            'email.unique' => __('Email đã được được sử dụng'),
            'telephone.unique' => __('Số điện thoại được sử dụng'),
            'telephone.required' => __('Số điện thoại là bắt buộc'),
            'telephone.phone' => __('Vui lòng nhập đúng điện thoại'),
            'password.required' => __('Mật khẩu là bắt buộc.'),
            'password.min' => __('Mật khẩu phải ít nhất :min ký tự.'),
            'password_confirm.required' => __('Mật khẩu xác nhận là bắt buộc.'),
            'password_confirm.same' => __('Mật khẩu xác nhận không khớp'),
        ];
    }
}
