<?php

namespace App\Models;

use App\Models\User;
use App\Models\Color;
use App\Models\Product;
use App\Models\Guarantee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class);
    }

    public function totalPrice()
    {
        $colorPrice = 0;
        $guaranteePrice = 0;
        $productPrice = $this->product->price;

        if ($this->color != null) {
            $colorPrice = $this->product->colors->where("id", $this->color->id)->first()->pivot->price;
        }

        if ($this->guarantee != null) {
            $guaranteePrice = $this->product->guarantees->where("id", $this->guarantee->id)->first()->pivot->price;
        }

        return ($productPrice + $colorPrice + $guaranteePrice) * $this->number;
    }
}
