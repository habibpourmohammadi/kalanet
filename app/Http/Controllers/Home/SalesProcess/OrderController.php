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

    // Order registration
    public function submitOrder(SubmitOrderRequest $request)
    {
        // Get authenticated user
        $user = Auth::user();

        // Find address and delivery
        $address = Address::find($request->address);
        $delivery = Delivery::find($request->delivery_type);

        // Check if the address belongs to the authenticated user and delivery status is active
        if ($address->user_id != $user->id || $delivery->status != "active") {
            // Redirect back with error message if invalid data is submitted
            return redirect()->back()->with("swal-error", "اطلاعات ارسال شده نامعتبر است");
        }

        // Initialize total price, total discount, and total general discount
        $total_price = 0;
        $total_discount = 0;
        $total_general_discount = 0;

        // Find active general discount
        $generalDiscount = GeneralDiscount::where("start_date", "<", now())
            ->where("end_date", ">", now())
            ->where("status", "active")
            ->latest()
            ->first();

        // Calculate total price, total discount, and total general discount for each cart item
        foreach ($user->cartItems as $cartItem) {
            // Check if product is valid
            if (
                $cartItem->product->status != 'true' ||
                ($cartItem->color_id && !$cartItem->product->colors->contains('id', $cartItem->color_id)) ||
                ($cartItem->guarantee_id && !$cartItem->product->guarantees->contains('id', $cartItem->guarantee_id)) ||
                $cartItem->product->marketable != 'true' ||
                $cartItem->product->marketable_number < $cartItem->number
            ) {
                // Delete invalid cart item and redirect to home page with error message
                $cartItem->delete();
                return redirect()->route("home.index")->with("swal-error", "یکی از محصولات سبد خرید شما مشکلی دارد. لطفاً سبد خرید خود را بررسی نمایید.");
            }

            // Calculate total price and total discount
            $total_price += $cartItem->totalPrice();
            $total_discount += $cartItem->product->discount * $cartItem->number;

            // Calculate total general discount if applicable
            if ($generalDiscount) {
                $total_general_discount += $generalDiscount->generalDiscount($cartItem->product->price, $cartItem->product->discount) * $cartItem->number;
            }
        }

        // Start database transaction to create/update order and attach products
        DB::transaction(function () use ($user, $address, $delivery, $total_price, $total_discount, $total_general_discount, $generalDiscount) {
            // Generate tracking ID if not exists
            $tracking_id = $user->orders()->where("payment_status", "unpaid")->where("status", "not_confirmed")->where("delivery_status", "unpaid")->value('tracking_id') ?? rand(11111111, 99999999);

            // Find or create order
            $order = $user->orders()->updateOrCreate(
                ['payment_status' => "unpaid", 'status' => "not_confirmed", 'delivery_status' => "unpaid", 'tracking_id' => $tracking_id],
                [
                    'address_id' => $address->id,
                    'delivery_id' => $delivery->id,
                    'general_discount_id' => $generalDiscount ? $generalDiscount->id : null,
                    'delivery_price' => $delivery->price,
                    'total_price' => $total_price,
                    'total_discount' => $total_discount,
                    'total_general_discount' => $total_general_discount,
                    'final_price' => ($total_price + $delivery->price) - ($total_discount + $total_general_discount),
                    'user_obj' => $user->only(['id', 'name', 'email']),
                    'address_obj' => $address,
                    'delivery_obj' => $delivery,
                    'general_discount_obj' => $generalDiscount
                ]
            );

            // Detach existing products from order
            $order->products()->detach();

            // Attach products to order with relevant details
            foreach ($user->cartItems as $cartItem) {
                // Get color price if exists
                $color_price = $cartItem->color ? $cartItem->product->colors->where("id", $cartItem->color_id)->first()->pivot->price : null;

                // Get guarantee price if exists
                $guarantee_price = $cartItem->guarantee ? $cartItem->product->guarantees->where("id", $cartItem->guarantee_id)->first()->pivot->price : null;

                // Calculate product total general discount
                $product_total_general_discount = $generalDiscount ? $generalDiscount->generalDiscount($cartItem->product->price, $cartItem->product->discount) * $cartItem->number : 0;

                // Attach product to order
                $order->products()->attach($cartItem->product->id, [
                    'color_name' => $cartItem->color->name ?? null,
                    "color_hex_code" => $cartItem->color->hex_code ?? null,
                    "color_price" => $color_price,
                    "guarantee_persian_name" => $cartItem->guarantee->persian_name ?? null,
                    "guarantee_price" => $guarantee_price,
                    "product_price" => $cartItem->product->price,
                    "product_discount" => $cartItem->product->discount,
                    "number" => $cartItem->number,
                    "total_price" => $cartItem->totalPrice(),
                    "total_discount" => $cartItem->product->discount * $cartItem->number,
                    "total_general_discount" => $product_total_general_discount,
                    "final_price" => $cartItem->totalPrice() - ($product_total_general_discount + ($cartItem->product->discount * $cartItem->number)),
                    "product_obj" => $cartItem->product->toJson()
                ]);
            }
        });

        // Redirect to the payment page
        return redirect()->route("home.salesProcess.payment.page");
    }

    // Displaying the payment method selection page.
    public function paymentPage()
    {
        // Fetching the unpaid and not confirmed order for the authenticated user.
        $order = Auth::user()->orders->where("payment_status", "unpaid")
            ->where("status", "not_confirmed")
            ->where("delivery_status", "unpaid")
            ->first();

        // If no such order exists, redirect back with an error message.
        if ($order == null) {
            return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا دوباره تلاش کنید.");
        }

        // Fetching the currently active general discount, if any.
        $generalDiscount = GeneralDiscount::where("start_date", "<", now())
            ->where("end_date", ">", now())
            ->where("status", "active")
            ->latest()
            ->first();

        // Initializing variables for calculating total price, total discount, and general discount price.
        $total_price = 0;
        $total_discount = 0;
        $generalDiscountPrice = 0;

        // Calculating total price, total discount, and general discount price for each item in the user's cart.
        foreach (Auth::user()->cartItems as $cartItem) {
            $total_price += $cartItem->totalPrice();
            $total_discount += $cartItem->product->discount * $cartItem->number;

            // Applying the general discount if it exists.
            if ($generalDiscount !== null) {
                $generalDiscountPrice += $generalDiscount->generalDiscount($cartItem->product->price, $cartItem->product->discount) * $cartItem->number;
            }
        }

        // Rendering the payment page view with necessary data.
        return view("home.salesProcess.payment.index", compact("order", "total_price", "total_discount", "generalDiscountPrice"));
    }

    // Validates and applies a discount coupon to the current order.
    public function checkCoupon(CouponRequest $request)
    {
        // Retrieve the coupon based on the provided code.
        $coupon = Coupon::where("coupon", $request->coupon)->first();

        // Retrieve the unpaid and not confirmed order for the authenticated user.
        $order = Auth::user()->orders->where("payment_status", "unpaid")
            ->where("status", "not_confirmed")
            ->where("delivery_status", "unpaid")
            ->first();

        // Check if the order already has a coupon applied.
        if ($order->coupon_id != null) {
            return back()->with("swal-error", "کوپن تخفیف قبلاً برای این سفارش اعمال شده است.");
        }

        // Update the order with the applied coupon details.
        $order->update([
            "coupon_id" => $coupon->id,
            "coupon_obj" => $coupon,
        ]);

        return back()->with("swal-success", "کوپن تخفیف شما با موفقیت اعمال شد.");
    }

    // Handles the payment process for placing an order
    public function payment(PaymentRequest $request)
    {
        // Retrieve payment type from the request
        $payment_type = $request->payment_type;

        // Retrieve the unpaid and not confirmed order for the authenticated user
        $order = Auth::user()->orders->where("payment_status", "unpaid")
            ->where("status", "not_confirmed")
            ->where("delivery_status", "unpaid")
            ->first();

        // Retrieve cart items and general discount
        $cartItems = Auth::user()->cartItems;
        $generalDiscount = GeneralDiscount::where("start_date", "<", now())
            ->where("end_date", ">", now())
            ->where("status", "active")
            ->latest()
            ->first();

        // Initialize variables for total price, total discount, and general discount price
        $totalPrice = 0;
        $totalDiscount = 0;
        $generalDiscountPrice = 0;

        // Check the validity of cart items and calculate prices and discounts
        foreach ($cartItems as $cartItem) {
            // Validate product and related attributes
            if (
                $cartItem->product->status != 'true' ||
                ($cartItem->color_id != null && $cartItem->product->colors->where("id", $cartItem->color->id)->first() == null) ||
                ($cartItem->guarantee_id != null && $cartItem->product->guarantees->where("id", $cartItem->guarantee->id)->first() == null) ||
                $cartItem->product->marketable != 'true' ||
                $cartItem->product->marketable_number < $cartItem->number
            ) {
                $cartItem->delete();
                return to_route("home.salesProcess.myCart")->with("swal-error", "یکی از محصولات موجود در سبد خرید شما مشکل دارد. لطفا سبد خرید خود را بررسی کنید.");
            }

            // Calculate general discount price.
            if ($generalDiscount != null) {
                $generalDiscountPrice += $generalDiscount->generalDiscount($cartItem->product->price, $cartItem->product->discount) * $cartItem->number;
            }

            // Calculate total price and total discount.
            $totalPrice += $cartItem->totalPrice();
            $totalDiscount += $cartItem->product->discount * $cartItem->number;
        }

        // Check if general discount is properly applied.
        if ($order->generalDiscount == null && $generalDiscount != null) {
            $order->update([
                "general_discount_id" => null,
                "general_discount_obj" => null,
            ]);
            return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا دوباره فرآیند ثبت سفارش را طی کنید.");
        }

        // Validate applied general discount.
        if ($order->generalDiscount != null) {
            // Ensure applied general discount matches the stored details and is still valid.
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
                return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا دوباره فرآیند ثبت سفارش را طی کنید.");
            }
        }

        // Validate and apply coupon discount.
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
                return back()->with("swal-error", "کوپن تخفیف شما مشکل دارد. لطفا دوباره تلاش کنید.");
            } elseif ($coupon->type == "private") {
                if ($coupon->user_id != Auth::user()->id) {
                    $order->update([
                        "coupon_id" => null,
                        "coupon_obj" => null,
                    ]);
                    return back()->with("swal-error", "کوپن تخفیف شما مشکل دارد. لطفا دوباره تلاش کنید.");
                }
            }
        }

        // Check delivery details
        if ($order->delivery->price != $order->delivery_price) {
            return to_route("home.salesProcess.myCart")->with("swal-error", "هزینه ارسال تغییر کرده است. لطفا سبد خرید خود را بررسی کنید.");
        } elseif ($order->delivery->status != "active") {
            return to_route("home.salesProcess.myCart")->with("swal-error", "روش ارسال انتخاب شده در دسترس نیست. لطفا سبد خرید خود را بررسی کنید.");
        }

        // Check number of products in the order.
        if ($cartItems->count() != $order->products->count()) {
            return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا دوباره فرآیند ثبت سفارش را طی کنید.");
        }

        // Check product discounts.
        if ($totalDiscount != $order->total_discount) {
            return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا دوباره فرآیند ثبت سفارش را طی کنید.");
        }

        // Check final price.
        if (($order->delivery_price + $totalPrice) - ($totalDiscount + $generalDiscountPrice) != $order->final_price) {
            return to_route("home.salesProcess.myCart")->with("swal-error", "لطفا دوباره فرآیند ثبت سفارش را طی کنید.");
        }

        // Process payment based on payment type.
        if ($payment_type == 2) {
            // Cash payment
            DB::transaction(function () use ($order, $cartItems) {
                // Update order details
                $order->update([
                    "final_price" => $order->final_price - $order->coupon_discount,
                    "total_coupon_discount" => $order->coupon_discount,
                    "delivery_status" => "processing",
                ]);

                // Create payment record for cash payment
                Payment::create([
                    "order_id" => $order->id,
                    "amount" => $order->final_price,
                    "status" => "cash",
                    "payment_status" => "cash_payment"
                ]);

                // Update product and delete cart items
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;
                    $product->increment('sold_number', $cartItem->number);
                    $product->decrement('marketable_number', $cartItem->number);
                    $cartItem->delete();
                }
            });

            return to_route("home.profile.myOrders.index")->with("swal-success", "سفارش شما با موفقیت انجام شد.");
        } elseif ($payment_type == 1) {
            // Online payment
            DB::transaction(function () use ($order) {
                // Update order details
                $order->update([
                    "final_price" => $order->final_price - $order->coupon_discount,
                    "total_coupon_discount" => $order->coupon_discount,
                ]);

                // Send payment request to the payment gateway
                $amount = $order->final_price;
                $result = ShepaFacade::send($amount, Auth::user()->email, null, null, route("home.salesProcess.callback"));
                $token = Str::afterLast($result, '/');

                // Create payment record for online payment
                Payment::updateOrCreate(
                    ["order_id" => $order->id],
                    [
                        "token" => $token,
                        "amount" => $amount,
                        "status" => "online",
                        "payment_status" => "unpaid"
                    ]
                );

                // Store payment result for redirection
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
