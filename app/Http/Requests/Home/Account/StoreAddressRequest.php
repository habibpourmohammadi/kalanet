<?php

namespace App\Http\Requests\Home\Account;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            "city_id" => ["required", "numeric", "exists:cities,id"],
            "mobile" => ["required", "numeric", 'regex:/^09[0-9]{9}$/'],
            "address" => ["required"],
            "postal_code" => ["required", 'regex:/^[0-9]{10}$/'],
            "no" => ["nullable", "numeric"],
            "unit" => ["nullable", "numeric"],
            "recipient_first_name" => ["required_if:receiver,true", "max:255"],
            "recipient_last_name" => ["required_if:receiver,true", "max:255"],
            "recipient_mobile" => ["nullable", "regex:/^09[0-9]{9}$/"],
            // "recipient_mobile" => ["required_if:receiver,true", "regex:/^09[0-9]{9}$/"],
        ];
    }

    public function attributes()
    {
        return [
            "city_id" => "شهر",
            "mobile" => "شماره تماس",
            "address" => "آدرس",
            "postal_code" => "کد پستی",
            "no" => "پلاک",
            "unit" => "واحد",
            "recipient_first_name" => "نام گیرنده",
            "recipient_last_name" => "نام خانوادگی گیرنده",
            "recipient_mobile" => "شماره تماس گیرنده",
        ];
    }
}
