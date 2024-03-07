<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Admin\Product\Image\StoreRequest;

class ImageProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $this->authorize('update', [$product]);

        return view("admin.product.image.index", compact("product"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        $this->authorize('update', [$product]);

        return view("admin.product.image.create", compact("product"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, Product $product)
    {
        $this->authorize('update', [$product]);

        if ($request->hasFile("image_path")) {
            $image = $request->file("image_path");
            $imageName = time() . '.' . $image->extension();
            $imagePath = public_path('images' . DIRECTORY_SEPARATOR . "product" . DIRECTORY_SEPARATOR . $imageName);
            Image::make($image->getRealPath())->save($imagePath);
            $image_path = 'images' . DIRECTORY_SEPARATOR . "product" . DIRECTORY_SEPARATOR . $imageName;
        } else {
            return to_route("admin.product.image.index", $product)->with("swal-error", "مشکلی پیش آمده ، لطفا دوباره تلاش کنید");
        }

        ProductImage::create([
            "image_path" => $image_path,
            "product_id" => $product->id,
        ]);

        return to_route("admin.product.image.index", $product)->with("swal-success", "عکس محصول مورد نظر با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, ProductImage $image)
    {
        $this->authorize('update', [$product]);

        return view("admin.product.image.edit", compact("product", "image"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Product $product, ProductImage $image)
    {
        $this->authorize('update', [$product]);

        if ($request->hasFile("image_path")) {
            if (File::exists(public_path($image->image_path))) {
                File::delete(public_path($image->image_path));
            }
            $imageFile = $request->file("image_path");
            $imageName = time() . '.' . $imageFile->extension();
            $imagePath = public_path('images' . DIRECTORY_SEPARATOR . "product" . DIRECTORY_SEPARATOR . $imageName);
            Image::make($imageFile->getRealPath())->save($imagePath);
            $image_path = 'images' . DIRECTORY_SEPARATOR . "product" . DIRECTORY_SEPARATOR . $imageName;
        } else {
            return to_route("admin.product.image.index", $product)->with("swal-error", "مشکلی پیش آمده ، لطفا دوباره تلاش کنید");
        }

        $image->update([
            "image_path" => $image_path,
        ]);

        return to_route("admin.product.image.index", $product)->with("swal-success", "عکس محصول مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductImage $image)
    {
        $this->authorize('update', [$product]);

        if (File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }

        $image->delete();

        return to_route("admin.product.image.index", $product)->with("swal-success", "عکس محصول مورد نظر با موفقیت حذف شد");
    }
}
