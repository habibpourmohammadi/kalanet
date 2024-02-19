<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product;
use App\Models\Guarantee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductGuarantee\StoreRequest;
use App\Http\Requests\Admin\Product\ProductGuarantee\UpdateRequest;

class ProductGuaranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $search = request()->search;

        $guarantees = $product->guarantees()->when($search, function ($guarantees) use ($search) {
            return $guarantees->where("persian_name", "like", "%$search%")->orWhere("original_name", "like", "%$search%")->get();
        }, function ($guarantees) {
            return $guarantees->get();
        });

        return view("admin.product.product-guarantees.index", compact("product", "guarantees"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        $unauthorized_ids = [];

        foreach ($product->guarantees as $guarantee) {
            array_push($unauthorized_ids, $guarantee->id);
        }

        $guarantees = Guarantee::whereNotIn('id', $unauthorized_ids)->get();
        return view("admin.product.product-guarantees.create", compact("product", "guarantees"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, Product $product)
    {
        $unauthorized_ids = [];

        foreach ($product->guarantees as $guarantee) {
            array_push($unauthorized_ids, $guarantee->id);
        }

        if (in_array($request->guarantee_id, $unauthorized_ids)) {
            return to_route("admin.product.product-guarantees.index", $product)->with("swal-error", "مشکلی پیش آمده ، لطفا دوباره تلاش کنید");
        }

        $product->guarantees()->attach($request->guarantee_id, ["price" => $request->price]);

        return to_route("admin.product.product-guarantees.index", $product)->with("swal-success", "گارانتی جدید شما برای محصول مورد نظر ثبت شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, Guarantee $guarantee)
    {
        return view("admin.product.product-guarantees.edit", compact("product", "guarantee"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product, Guarantee $guarantee)
    {
        if (!$product->guarantees()->where("id", $guarantee->id)->first()) {
            return to_route("admin.product.product-guarantees.index", $product)->with("swal-error", "مشکلی پیش آمده ، لطفا دوباره تلاش کنید");
        }

        $product->guarantees()->syncWithoutDetaching([$guarantee->id => ["price" => $request->price]]);

        return to_route("admin.product.product-guarantees.index", $product)->with("swal-success", "گارانتی شما برای محصول مورد نظر ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Guarantee $guarantee)
    {
        $product->guarantees()->detach($guarantee->id);

        return to_route("admin.product.product-guarantees.index", $product)->with("swal-success", "گارانتی مورد نظر با موفقیت حذف شد");
    }
}
