<?php

namespace App\Http\Requests\Admin\Discount\Coupon;

use Illuminate\Validation\Rule;
use App\Rules\Admin\CheckCouponDate;
use App\Rules\Admin\CheckCouponUnit;
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
            "discountCoupon" => ["required", "max:255", "unique:discount_coupons,coupon," . $this->coupon->id],
            "unit" => ["required", Rule::in(["percent", "price"])],
            "amount" => ["required", new CheckCouponUnit()],
            "discount_limit" => ["nullable", "numeric", "min:1"],
            "type" => ["required", Rule::in(["public", "private"])],
            "user_id" => ["required_if:type,private", "exists:users,id"],
            "start_date" => ["required", new CheckCouponDate()],
            "end_date" => ["required", new CheckCouponDate()],
        ];
    }

    public function attributes()
    {
        return [
            "coupon" => "کوپن تخفیف",
            "unit" => "واحد کوپن",
            "amount" => "مقدار تخفیف",
            "discount_limit" => "سقف تخفیف",
            "type" => "نوع کوپن تخفیف",
            "user_id" => "کاربر"
        ];
    }
}
