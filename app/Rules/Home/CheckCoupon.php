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
        // Retrieve the coupon with the provided code
        $coupon = Coupon::where("coupon", $value)->first();

        // Check if the coupon exists, is active, and is within its validity period
        if ($coupon == null || $coupon->status == "deactive" || $coupon->start_date > now() || $coupon->end_date < now()) {
            $fail("لطفا یک کد تخفیف متعبر وارد کنید.");
        }

        // If the coupon exists, check if it is of type "private" and belongs to the authenticated user
        if ($coupon) {
            if ($coupon->type == "private") {
                if ($coupon->user->id != Auth::user()->id) {
                    $fail("لطفا یک کد تخفیف متعبر وارد کنید.");
                }
            }
        }
    }
}
