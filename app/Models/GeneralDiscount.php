<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralDiscount extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    protected $table = "general_discounts";

    public function generalDiscount($productPrice, $productDiscount = null)
    {
        if ($this->unit == "percent") {
            $discountAmount = $productPrice * ($this->amount / 100);
            if ($this->discount_limit != null && $this->discount_limit < $discountAmount) {
                $discountAmount = $this->discount_limit;
            }
        } else {
            if ($this->discount_limit != null && $this->discount_limit < $this->amount) {
                $discountAmount = $this->discount_limit;
            } else {
                $discountAmount = $this->amount;
            }
        }

        if (($discountAmount + $productDiscount) > $productPrice) {
            $discountAmount = 0;
        }

        return $discountAmount;
    }
}
