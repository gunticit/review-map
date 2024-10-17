<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateCurrentLocationRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Thay đổi thành logic xác thực nếu cần
    }

    public function rules()
    {
        return [
            'latitude' => [
                'required',
                'string'
            ],
            'longitude' => [
                'required',
                'string'
            ],
        ];
    }
}