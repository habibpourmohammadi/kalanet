<?php

namespace App\Http\Controllers\Home\SalesProcess;

use App\Models\Delivery;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\GeneralDiscount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Eager loading cart items with product information
        $cartItems = Auth::user()->cartItems()->with('product.category.products')->get();

        // Extracting product IDs from cart items
        $cartItemProductIds = $cartItems->pluck('product.id')->all();

        // Fetching related products using eager loading
        $relatedProducts = collect();
        foreach ($cartItems as $cartItem) {
            $relatedProducts = $relatedProducts->merge($cartItem->product->category->products);
        }


        // Calculating total discount and total price using aggregate queries
        $discountPrice = $cartItems->sum(function ($item) {
            return $item->product->discount * $item->number;
        });


        // Fetching general discount
        $generalDiscount = GeneralDiscount::where("start_date", "<", now())
            ->where("end_date", ">", now())
            ->where("status", "active")
            ->latest()
            ->first();

        // Calculating general discount price using total price of products
        $generalDiscountPrice = $generalDiscount ? $cartItems->sum(function ($item) use ($generalDiscount) {
            return $generalDiscount->generalDiscount($item->product->price, $item->product->discount) * $item->number;
        }) : 0;


        // Calculating total price using totalPrice() method
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->totalPrice();
        });


        // Filtering unique related products and excluding those already in the cart
        $relatedProducts = $relatedProducts->unique('id')->reject(function ($product) use ($cartItemProductIds) {
            return in_array($product->id, $cartItemProductIds);
        })->take(15);

        return view("home.salesProcess.cart.index", compact("cartItems", "relatedProducts", "discountPrice", "generalDiscount", "totalPrice", "generalDiscountPrice"));
    }

    public function delivery()
    {
        $cartItems = Auth::user()->cartItems;
        $totalPrice = 0;
        $discountPrice = 0;
        $generalDiscountPrice = 0;

        $generalDiscount = GeneralDiscount::where("start_date", "<", now())->where("end_date", ">", now())->where("status", "active")->get()->last();

        foreach ($cartItems as $cartItem) {
            $totalPrice +=  $cartItem->totalPrice();
            if (isset($generalDiscount)) {
                $generalDiscountPrice += $generalDiscount->generalDiscount($cartItem->product->price, $cartItem->product->discount) * $cartItem->number;
            }
            $discountPrice += ($cartItem->product->discount * $cartItem->number);
        }

        $addresses = Auth::user()->addresses;
        $deliveries = Delivery::where("status", "active")->get();

        $provinces = Province::where("status", "active")->get();
        return view("home.salesProcess.delivery.index", compact("addresses", "deliveries", "provinces", "cartItems", "totalPrice", "discountPrice", "generalDiscountPrice"));
    }
}
