<?php

namespace App\Http\Requests\Admin\Product\ProductGuarantee;

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
            "guarantee_id" => ["required", "exists:guarantees,id"],
            "price" => ["required", "numeric", "digits_between:0,10"]
        ];
    }


    public function attributes()
    {
        return [
            "guarantee_id" => "گارانتی محصول",
            "price" => "افزایش قیمت",
        ];
    }
}
