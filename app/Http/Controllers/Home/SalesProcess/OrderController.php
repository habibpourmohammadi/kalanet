<?php

namespace App\Http\Controllers\Home\SalesProcess;

use App\Models\Order;
use App\Models\Address;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Home\Order\SubmitOrderRequest;

class OrderController extends Controller
{
    public function submitOrder(SubmitOrderRequest $request)
    {
        DB::transaction(function () use ($request) {
            $address = Address::find($request->address);
            $delivery = Delivery::find($request->delivery_type);
            $user = Auth::user();
            $user_obj = ["id" => $user->id, "name" =>  $user->name, "email" =>  $user->email];
            // check values
            if ($address->user->id != $user->id) {
                return back();
            } elseif ($delivery->status != "active") {
                return back();
            }

            // calc total price
            $total_price = 0;

            foreach ($user->cartItems as $cartItem) {
                $total_price += $cartItem->totalPrice();
            }

            // find or create Order
            $order = Order::updateOrCreate(
                ['user_id' => $user->id, "payment_status" => "unpaid", "status" => "not_confirmed"],
                ['address_id' => $address->id, 'delivery_id' => $delivery->id, "total_price" => $total_price + $delivery->price, "user_obj" => $user_obj, "address_obj" => $address, "delivery_obj" => $delivery]
            );

            // get Products
            $products = [];
            foreach ($user->cartItems as $cartItem) {
                if ($cartItem->color != null) {
                    $color_price = $cartItem->product->colors->where("id", $cartItem->color_id)->first()->pivot->price;
                } else {
                    $color_price = null;
                }

                if ($cartItem->guarantee != null) {
                    $guarantee_price = $cartItem->product->guarantees->where("id", $cartItem->guarantee_id)->first()->pivot->price;
                } else {
                    $guarantee_price = null;
                }

                $products[$cartItem->product->id] = [
                    'color_name' => $cartItem->color->name ?? null,
                    "color_hex_code" => $cartItem->color->hex_code ?? null,
                    "color_price" => $color_price,
                    "guarantee_persian_name" => $cartItem->guarantee->persian_name ?? null,
                    "guarantee_price" => $guarantee_price ?? null,
                    "product_price" => $cartItem->product->price,
                    "number" => $cartItem->number,
                    "total_price" => $cartItem->totalPrice(),
                    "product_obj" => json_encode($cartItem->product->toArray()),
                ];
            }

            $order->products()->sync($products);
        });

        // redirect to the payment page
        // return to_route();
    }
}
