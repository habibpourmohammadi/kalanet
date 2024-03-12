<?php

namespace App\Http\Controllers\Admin\Discount;

use Illuminate\Http\Request;
use App\Models\GeneralDiscount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Discount\General\StoreRequest;

class GeneralDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $generalDiscounts = GeneralDiscount::query()->when($search, function ($generalDiscounts) use ($search) {
            return $generalDiscounts->Where("amount", "like", "%$search%")->orWhere("discount_limit", "like", "%$search%")->orWhere("start_date", "like", "%$search%")->orWhere("end_date", "like", "%$search%")->orWhere("unit", "like", "%$search%")->get();
        }, function ($generalDiscounts) {
            return $generalDiscounts->get();
        });

        return view("admin.discount.general.index", compact("generalDiscounts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.discount.general.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated();

        $inputs["start_date"] = date("Y-m-d H:i:s", substr($request->start_date, 0, 10));
        $inputs["end_date"] = date("Y-m-d H:i:s", substr($request->end_date, 0, 10));

        GeneralDiscount::create([
            "unit" => $inputs["unit"],
            "amount" => $inputs["amount"],
            "discount_limit" => $inputs["discount_limit"],
            "start_date" => $inputs["start_date"],
            "end_date" => $inputs["end_date"],
        ]);

        return to_route("admin.discount.general.index")->with("swal-success", "تخفیف عمومی جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GeneralDiscount $discount)
    {
        return view("admin.discount.general.edit", compact("discount"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, GeneralDiscount $discount)
    {
        $inputs = $request->validated();

        $inputs["start_date"] = date("Y-m-d H:i:s", substr($request->start_date, 0, 10));
        $inputs["end_date"] = date("Y-m-d H:i:s", substr($request->end_date, 0, 10));

        $discount->update([
            "unit" => $inputs["unit"],
            "amount" => $inputs["amount"],
            "discount_limit" => $inputs["discount_limit"],
            "start_date" => $inputs["start_date"],
            "end_date" => $inputs["end_date"],
        ]);

        return to_route("admin.discount.general.index")->with("swal-success", "تخفیف عمومی مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GeneralDiscount $discount)
    {
        $discount->delete();

        return to_route("admin.discount.general.index")->with("swal-success", "تخفیف عمومی مورد نظر با موفقیت حذف شد");
    }


    public function changeStatus(GeneralDiscount $discount)
    {
        if ($discount->status == "deactive") {
            $discount->update([
                "status" => "active"
            ]);
            return back()->with("swal-success", "وضعیت تخفیف عمومی مورد نظر با موفقیت به (فعال) تغییر یافت");
        } else {
            $discount->update([
                "status" => "deactive"
            ]);
            return back()->with("swal-success", "وضعیت تخفیف عمومی مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        }
    }
}
