<?php

namespace App\Http\Requests\Admin\Product\Option;

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
            "title" => ["required", "max:255"],
            "option" => ["required", "max:255"],
        ];
    }

    public function attributes()
    {
        return [
            "title" => "عنوان ویژگی",
            "option" => "توضیحات ویژگی",
        ];
    }
}
