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
    // show the shopping cart page
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

    // Displaying the checkout information completion page
    public function delivery()
    {
        $user = Auth::user();

        // Eager loading cart items with product information
        $cartItems = $user->cartItems()->with('product')->get();

        // Calculate total price
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->totalPrice();
        });

        // Calculate discount price
        $discountPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->discount * $cartItem->number;
        });

        // Fetching general discount
        $generalDiscountPrice = 0;
        $generalDiscount = GeneralDiscount::where("start_date", "<", now())->where("end_date", ">", now())->where("status", "active")->latest()->first();

        // Calculating general discount price
        if ($generalDiscount) {
            $generalDiscountPrice = $cartItems->sum(function ($cartItem) use ($generalDiscount) {
                return $generalDiscount->generalDiscount($cartItem->product->price, $cartItem->product->discount) * $cartItem->number;
            });
        }

        // Eager loading user addresses
        $addresses = $user->addresses;

        // Fetching deliveries and provinces
        $deliveries = Delivery::where("status", "active")->get();
        $provinces = Province::where("status", "active")->get();

        return view("home.salesProcess.delivery.index", compact("addresses", "deliveries", "provinces", "cartItems", "totalPrice", "discountPrice", "generalDiscountPrice"));
    }
}
