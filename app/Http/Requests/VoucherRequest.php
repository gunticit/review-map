<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // If you have authorization logic, you can include it here.
        // For now, we will return true to allow the request.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255|unique:vouchers,code',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:fixed,percent',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_uses' => 'required|integer|min:1',
            'min_order_value' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'The voucher code is required.',
            'code.unique' => 'This voucher code has already been taken.',
            'discount_type.required' => 'Please specify the discount type.',
            'discount_value.required' => 'Please specify the discount value.',
            'discount_value.numeric' => 'The discount value must be numeric.',
            'start_date.date' => 'Please provide a valid start date.',
            'end_date.after_or_equal' => 'The end date must be equal to or after the start date.',
            'max_uses.required' => 'Please specify the maximum number of uses.',
            'min_order_value.numeric' => 'The minimum order value must be numeric.',
        ];
    }
}
