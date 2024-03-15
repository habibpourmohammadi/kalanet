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
        $cartItems = Auth::user()->cartItems;
        $cartItemProductIds = [];
        $relatedProducts = collect();
        $discountPrice = 0;
        $generalDiscountPrice = 0;
        $totalPrice = 0;

        $generalDiscount = GeneralDiscount::where("start_date", "<", now())->where("end_date", ">", now())->where("status", "active")->get()->last();

        foreach ($cartItems as $cartItem) {
            array_push($cartItemProductIds, $cartItem->product->id);
            foreach ($cartItem->product->category->products as $product) {
                $relatedProducts = $relatedProducts->concat([$product]);
            }
            $discountPrice += ($cartItem->product->discount * $cartItem->number);
            if (isset($generalDiscount)) {
                $generalDiscountPrice += $generalDiscount->generalDiscount($cartItem->product->price, $cartItem->product->discount) * $cartItem->number;
            }
            $totalPrice += $cartItem->totalPrice();
        }

        $relatedProducts = $relatedProducts->unique();
        $relatedProducts = $relatedProducts->whereNotIn("id", $cartItemProductIds)->take(15);

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
