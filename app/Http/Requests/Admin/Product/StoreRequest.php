<?php

namespace App\Http\Requests\Admin\Product;

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
            "name" => ["required", "max:255", "string"],
            "category_id" => ["required", "numeric", "exists:categories,id"],
            "brand_id" => ["required", "numeric", "exists:brands,id"],
            "description" => ["required"],
            "price" => ["required", "numeric"],
            "Introduction_video_path" => ["nullable", "file", "max:5000", "mimetypes:video/mp4"],
            "marketable_number" => ["required", "numeric", "digits_between:0,10"],
        ];
    }

    public function attributes()
    {
        return [
            "name" => "نام محصول",
            "marketable_number" => "تعداد قابل فروش",
        ];
    }
}
