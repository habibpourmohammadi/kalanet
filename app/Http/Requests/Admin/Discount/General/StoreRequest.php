<?php

namespace App\Http\Requests\Admin\Discount\General;

use Illuminate\Validation\Rule;
use App\Rules\Admin\CheckCouponDate;
use App\Rules\Admin\CheckCouponUnit;
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
            "unit" => ["required", Rule::in(["percent", "price"])],
            "amount" => ["required", new CheckCouponUnit()],
            "discount_limit" => ["nullable", "numeric", "min:1"],
            "start_date" => ["required", new CheckCouponDate()],
            "end_date" => ["required", new CheckCouponDate()],
        ];
    }

    public function attributes()
    {
        return [
            "unit" => "واحد کوپن",
            "amount" => "مقدار تخفیف",
            "discount_limit" => "سقف تخفیف",
        ];
    }
}
