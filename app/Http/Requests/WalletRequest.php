<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
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
            'contract' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'front_id_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'back_id_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'contract.required' => 'Mã giảm giá là bắt buộc.',
            'front_id_image.unique' => 'Mã giảm giá này đã được sử dụng.',
            'back_id_image.required' => 'Vui lòng chỉ định loại giảm giá.',
        ];
    }
}
