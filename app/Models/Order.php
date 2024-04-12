<?php

namespace App\Models;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Product;
use App\Models\Delivery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    protected $casts = ['user_obj' => 'array', "address_obj" => "array", "delivery_obj" => "array", "coupon_obj" => "array", "general_discount_obj" => "array"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class)->withTrashed();
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class)->withTrashed();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class)->withTrashed();
    }

    public function generalDiscount()
    {
        return $this->belongsTo(GeneralDiscount::class)->withTrashed();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot("color_name", "color_hex_code", "color_price", "guarantee_persian_name", "guarantee_price", "product_price", "number", "total_price", "product_obj", "product_discount", "total_discount", "total_general_discount","final_price")->withTrashed();
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function paymentStatus()
    {
        switch ($this->payment_status) {
            case 'paid':
                return "پرداخت شده";
                break;

            case 'unpaid':
                return "پرداخت نشده";
                break;

            case 'returned':
                return "مرجوعی";
                break;

            case 'canceled':
                return "لغو شده";
                break;

            default:
                return "نامعلوم";
                break;
        }
    }

    public function deliveryStatus()
    {
        switch ($this->delivery_status) {
            case 'processing':
                return "در حال بارگیری";
                break;

            case 'delivered':
                return "ارسال شده";
                break;

            case 'unpaid':
                return "پرداخت نشده";
                break;

            default:
                return "نامعلوم";
                break;
        }
    }

    // Calculates and returns the discount amount based on applied coupon
    public function getCouponDiscountAttribute()
    {
        // Retrieve the coupon associated with the order
        $coupon = $this->coupon;
        $price = ($this->total_price + $this->delivery_price) - ($this->total_discount + $this->total_general_discount);

        // Check if the coupon is valid and active
        if ($coupon != null && $coupon->start_date < now() && $coupon->end_date > now() && $coupon->status == "active") {

            // Check if the coupon is of type "private" and belongs to the authenticated user
            if ($coupon->type == "private" && $coupon->user_id != auth()->user()->id) {
                return 0; // Return 0 discount if the coupon is private and does not belong to the user
            }

            // Calculate discount based on the type of coupon
            if ($coupon->unit == "percent") {
                $discountAmount = $price * ($coupon->amount / 100); // Calculate discount amount as percentage of total price
            } else {
                $discountAmount = min($coupon->amount, $price); // Calculate discount amount as fixed amount
            }

            // Apply discount limit if specified
            if ($coupon->discount_limit != null) {
                $discountAmount = min($discountAmount, $coupon->discount_limit); // Apply discount limit
            }

            return $discountAmount; // Return the calculated discount amount

        } else {
            return 0; // Return 0 discount if no valid coupon is applied
        }
    }
}
