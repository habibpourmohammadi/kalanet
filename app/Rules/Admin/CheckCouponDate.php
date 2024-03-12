<?php

namespace App\Rules\Admin;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckCouponDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_numeric($value)) {
            if ($attribute == "start_date") {
                $start_date = date("Y-m-d H:i:s", substr($value, 0, 10));
                $end_date = date("Y-m-d H:i:s", substr(request()->end_date, 0, 10));
                if ($start_date > $end_date) {
                    $fail("تاریخ شروع نباید بزرگتر از تاریخ پایان باشد.");
                }
            } else {
                $end_date = date("Y-m-d H:i:s", substr($value, 0, 10));
                $start_date = date("Y-m-d H:i:s", substr(request()->start_date, 0, 10));
                if ($start_date > $end_date) {
                    $fail("تاریخ پایان نباید کوچکتر از تاریخ شروع باشد.");
                }
            }
        } else {
            $fail("مقدار وارد شده اشتباه است");
        }
    }
}
