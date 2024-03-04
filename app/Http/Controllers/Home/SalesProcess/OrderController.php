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
use App\Http\Requests\Home\Payment\PaymentRequest;
use App\Models\Payment;

class OrderController extends Controller
{
    public function submitOrder(SubmitOrderRequest $request)
    {
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

        // find products
        foreach ($user->cartItems as $cartItem) {

            // check product
            if ($cartItem->product->status != 'true') {
                $cartItem->delete();
                return to_route("home.index")->with("error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->color_id != null && $cartItem->product->colors->where("id", $cartItem->color->id)->first() == null) {
                $cartItem->delete();
                return to_route("home.index")->with("error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->guarantee_id != null && $cartItem->product->guarantees->where("id", $cartItem->guarantee->id)->first() == null) {
                $cartItem->delete();
                return to_route("home.index")->with("error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->product->marketable != 'true' || $cartItem->product->marketable_number < $cartItem->number) {
                return to_route("home.salesProcess.myCart")->with("error", "یکی از محصولات سبد خرید شما ناموجود است ,لطفا سبد خرید خود را بررسی نمایید");
            }

            // calc total price
            $total_price += $cartItem->totalPrice();
        }

        // find tracking_id
        $user_order = $user->orders()->where("payment_status", "unpaid")->where("status", "not_confirmed")->where("delivery_status", "unpaid")->first();

        if ($user_order != null) {
            $tracking_id = $user_order->tracking_id;
        } else {
            $tracking_id = rand(11111111, 99999999);
        }


        DB::transaction(function () use ($user, $address, $delivery, $tracking_id, $total_price, $user_obj) {
            // find or create Order
            $order = Order::updateOrCreate(
                ['user_id' => $user->id, "payment_status" => "unpaid", "status" => "not_confirmed", "delivery_status" => "unpaid", "tracking_id" => $tracking_id],
                ['address_id' => $address->id, 'delivery_id' => $delivery->id, "total_price" => $total_price + $delivery->price, "user_obj" => $user_obj, "address_obj" => $address, "delivery_obj" => $delivery]
            );

            // detach old products
            $order->products()->detach();

            // find product and attach
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

                $order->products()->attach($cartItem->product->id, [
                    'color_name' => $cartItem->color->name ?? null,
                    "color_hex_code" => $cartItem->color->hex_code ?? null,
                    "color_price" => $color_price,
                    "guarantee_persian_name" => $cartItem->guarantee->persian_name ?? null,
                    "guarantee_price" => $guarantee_price ?? null,
                    "product_price" => $cartItem->product->price,
                    "number" => $cartItem->number,
                    "total_price" => $cartItem->totalPrice(),
                    "product_obj" => json_encode($cartItem->product->toArray()),
                ]);
            }
        });

        // redirect to the payment page
        return to_route("home.salesProcess.payment.page");
    }

    // Payment Page
    public function paymentPage()
    {
        $order = Auth::user()->orders->where("payment_status", "unpaid")->where("status", "not_confirmed")->where("delivery_status", "unpaid")->first();
        if ($order == null) {
            return to_route("home.salesProcess.myCart")->with("error", "لطفا مجدد تلاش کنید");
        }

        $total_price = 0;
        foreach (Auth::user()->cartItems as $cartItem) {
            $total_price += $cartItem->totalPrice();
        }
        return view("home.salesProcess.payment.index", compact("order", "total_price"));
    }

    // Payment func
    public function payment(PaymentRequest $request)
    {
        $payment_type = $request->payment_type;
        $order = Auth::user()->orders->where("payment_status", "unpaid")->where("status", "not_confirmed")->where("delivery_status", "unpaid")->first();
        $cartItems = Auth::user()->cartItems;

        // get totalPrice
        $totalPrice = 0;

        // last check for cartItems
        foreach ($cartItems as $cartItem) {
            // check product
            if ($cartItem->product->status != 'true') {
                $cartItem->delete();
                return to_route("home.index")->with("error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->color_id != null && $cartItem->product->colors->where("id", $cartItem->color->id)->first() == null) {
                $cartItem->delete();
                return to_route("home.index")->with("error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->guarantee_id != null && $cartItem->product->guarantees->where("id", $cartItem->guarantee->id)->first() == null) {
                $cartItem->delete();
                return to_route("home.index")->with("error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->product->marketable != 'true' || $cartItem->product->marketable_number < $cartItem->number) {
                return to_route("home.salesProcess.myCart")->with("error", "یکی از محصولات سبد خرید شما ناموجود است ,لطفا سبد خرید خود را بررسی نمایید");
            }

            $totalPrice += $cartItem->totalPrice();
        }

        // check delivery price
        if ($order->delivery->price != $order->delivery_obj["price"]) {
            return to_route("home.salesProcess.myCart")->with("error", "قیمت روش ارسال مورد نظر تغییر کرده است، لطفا دوباره تلاش کنید");
        } elseif ($order->delivery->status != "active") {
            return to_route("home.salesProcess.myCart")->with("error", "روش ارسال مورد نظر غیر فعال شده است، لطفا دوباره تلاش کنید");
        }

        // check products number
        if ($cartItems->count() != $order->products->count()) {
            dd($cartItems->count(), $order);
            return to_route("home.salesProcess.myCart")->with("error", "لطفا روند ثبت سفارش خود را تکرار کنید");
        }

        // check final price
        if (($order->delivery->price + $totalPrice) != $order->total_price) {
            return to_route("home.salesProcess.myCart")->with("error", "لطفا روند ثبت سفارش خود را تکرار کنید");
        }

        if ($payment_type == 2) {
            DB::transaction(function () use ($order, $cartItems) {
                Payment::create([
                    "order_id" => $order->id,
                    "amount" => $order->total_price,
                    "status" => "cash",
                    "payment_status" => "cash_payment"
                ]);

                // update order
                $order->update([
                    "delivery_status" => "processing"
                ]);

                // delete cartItems and update product
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;
                    $product->increment('sold_number', $cartItem->number);
                    $product->decrement('marketable_number', $cartItem->number);
                    $cartItem->delete();
                }
            });

            return to_route("home.profile.myOrders.index")->with("success", "سفارش شما با موفقیت ثبت شد");
        }
    }
}
