<?php

namespace App\Http\Requests\Admin\Order\City;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "name" => ["required", "string", "unique:cities,name," . $this->city->id, "max:255"],
            "province_id" => ["required", "numeric", "exists:provinces,id"]
        ];
    }

    public function attributes()
    {
        return [
            "name" => "نام شهر",
            "province_id" => "استان",
        ];
    }
}
