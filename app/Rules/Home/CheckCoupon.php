<?php

namespace App\Rules\Home;

use App\Models\Coupon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class CheckCoupon implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $coupon = Coupon::where("coupon", $value)->first();

        if ($coupon == null || $coupon->status == "deactive" || $coupon->start_date > now() || $coupon->end_date < now()) {
            $fail("لطفا یک کد تخفیف متعبر وارد کنید.");
        }
        if ($coupon) {
            if ($coupon->type == "private") {
                if ($coupon->user->id != Auth::user()->id) {
                    $fail("لطفا یک کد تخفیف متعبر وارد کنید.");
                }
            }
        }
    }
}
