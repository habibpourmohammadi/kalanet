<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\Province\StoreRequest;
use App\Http\Requests\Admin\Order\Province\UpdateRequest;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Province::class);

        $search = request()->search;

        $provinces = Province::query()->when($search, function ($provinces) use ($search) {
            return $provinces->where("name", "like", "%$search%")->get();
        }, function ($provinces) {
            return $provinces->get();
        });

        return view("admin.order.province.index", compact("provinces"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Province::class);

        return view("admin.order.province.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Province::class);

        Province::create([
            "name" => $request->name
        ]);

        return to_route("admin.order.province.index")->with("swal-success", "استان جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        $this->authorize('update', [$province]);

        return view("admin.order.province.edit", compact("province"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Province $province)
    {
        $this->authorize('update', [$province]);

        $province->update([
            "name" => $request->name
        ]);

        return to_route("admin.order.province.index")->with("swal-success", "استان مورد نظر با موفقیت ویرایش شد");
    }

    public function changeStatus(Province $province)
    {
        $this->authorize('update', [$province]);

        if ($province->status == "deactive") {
            $province->update([
                "status" => "active"
            ]);

            return back()->with("swal-success", "وضعیت استان مورد نظر با موفقیت به (فعال) تغییر کرد");
        } else {
            $province->update([
                "status" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت استان مورد نظر با موفقیت به (غیر فعال) تغییر کرد");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        $this->authorize('delete', [$province]);

        $province->delete();
        return back()->with("swal-success", "استان مورد نظر با موفقیت حذف شد");
    }
}
