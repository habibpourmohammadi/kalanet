<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;
        $orders = Order::query()->when($search, function ($orders) use ($search) {
            return $orders->where("tracking_id", "like", "%$search%")->orWhere("total_price", "like", "%$search%")->orWhereHas("user", function ($users) use ($search) {
                $users->where("name", "like", "%$search%")->orWhere("email", "like", "%$search%");
            })->orWhereHas("address", function ($addresses) use ($search) {
                $addresses->where("address", "like", "%$search%")->orWhere("postal_code", "like", "%$search%")->orWhere("mobile", "like", "%$search%")->orWhere("recipient_first_name", "like", "%$search%")->orWhere("recipient_last_name", "like", "%$search%")->orWhere("recipient_mobile", "like", "%$search%")->orWhereHas("city", function ($q) use ($search) {
                    $q->where("name", "like", "%$search%");
                })->orWhereHas("province", function ($q) use ($search) {
                    $q->where("name", "like", "%$search%");
                })->with("city", "province");
            })->orWhereHas("delivery", function ($deliveries) use ($search) {
                $deliveries->where("name", "like", "%$search%")->orWhere("delivery_time", "like", "%$search%")->orWhere("delivery_time_unit", "like", "%$search%")->orWhere("price", "like", "%$search%");
            })->orWhereHas("payment", function ($payments) use ($search) {
                $payments->where("amount", "like", "%$search%")->orWhere("transaction_id", "like", "%$search%");
            })->with("user", "address", "delivery", "payment")->get();
        }, function ($orders) {
            return $orders->with("user", "address", "delivery", "payment")->get();
        });

        return view("admin.order.index", compact("orders"));
    }

    public function filter()
    {
        $filter = request()->filter;
        $search = request()->search;

        if ($filter != 'paid' && $filter != 'unpaid' && $filter != 'returned' && $filter != 'canceled') {
            return to_route("admin.order.all.index");
        }

        $orders = Order::query()->when($search, function ($orders) use ($search) {
            return $orders->where("tracking_id", "like", "%$search%")->orWhere("total_price", "like", "%$search%")->orWhereHas("user", function ($users) use ($search) {
                $users->where("name", "like", "%$search%")->orWhere("email", "like", "%$search%");
            })->orWhereHas("address", function ($addresses) use ($search) {
                $addresses->where("address", "like", "%$search%")->orWhere("postal_code", "like", "%$search%")->orWhere("mobile", "like", "%$search%")->orWhere("recipient_first_name", "like", "%$search%")->orWhere("recipient_last_name", "like", "%$search%")->orWhere("recipient_mobile", "like", "%$search%")->orWhereHas("city", function ($q) use ($search) {
                    $q->where("name", "like", "%$search%");
                })->orWhereHas("province", function ($q) use ($search) {
                    $q->where("name", "like", "%$search%");
                })->with("city", "province");
            })->orWhereHas("delivery", function ($deliveries) use ($search) {
                $deliveries->where("name", "like", "%$search%")->orWhere("delivery_time", "like", "%$search%")->orWhere("delivery_time_unit", "like", "%$search%")->orWhere("price", "like", "%$search%");
            })->orWhereHas("payment", function ($payments) use ($search) {
                $payments->where("amount", "like", "%$search%")->orWhere("transaction_id", "like", "%$search%");
            })->with("user", "address", "delivery", "payment")->get();
        }, function ($orders) use ($filter) {
            return $orders->with("user", "address", "delivery", "payment")->get();
        });

        $orders = $orders->where("payment_status", $filter);

        return view("admin.order.filter", compact("orders"));
    }


    public function show(Order $order)
    {
        return view("admin.order.show", compact("order"));
    }


    public function details(Order $order)
    {
        return view("admin.order.details", compact("order"));
    }


    public function changePaymentStatus(Order $order)
    {
        $payment_status = null;

        switch ($order->payment_status) {
            case 'paid':
                $payment_status = "unpaid";
                break;
            case 'unpaid':
                $payment_status = "returned";
                break;
            case 'returned':
                $payment_status = "canceled";
                break;
            case 'canceled':
                $payment_status = "paid";
                break;

            default:
                return back()->with("swal-error", "لطفا دوباره تلاش کنید");
                break;
        }

        $order->update([
            "payment_status" => $payment_status
        ]);

        return back()->with("swal-success", "وضعیت پرداخت سفارش مورد نظر با موفقیت به (" . $order->paymentStatus() . ") تغییر کرد");
    }

    public function changeDeliveryStatus(Order $order)
    {
        $delivery_status = null;

        switch ($order->delivery_status) {
            case 'unpaid':
                $delivery_status = "processing";
                break;
            case 'processing':
                $delivery_status = "delivered";
                break;
            case 'delivered':
                $delivery_status = "unpaid";
                break;

            default:
                return back()->with("swal-error", "لطفا دوباره تلاش کنید");
                break;
        }

        $order->update([
            "delivery_status" => $delivery_status
        ]);

        return back()->with("swal-success", "وضعیت ارسال سفارش مورد نظر با موفقیت به (" . $order->deliveryStatus() . ") تغییر کرد");
    }

    public function changeStatus(Order $order)
    {
        if ($order->status == "not_confirmed") {
            $order->update([
                "status" => "confirmed"
            ]);

            return back()->with("swal-success", "وضعیت سفارش مورد نظر با موفقیت به (تایید شده) تغییر یافت");
        } else {
            $order->update([
                "status" => "not_confirmed"
            ]);

            return back()->with("swal-success", "وضعیت سفارش مورد نظر با موفقیت به (تایید نشده) تغییر یافت");
        }
    }
}
