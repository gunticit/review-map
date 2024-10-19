<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $voucherId = $this->route('voucher');
        return [
            'code' => [
                'required',
                'max:255',
                Rule::unique('vouchers', 'code')->ignore($voucherId),
            ],
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
            'code.required' => 'Mã giảm giá là bắt buộc.',
            'code.unique' => 'Mã giảm giá này đã được sử dụng.',
            'discount_type.required' => 'Vui lòng chỉ định loại giảm giá.',
            'discount_value.required' => 'Vui lòng nhập giá trị giảm giá.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là số.',
            'start_date.date' => 'Vui lòng cung cấp ngày bắt đầu hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.',
            'max_uses.required' => 'Vui lòng chỉ định số lần sử dụng tối đa.',
            'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là số.',
        ];
    }
}
