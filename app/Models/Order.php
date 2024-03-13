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

    protected $casts = ['user_obj' => 'array', "address_obj" => "array", "delivery_obj" => "array", "coupon_obj" => "array"];

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

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot("color_name", "color_hex_code", "color_price", "guarantee_persian_name", "guarantee_price", "product_price", "number", "total_price", "product_obj", "product_discount", "total_discount")->withTrashed();
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

    public function getCouponDiscountAttribute()
    {
        $coupon = $this->coupon;
        if ($coupon != null && $coupon->start_date < now() && $coupon->end_date > now() && $coupon->status == "active") {
            if ($coupon->type == "private" && $coupon->user_id != auth()->user()->id) {
                return 0;
            }
            if ($coupon->unit == "percent") {
                $discountAmount = $this->total_price * ($coupon->amount / 100);
                if ($coupon->discount_limit != null) {
                    if ($discountAmount >= $coupon->discount_limit) {
                        return $coupon->discount_limit;
                    } else {
                        return $discountAmount;
                    }
                } else {
                    return $discountAmount;
                }
            } else {
                $discountAmount = $coupon->amount;
                if ($discountAmount > $this->total_price) {
                    $discountAmount = $this->total_price;
                }
                if ($coupon->discount_limit != null) {
                    if ($discountAmount >= $coupon->discount_limit) {
                        if ($coupon->discount_limit > $this->total_price) {
                            return $this->total_price;
                        } else {
                            return $coupon->discount_limit;
                        }
                    } else {
                        if ($discountAmount > $this->total_price) {
                            return $this->total_price;
                        } else {
                            return $discountAmount;
                        }
                    }
                } else {
                    if ($discountAmount > $this->total_price) {
                        return $this->total_price;
                    } else {
                        return $discountAmount;
                    }
                }
            }
        } else {
            return 0;
        }
    }
}
