<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\Color\StoreRequest;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;
        $colors = Color::query()->when($search, function ($colors) use ($search) {
            return $colors->where("name", "like", "%$search%")->orWhere("hex_code", "like", "%$search%")->get();
        }, function ($colors) {
            return $colors->get();
        });

        return view("admin.product.color.index", compact("colors"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.product.color.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated();

        Color::create([
            "name" => $inputs["name"],
            "hex_code" => $inputs["hex_code"],
        ]);

        return to_route("admin.product.color.index")->with("swal-success", "رنگ جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view("admin.product.color.edit", compact("color"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Color $color)
    {
        $inputs = $request->validated();

        $color->update([
            "name" => $inputs["name"],
            "hex_code" => $inputs["hex_code"],
        ]);

        return to_route("admin.product.color.index")->with("swal-success", "رنگ مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();

        return back()->with("swal-success", "رنگ مورد نظر با موفقیت حذف شد");
    }
}
