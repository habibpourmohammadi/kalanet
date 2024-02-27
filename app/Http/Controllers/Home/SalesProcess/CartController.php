<?php

namespace App\Http\Controllers\Home\SalesProcess;

use App\Http\Controllers\Controller;
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
        $relatedProducts = $relatedProducts->whereNotIn("id", $cartItemProductIds);

        return view("home.salesProcess.cart.index", compact("cartItems", "relatedProducts"));
    }
}
