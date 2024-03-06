<?php

namespace App\Http\Controllers\Home\SalesProcess;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems;
        $cartItemProductIds = [];
        $relatedProducts = collect();

        foreach ($cartItems as $cartItem) {
            array_push($cartItemProductIds, $cartItem->product->id);
            foreach ($cartItem->product->category->products as $product) {
                $relatedProducts = $relatedProducts->concat([$product]);
            }
        }

        $relatedProducts = $relatedProducts->unique();
        $relatedProducts = $relatedProducts->whereNotIn("id", $cartItemProductIds)->take(15);

        return view("home.salesProcess.cart.index", compact("cartItems", "relatedProducts"));
    }

    public function delivery()
    {
        $cartItems = Auth::user()->cartItems;
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice +=  $cartItem->totalPrice();
        }

        $addresses = Auth::user()->addresses;
        $deliveries = Delivery::where("status", "active")->get();

        $provinces = Province::where("status", "active")->get();
        return view("home.salesProcess.delivery.index", compact("addresses", "deliveries", "provinces", "cartItems", "totalPrice"));
    }
}
