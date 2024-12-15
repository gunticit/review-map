<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'quantity' => 'required|numeric|min:1',
            'product_id' => 'required|exists:products,id'
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => 'Số lượng là bắt buộc .',
            'quantity.numeric' => 'Số lượng phải là số.',
            'quantity.min' => 'Số lượng đặt tối thiểu là 1.',
            'product_id.required' => 'Id sản phẩm là bắt buộc.',
            'product_id.exists' => 'Id sản phẩm không tồn tại.',
        ];
    }
}
