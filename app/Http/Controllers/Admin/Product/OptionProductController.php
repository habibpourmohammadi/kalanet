<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\Option\StoreRequest;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class OptionProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $search = request()->search;

        $options = $product->options()->when($search, function ($options) use ($search) {
            return $options->where("title", "like", "%$search%")->orWhere("option", "like", "%$search%")->orWhereHas("product", function ($products) use ($search) {
                $products->where("name", "like", "%$search%");
            })->with("product")->get();
        }, function ($options) {
            return $options->with("product")->get();
        });

        return view("admin.product.option.index", compact("options", "product"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view("admin.product.option.create", compact("product"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, Product $product)
    {
        $inputs = $request->validated();

        ProductOption::create([
            "title" => $inputs["title"],
            "option" => $inputs["option"],
            "product_id" => $product->id,
        ]);

        return to_route("admin.product.option.index", $product)->with("swal-success", "ویژگی جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, ProductOption $option)
    {
        return view("admin.product.option.show", compact("product", "option"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, ProductOption $option)
    {
        return view("admin.product.option.edit", compact("product", "option"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Product $product, ProductOption $option)
    {
        $inputs = $request->validated();

        $option->update([
            "title" => $inputs["title"],
            "option" => $inputs["option"],
        ]);

        return to_route("admin.product.option.index", $product)->with("swal-success", "ویژگی مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductOption $option)
    {
        $option->delete();

        return back()->with("swal-success", "ویژگی مورد نظر با موفقیت حذف شد");
    }
}
