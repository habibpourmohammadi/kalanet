<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\Delivery\StoreRequest;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $deliveries = Delivery::query()->when($search, function ($deliveries) use ($search) {
            return $deliveries->where("name", "like", "%$search%")->orWhere("delivery_time", "like", "%$search%")->orWhere("delivery_time_unit", "like", "%$search%")->orWhere("price", "like", "%$search%")->get();
        }, function ($deliveries) {
            return $deliveries->get();
        });

        return view("admin.order.delivery.index", compact("deliveries"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.order.delivery.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated();

        Delivery::create([
            "name" => $inputs["name"],
            "delivery_time" => $inputs["delivery_time"],
            "delivery_time_unit" => $inputs["delivery_time_unit"],
            "price" => $inputs["price"],
        ]);

        return to_route("admin.order.delivery.index")->with("swal-success", "حمل و نقل جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        return view("admin.order.delivery.edit", compact("delivery"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Delivery $delivery)
    {
        $inputs = $request->validated();

        $delivery->update([
            "name" => $inputs["name"],
            "delivery_time" => $inputs["delivery_time"],
            "delivery_time_unit" => $inputs["delivery_time_unit"],
            "price" => $inputs["price"],
        ]);

        return to_route("admin.order.delivery.index")->with("swal-success", "حمل و نقل مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return back()->with("swal-success", "حمل و نقل مورد نظر با موفقیت حذف شد");
    }

    public function changeStatus(Delivery $delivery)
    {
        if ($delivery->status == "deactive") {
            $delivery->update([
                "status" => "active"
            ]);
            return back()->with("swal-success", "وضعیت حمل و نقل مورد نظر با موفقیت به (فعال) تغییر یافت");
        } else {
            $delivery->update([
                "status" => "deactive"
            ]);
            return back()->with("swal-success", "وضعیت حمل و نقل مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        }
    }
}
