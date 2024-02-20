<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductColor\StoreRequest;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $search = request()->search;

        $colors = $product->colors()->when($search, function ($colors) use ($search) {
            return $colors->where("name", "like", "%$search%")->orWhere("hex_code", "like", "%$search%")->orWhere("price", "like", "%$search%")->get();
        }, function ($colors) {
            return $colors->get();
        });

        return view("admin.product.product-colors.index", compact("colors", "product"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        $unauthorized_ids = [];

        foreach ($product->colors as $color) {
            array_push($unauthorized_ids, $color->id);
        }

        $colors = Color::whereNotIn('id', $unauthorized_ids)->get();
        return view("admin.product.product-colors.create", compact("product", "colors"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, Product $product)
    {
        $unauthorized_ids = [];

        foreach ($product->colors as $color) {
            array_push($unauthorized_ids, $color->id);
        }

        if (in_array($request->color_id, $unauthorized_ids)) {
            return to_route("admin.product.product-color.index", $product)->with("swal-error", "مشکلی پیش آمده ، لطفا دوباره تلاش کنید");
        }

        $product->colors()->attach($request->color_id, ["price" => $request->price]);

        return to_route("admin.product.product-color.index", $product)->with("swal-success", "رنگ جدید شما برای محصول مورد نظر ثبت شد");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, Color $color)
    {
        return view("admin.product.product-colors.edit", compact("product", "color"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Product $product, Color $color)
    {
        if (!$product->colors()->where("id", $color->id)->first()) {
            return to_route("admin.product.product-guarantees.index", $product)->with("swal-error", "مشکلی پیش آمده ، لطفا دوباره تلاش کنید");
        }

        $product->colors()->syncWithoutDetaching([$color->id => ["price" => $request->price]]);

        return to_route("admin.product.product-color.index", $product)->with("swal-success", "رنگ شما برای محصول مورد نظر ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Color $color)
    {
        $product->colors()->detach($color->id);

        return to_route("admin.product.product-color.index", $product)->with("swal-success", "رنگ مورد نظر با موفقیت حذف شد");
    }
}
