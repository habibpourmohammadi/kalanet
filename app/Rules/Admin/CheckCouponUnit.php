<?php

namespace App\Rules\Admin;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckCouponUnit implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_numeric($value)) {
            if (request()->unit == "percent") {
                if ($value > 100 || $value <= 0) {
                    $fail("مقدار تخفیف باید بین 1 درصد تا 100 درصد باشد..");
                }
            }
        } else {
            $fail("مقدار تخفیف باید از نوع عددی باشد.");
        }
    }
}
