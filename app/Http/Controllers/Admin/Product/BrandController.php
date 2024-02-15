<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Admin\Product\Brand\StoreRequest;
use App\Http\Requests\Admin\Product\Brand\UpdateRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view("admin.product.brand.index", compact("brands"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.product.brand.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated();

        if ($request->hasFile("logo_path")) {
            $inputs["logo_path"] = $request->file("logo_path");
            $imageName = time() . '.' . $inputs["logo_path"]->extension();
            $imagePath = public_path('images' . DIRECTORY_SEPARATOR . "brand" . DIRECTORY_SEPARATOR . $imageName);
            Image::make($inputs["logo_path"]->getRealPath())->save($imagePath);
            $inputs["logo_path"] = 'images' . DIRECTORY_SEPARATOR . "brand" . DIRECTORY_SEPARATOR . $imageName;
        } else {
            $inputs["logo_path"] = null;
        }

        $inputs["slug"] = str_replace(" ", "-", $inputs["persian_name"]);

        Brand::create([
            "original_name" => $inputs["original_name"],
            "persian_name" => $inputs["persian_name"],
            "description" => $inputs["description"],
            "slug" => $inputs["slug"],
            "logo_path" => $inputs["logo_path"],
        ]);

        return to_route("admin.product.brand.index")->with("swal-success", "برند جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view("admin.product.brand.edit", compact("brand"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Brand $brand)
    {
        $inputs = $request->validated();

        if ($request->hasFile("logo_path")) {
            if (File::exists($brand->logo_path)) {
                File::delete($brand->logo_path);
            }

            $inputs["logo_path"] = $request->file("logo_path");
            $imageName = time() . '.' . $inputs["logo_path"]->extension();
            $imagePath = public_path('images' . DIRECTORY_SEPARATOR . "brand" . DIRECTORY_SEPARATOR . $imageName);
            Image::make($inputs["logo_path"]->getRealPath())->save($imagePath);
            $inputs["logo_path"] = 'images' . DIRECTORY_SEPARATOR . "brand" . DIRECTORY_SEPARATOR . $imageName;
        } else {
            $inputs["logo_path"] = $brand->logo_path;
        }

        $inputs["slug"] = str_replace(" ", "-", $inputs["persian_name"]);

        $brand->update([
            "original_name" => $inputs["original_name"],
            "persian_name" => $inputs["persian_name"],
            "description" => $inputs["description"],
            "slug" => $inputs["slug"],
            "logo_path" => $inputs["logo_path"],
        ]);

        return to_route("admin.product.brand.index")->with("swal-success", "برند مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        DB::transaction(function () use ($brand) {
            $brand->update([
                "original_name" => $brand->original_name . "-" . $brand->id,
                "persian_name" => $brand->persian_name . "-" . $brand->id,
                "slug" => $brand->slug . "-" . $brand->id,
            ]);

            $brand->delete();
        });

        return back()->with("swal-success", "برند مورد نظر با موفقیت حذف شد");
    }
}
