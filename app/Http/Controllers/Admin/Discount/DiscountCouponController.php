<?php

namespace App\Http\Controllers\Admin\Discount;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Discount\Coupon\StoreRequest;
use App\Http\Requests\Admin\Discount\Coupon\UpdateRequest;

class DiscountCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Coupon::class);

        $search = request()->search;

        $coupons = Coupon::query()->when($search, function ($coupons) use ($search) {
            return $coupons->where("coupon", "like", "%$search%")->orWhere("amount", "like", "%$search%")->orWhere("discount_limit", "like", "%$search%")->orWhere("start_date", "like", "%$search%")->orWhere("end_date", "like", "%$search%")->orWhere("unit", "like", "%$search%")->orWhereHas("user", function ($users) use ($search) {
                $users->where("name", "like", "%$search%")->orWhere("email", "like", "%$search%");
            })->with("user")->get();
        }, function ($coupons) {
            return $coupons->get();
        });

        return view("admin.discount.coupon.index", compact("coupons"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Coupon::class);

        $users = User::all();
        return view("admin.discount.coupon.create", compact("users"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Coupon::class);

        $inputs = $request->validated();

        if ($request->type == "public") {
            $inputs["user_id"] = null;
        }

        $inputs["start_date"] = date("Y-m-d H:i:s", substr($request->start_date, 0, 10));
        $inputs["end_date"] = date("Y-m-d H:i:s", substr($request->end_date, 0, 10));

        Coupon::create([
            "coupon" => $inputs["coupon"],
            "unit" => $inputs["unit"],
            "amount" => $inputs["amount"],
            "discount_limit" => $inputs["discount_limit"],
            "type" => $inputs["type"],
            "user_id" => $inputs["user_id"],
            "start_date" => $inputs["start_date"],
            "end_date" => $inputs["end_date"],
        ]);

        return to_route("admin.discount.coupon.index")->with("swal-success", "کوپن تخفیف جدید شما با موفقیت ایجاد شد");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        $this->authorize('update', [$coupon]);

        $users = User::all();
        return view("admin.discount.coupon.edit", compact("users", "coupon"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Coupon $coupon)
    {
        $this->authorize('update', [$coupon]);

        $inputs = $request->validated();

        if ($request->type == "public") {
            $inputs["user_id"] = $coupon->user_id;
        }

        $inputs["start_date"] = date("Y-m-d H:i:s", substr($request->start_date, 0, 10));
        $inputs["end_date"] = date("Y-m-d H:i:s", substr($request->end_date, 0, 10));

        $coupon->update([
            "coupon" => $inputs["discountCoupon"],
            "unit" => $inputs["unit"],
            "amount" => $inputs["amount"],
            "discount_limit" => $inputs["discount_limit"],
            "type" => $inputs["type"],
            "user_id" => $inputs["user_id"],
            "start_date" => $inputs["start_date"],
            "end_date" => $inputs["end_date"],
        ]);

        return to_route("admin.discount.coupon.index")->with("swal-success", "کوپن تخفیف مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete', [$coupon]);

        DB::transaction(function () use ($coupon) {
            $coupon->update([
                "coupon" => $coupon->coupon . $coupon->id
            ]);

            $coupon->delete();
        });

        return to_route("admin.discount.coupon.index")->with("swal-success", "کوپن تخفیف مورد نظر با موفقیت حذف شد");
    }


    public function changeStatus(Coupon $coupon)
    {
        $this->authorize('changeStatus', [$coupon]);

        if ($coupon->status == "deactive") {
            $coupon->update([
                "status" => "active"
            ]);
            return back()->with("swal-success", "وضعیت کوپن مورد نظر با موفقیت به (فعال) تغییر یافت");
        } else {
            $coupon->update([
                "status" => "deactive"
            ]);
            return back()->with("swal-success", "وضعیت کوپن مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        }
    }
}
