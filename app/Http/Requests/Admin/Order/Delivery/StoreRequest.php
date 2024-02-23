<?php

namespace App\Http\Requests\Admin\Order\Delivery;

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
            "name" => ["required", "max:255"],
            "delivery_time_unit" => ["required", "max:255"],
            "delivery_time" => ["required", "numeric", "digits_between:1,10"],
            "price" => ["required", "numeric", "digits_between:1,10"],
        ];
    }

    public function attributes()
    {
        return [
            "delivery_time" => "مدت زمان ارسال",
            "delivery_time_unit" => "واحد مدت زمان ارسال",
        ];
    }
}
