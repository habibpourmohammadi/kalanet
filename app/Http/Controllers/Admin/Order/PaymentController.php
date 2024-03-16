<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Payment::class);

        $search = request()->search;

        $payments = Payment::query()->when($search, function ($payments) use ($search) {
            return $payments->where("amount", "like", "%$search%")->orWhere("transaction_id", "like", "%$search%")->orWhereHas("order", function ($orders) use ($search) {
                $orders->where("tracking_id", "like", "%$search%");
            })->with("order")->get();
        }, function ($payments) {
            return $payments->with("order")->get();
        });

        return view("admin.order.payment.index", compact("payments"));
    }

    // change status
    public function changeStatus(Payment $payment)
    {
        $this->authorize('changeStatus', [$payment]);

        if ($payment->payment_status == "paid") {
            if ($payment->status == "cash") {
                $payment->update([
                    "payment_status" => "cash_payment",
                ]);

                return back()->with("swal-success", "وضعیت پرداخت ، تراکنش مورد نظر با موفقیت به (در محل (پرداخت نشده)) تغییر یافت");
            } else {
                $payment->update([
                    "payment_status" => "unpaid",
                ]);

                return back()->with("swal-success", "وضعیت پرداخت ، تراکنش مورد نظر با موفقیت به (پرداخت نشده) تغییر یافت");
            }
        } elseif ($payment->payment_status == "unpaid") {

            $payment->update([
                "payment_status" => "paid",
            ]);

            return back()->with("swal-success", "وضعیت پرداخت ، تراکنش مورد نظر با موفقیت به (پرداخت شده) تغییر یافت");
        } elseif ($payment->payment_status == "cash_payment") {
            $payment->update([
                "payment_status" => "paid",
            ]);

            return back()->with("swal-success", "وضعیت پرداخت ، تراکنش مورد نظر با موفقیت به (پرداخت شده) تغییر یافت");
        }
    }
}
