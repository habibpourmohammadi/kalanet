<?php

namespace App\Http\Controllers\Home\SalesProcess;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Delivery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GeneralDiscount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use NasrinRezaei45\Shepacom\ShepaFacade;
use App\Http\Requests\Home\Coupon\CouponRequest;
use App\Http\Requests\Home\Payment\PaymentRequest;
use App\Http\Requests\Home\Order\SubmitOrderRequest;

class OrderController extends Controller
{
    private $result;
    public function submitOrder(SubmitOrderRequest $request)
    {
        $address = Address::find($request->address);
        $delivery = Delivery::find($request->delivery_type);
        $user = Auth::user();
        $user_obj = ["id" => $user->id, "name" =>  $user->name, "email" =>  $user->email];
        $generalDiscount = GeneralDiscount::where("start_date", "<", now())->where("end_date", ">", now())->where("status", "active")->get()->last();

        // check values
        if ($address->user->id != $user->id) {
            return back();
        } elseif ($delivery->status != "active") {
            return back();
        }

        // calc total price and total discount
        $total_price = 0;
        $total_discount = 0;
        $total_general_discount = 0;

        // find products
        foreach ($user->cartItems as $cartItem) {

            // check product
            if ($cartItem->product->status != 'true') {
                $cartItem->delete();
                return to_route("home.index")->with("swal-error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->color_id != null && $cartItem->product->colors->where("id", $cartItem->color->id)->first() == null) {
                $cartItem->delete();
                return to_route("home.index")->with("swal-error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->guarantee_id != null && $cartItem->product->guarantees->where("id", $cartItem->guarantee->id)->first() == null) {
                $cartItem->delete();
                return to_route("home.index")->with("swal-error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->product->marketable != 'true' || $cartItem->product->marketable_number < $cartItem->number) {
                return to_route("home.salesProcess.myCart")->with("swal-error", "یکی از محصولات سبد خرید شما ناموجود است ,لطفا سبد خرید خود را بررسی نمایید");
            }

            // calc total price and total discount
            $total_price += $cartItem->totalPrice();
            $total_discount += $cartItem->product->discount * $cartItem->number;
            if (isset($generalDiscount)) {
                $total_general_discount += $generalDiscount->generalDiscount($cartItem->product->price, $cartItem->product->discount) * $cartItem->number;
            }
        }

        // find tracking_id
        $user_order = $user->orders()->where("payment_status", "unpaid")->where("status", "not_confirmed")->where("delivery_status", "unpaid")->first();

        if ($user_order != null) {
            $tracking_id = $user_order->tracking_id;
        } else {
            $tracking_id = rand(11111111, 99999999);
        }

        DB::transaction(function () use ($user, $address, $delivery, $tracking_id, $total_price, $total_discount, $user_obj, $generalDiscount, $total_general_discount) {
            // find or create Order
            $order = Order::updateOrCreate(
                ['user_id' => $user->id, "payment_status" => "unpaid", "status" => "not_confirmed", "delivery_status" => "unpaid", "tracking_id" => $tracking_id],
                [
                    'address_id' => $address->id, 'delivery_id' => $delivery->id, 'general_discount_id' => $generalDiscount->id ?? null, "total_price" => ($total_price + $delivery->price) -  ($total_discount + $total_general_discount), "total_discount" => $total_discount, "user_obj" => $user_obj, "address_obj" => $address, "delivery_obj" => $delivery, "general_discount_obj" => $generalDiscount
                ]
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
                    "product_discount" => $cartItem->product->discount,
                    "number" => $cartItem->number,
                    "total_price" => $cartItem->totalPrice(),
                    "total_discount" => $cartItem->product->discount * $cartItem->number,
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
            return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا مجدد تلاش کنید");
        }

        $generalDiscount = GeneralDiscount::where("start_date", "<", now())->where("end_date", ">", now())->where("status", "active")->get()->last();

        $total_price = 0;
        $total_discount = 0;
        $generalDiscountPrice = 0;

        foreach (Auth::user()->cartItems as $cartItem) {
            $total_price += $cartItem->totalPrice();
            $total_discount += $cartItem->product->discount * $cartItem->number;
            if (isset($generalDiscount)) {
                $generalDiscountPrice += $generalDiscount->generalDiscount($cartItem->product->price, $cartItem->product->discount) * $cartItem->number;
            }
        }
        return view("home.salesProcess.payment.index", compact("order", "total_price", "total_discount", "generalDiscountPrice"));
    }

    public function checkCoupon(CouponRequest $request)
    {
        $coupon = Coupon::where("coupon", $request->coupon)->first();
        $order = Auth::user()->orders->where("payment_status", "unpaid")->where("status", "not_confirmed")->where("delivery_status", "unpaid")->first();

        if ($order->coupon_id != null) {
            return back()->with("swal-error", "برای این سفارش شما از قبل کد تخفیف ثبت شده است.");
        }

        $order->update([
            "coupon_id" => $coupon->id,
            "coupon_obj" => $coupon,
        ]);

        return back()->with("swal-success", "کد تخفیف شما با موفقیت ثبت شد");
    }

    // Payment func
    public function payment(PaymentRequest $request)
    {
        $payment_type = $request->payment_type;
        $order = Auth::user()->orders->where("payment_status", "unpaid")->where("status", "not_confirmed")->where("delivery_status", "unpaid")->first();
        $cartItems = Auth::user()->cartItems;
        $generalDiscount = GeneralDiscount::where("start_date", "<", now())->where("end_date", ">", now())->where("status", "active")->get()->last();

        // get totalPrice and total discount
        $totalPrice = 0;
        $totalDiscount = 0;
        $generalDiscountPrice = 0;

        // last check for cartItems
        foreach ($cartItems as $cartItem) {
            // check product
            if ($cartItem->product->status != 'true') {
                $cartItem->delete();
                return to_route("home.index")->with("swal-error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->color_id != null && $cartItem->product->colors->where("id", $cartItem->color->id)->first() == null) {
                $cartItem->delete();
                return to_route("home.index")->with("swal-error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->guarantee_id != null && $cartItem->product->guarantees->where("id", $cartItem->guarantee->id)->first() == null) {
                $cartItem->delete();
                return to_route("home.index")->with("swal-error", "یکی از محصولات سبد خرید شما مشکلی دارد ,لطفا سبد خرید خود را بررسی نمایید");
            } elseif ($cartItem->product->marketable != 'true' || $cartItem->product->marketable_number < $cartItem->number) {
                return to_route("home.salesProcess.myCart")->with("swal-error", "یکی از محصولات سبد خرید شما ناموجود است ,لطفا سبد خرید خود را بررسی نمایید");
            }

            if (isset($generalDiscount)) {
                $generalDiscountPrice += $generalDiscount->generalDiscount($cartItem->product->price, $cartItem->product->discount) * $cartItem->number;
            }
            $totalPrice += $cartItem->totalPrice();
            $totalDiscount += $cartItem->product->discount * $cartItem->number;
        }

        // check general discount
        if ($order->generalDiscount == null && $generalDiscount != null) {
            $order->update([
                "general_discount_id" => null,
                "general_discount_obj" => null,
            ]);
            return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا روند ثبت سفارش خود را تکرار کنید");
        }

        if ($order->generalDiscount != null) {
            $general_discount = $order->generalDiscount;
            if (
                $order->general_discount_obj["amount"] != $general_discount->amount ||
                $order->general_discount_obj["discount_limit"] != $general_discount->discount_limit ||
                $order->general_discount_obj["start_date"] != $general_discount->start_date ||
                $order->general_discount_obj["end_date"] != $general_discount->end_date ||
                $order->general_discount_obj["unit"] != $general_discount->unit ||
                $order->general_discount_obj["status"] != $general_discount->status ||
                $general_discount->start_date > now() ||
                $general_discount->end_date < now() ||
                $general_discount->status != "active"
            ) {
                $order->update([
                    "general_discount_id" => null,
                    "general_discount_obj" => null,
                ]);
                return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا روند ثبت سفارش خود را تکرار کنید");
            }
        }

        // check coupon discount
        if ($order->coupon != null) {
            $coupon = $order->coupon;
            if (
                $order->coupon_obj["amount"] != $coupon->amount ||
                $order->coupon_obj["discount_limit"] != $coupon->discount_limit ||
                $order->coupon_obj["start_date"] != $coupon->start_date ||
                $order->coupon_obj["end_date"] != $coupon->end_date ||
                $order->coupon_obj["unit"] != $coupon->unit ||
                $order->coupon_obj["type"] != $coupon->type ||
                $order->coupon_obj["status"] != $coupon->status ||
                $coupon->start_date > now() ||
                $coupon->end_date < now() ||
                $coupon->status != "active"
            ) {
                $order->update([
                    "coupon_id" => null,
                    "coupon_obj" => null,
                ]);
                return back()->with("swal-error", "برای کد تخفیف شما مشکلی پیش آمده است ، لطفا دوباره تلاش کنید");
            } elseif ($coupon->type == "private") {
                if ($coupon->user_id != Auth::user()->id) {
                    $order->update([
                        "coupon_id" => null,
                        "coupon_obj" => null,
                    ]);
                    return back()->with("swal-error", "برای کد تخفیف شما مشکلی پیش آمده است ، لطفا دوباره تلاش کنید");
                }
            }
        }


        // check delivery price
        if ($order->delivery->price != $order->delivery_obj["price"]) {
            return to_route("home.salesProcess.myCart")->with("swal-error", "قیمت روش ارسال مورد نظر تغییر کرده است، لطفا دوباره تلاش کنید");
        } elseif ($order->delivery->status != "active") {
            return to_route("home.salesProcess.myCart")->with("swal-error", "روش ارسال مورد نظر غیر فعال شده است، لطفا دوباره تلاش کنید");
        }

        // check products number
        if ($cartItems->count() != $order->products->count()) {
            return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا روند ثبت سفارش خود را تکرار کنید");
        }

        // check product discount
        if ($totalDiscount != $order->total_discount) {
            return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا روند ثبت سفارش خود را تکرار کنید");
        }

        // check final price
        if (($order->delivery->price + $totalPrice) - ($totalDiscount + $generalDiscountPrice) != $order->total_price) {
            return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا روند ثبت سفارش خود را تکرار کنید");
        }

        if ($payment_type == 2) {
            DB::transaction(function () use ($order, $cartItems, $generalDiscountPrice) {
                // update order
                $order->update([
                    "total_price" => $order->total_price - $order->coupon_discount,
                    "total_discount" => $order->total_discount + $order->coupon_discount + $generalDiscountPrice,
                    "delivery_status" => "processing"
                ]);

                Payment::create([
                    "order_id" => $order->id,
                    "amount" => $order->total_price,
                    "status" => "cash",
                    "payment_status" => "cash_payment"
                ]);

                // delete cartItems and update product
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;
                    $product->increment('sold_number', $cartItem->number);
                    $product->decrement('marketable_number', $cartItem->number);
                    $cartItem->delete();
                }
            });

            return to_route("home.profile.myOrders.index")->with("swal-success", "سفارش شما با موفقیت ثبت شد");
        } elseif ($payment_type == 1) {

            DB::transaction(function () use ($order, $generalDiscountPrice) {

                // update Order
                $order->update([
                    "total_price" => $order->total_price - $order->coupon_discount,
                    "total_discount" => $order->total_discount + $order->coupon_discount + $generalDiscountPrice,
                ]);
                // unit = Toman
                $amount = $order->total_price;
                $result = ShepaFacade::send($amount, Auth::user()->email, null, null, route("home.salesProcess.callback"));
                $token = Str::afterLast($result, '/');

                Payment::updateOrCreate(
                    ["order_id" => $order->id],
                    [
                        "token" => $token,
                        "amount" => $amount,
                        "status" => "online",
                        "payment_status" => "unpaid"
                    ]
                );

                $this->result = $result;
            });

            return redirect($this->result);
        }
    }

    public function callback(Request $request)
    {
        $token = $request->token;
        $payment = Payment::where("token", $token)->first();

        // check payment
        if (!$payment) {
            return to_route("home.index")->with("swal-error", "لطفا دوباره تلاش کنید");
        } elseif ($payment->order->user->id != Auth::user()->id) {
            return to_route("home.index")->with("swal-error", "لطفا دوباره تلاش کنید");
        }

        // set values
        $first_bank_response = $request->all();
        $second_bank_response = $payment->second_bank_response ?? null;
        $transaction_id = $payment->transaction_id ?? null;
        $payment_status = $payment->order->payment_status;
        $delivery_status = $payment->order->delivery_status;
        $payment_status_for_payment = $payment->payment_status;

        // check token and status
        if ($request->token && $request->status == 'success') {
            $result = ShepaFacade::verify($token, $payment->amount);
            if (isset($result["transaction_id"])) {
                // Payment was successful
                $transaction_id = $result["transaction_id"];
                $second_bank_response = $result;
                $payment_status = "paid";
                $payment_status_for_payment = "paid";
                $delivery_status = "processing";
            } elseif ($result["errorCode"] == 3) {
                // If the token is checked again
                return to_route("home.profile.myOrders.index")->with("swal-error", "پرداخت شما نامشخص است ، لطفا وضعیت پرداخت سفارش خود و همچنین حساب بانکی خود را چک کنید");
            } else {
                // Other errors
                $second_bank_response = $result;
            }
        } else {
            // Payment canceled
            $payment_status = "canceled";
            $delivery_status = "unpaid";
            $payment_status_for_payment = "unpaid";
        }

        // update values
        DB::transaction(function () use ($payment, $first_bank_response, $second_bank_response, $transaction_id, $payment_status_for_payment, $delivery_status, $payment_status) {
            // update payment fields
            $payment->update([
                "first_bank_response" => $first_bank_response,
                "second_bank_response" => $second_bank_response,
                "transaction_id" => $transaction_id,
                "payment_status" => $payment_status_for_payment
            ]);

            // update order status
            $payment->order->update([
                "payment_status" => $payment_status,
                "delivery_status" => $delivery_status,

            ]);

            if ($payment_status == "paid" && $delivery_status == "processing" && $payment_status_for_payment == "paid") {
                // delete cartItems and update product
                foreach (Auth::user()->cartItems as $cartItem) {
                    $product = $cartItem->product;
                    $product->increment('sold_number', $cartItem->number);
                    $product->decrement('marketable_number', $cartItem->number);
                    $cartItem->delete();
                }
            }
        });

        // redirect user to my orders page
        return to_route("home.profile.myOrders.index")->with("swal-success", "سفارش شما با موفقیت ثبت شده");
    }
}
