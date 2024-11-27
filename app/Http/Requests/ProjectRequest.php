<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'name' => 'required',
            'place_id' => 'required',
            'package' => 'required',
            'files' => 'max:2048'
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'Vui lòng nhập tên dự án',
            'package.required' => 'Vui lòng chọn gói mua',
            'place_id.required' => 'Bản đồ lỗi, Vui lòng chọn lại bản đồ',
            'files.max' => 'Vui lý chọn file < 2MB'
        ];
    }
}
