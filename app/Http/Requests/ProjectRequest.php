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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public static function rules(): array
    {
        return [
            'name' => 'required',
            'url_map' => 'required',
            'package' => 'required',
        ];
    }

    public static function messages(): array{
        return [
            'name.required' => 'Vui lòng nhập tên dự án',
            'url_map.required' => 'Vui lòng nhập đường dẫn bản đồ',
            'package.required' => 'Vui lòng chọn gói mua',
        ];
    }
}
