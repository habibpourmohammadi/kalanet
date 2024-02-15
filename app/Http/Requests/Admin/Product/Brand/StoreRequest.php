<?php

namespace App\Http\Requests\Admin\Product\Brand;

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
            "original_name" => ["required", "max:255", "unique:brands,original_name"],
            "persian_name" => ["required", "max:255", "unique:brands,persian_name"],
            "description" => ["required"],
            "logo_path" => ["nullable", "image", "mimes:png,jpg,gif,jpeg"],
        ];
    }

    public function attributes()
    {
        return [
            "logo_path" => "عکس برند",
        ];
    }
}
