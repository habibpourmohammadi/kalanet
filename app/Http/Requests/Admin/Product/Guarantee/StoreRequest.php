<?php

namespace App\Http\Requests\Admin\Product\Guarantee;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "original_name" => ["required", "max:255", "unique:guarantees,original_name"],
            "persian_name" => ["required", "max:255", "unique:guarantees,persian_name"],
            "description" => ["required"],
        ];
    }

    public function attributes()
    {
        return [
            "original_name" => "نام انگلیسی گارانتی",
            "persian_name" => "نام فارسی گارانتی",
        ];
    }
}
