<?php

namespace App\Http\Requests\Admin\Product\Color;

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
            "name" => ["required", "string", "max:255"],
            "hex_code" => ["required","regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i"]
        ];
    }

    public function attributes()
    {
        return [
            "name" => "نام رنگ",
            "hex_code" => "کد رنگی ای که انتخاب شده متعبر نیست",
        ];
    }
}
