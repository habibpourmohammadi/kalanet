<?php

namespace App\Http\Requests\Admin\Appearance\Banner;

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
            "banner_path" => ["required", "image", "mimes:png,jpg,jpeg,gif", "max:1024"],
            "banner_position" => ["required", "integer", "between:1,3"]
        ];
    }

    public function attributes()
    {
        return [
            "banner_path" => "بنر",
            "banner_position" => "موقعیت بنر"
        ];
    }
}
