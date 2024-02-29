<?php

namespace App\Http\Controllers\Admin\Order;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\City\StoreRequest;
use App\Http\Requests\Admin\Order\City\UpdateRequest;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;
        $sort = request()->sort;

        if ($sort == null) {
            $sort = "DESC";
        }

        $cities = City::query()->when($search, function ($cities) use ($search, $sort) {
            return $cities->where("name", "like", "%$search%")->orWhereHas("province", function ($provinces) use ($search) {
                $provinces->where("name", "like", "%$search%");
            })->orderBy("province_id", $sort)->with("province")->get();
        }, function ($cities) use ($sort) {
            return $cities->with("province")->orderBy("province_id", $sort)->get();
        });

        return view("admin.order.city.index", compact("cities"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::where("status", "active")->get();
        return view("admin.order.city.create", compact("provinces"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        City::create([
            "name" => $request->name,
            "province_id" => $request->province_id,
        ]);

        return to_route("admin.order.city.index")->with("swal-success", "شهر جدید شما با موفقیت ایجاد شد");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $provinces = Province::where("status", "active")->get();
        return view("admin.order.city.edit", compact("provinces", "city"));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, City $city)
    {
        $city->update([
            "name" => $request->name,
            "province_id" => $request->province_id,
        ]);

        return to_route("admin.order.city.index")->with("swal-success", "شهر مورد نظر با موفقیت ویرایش شد");
    }


    public function changeStatus(City $city)
    {
        if ($city->status == "deactive") {
            $city->update([
                "status" => "active"
            ]);
            return back()->with("swal-success", "وضعیت شهر مورد نظر با موفقیت به (فعال) تغییر یافت");
        } else {
            $city->update([
                "status" => "deactive"
            ]);
            return back()->with("swal-success", "وضعیت شهر مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();
        return back()->with("swal-success", "شهر مورد نظر با موفقیت حذف شد");
    }
}
