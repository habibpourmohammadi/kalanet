<?php

namespace App\Http\Requests\Home\Product;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
            "color_id" => ["nullable", "exists:colors,id"],
            "guarantee_id" => ["nullable", "exists:guarantees,id"],
            "number" => ["required", "integer", "between:0,5"],
        ];
    }
}
