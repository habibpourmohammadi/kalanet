<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\Product\StoreRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $sort = request()->sort;
        $column = "";

        switch (request()->column) {
            case '1':
                $column = "price";
                break;
            case '2':
                $column = "brand_id";
                break;
            case '3':
                $column = "category_id";
                break;
            case '4':
                $column = "sold_number";
                break;
            case '5':
                $column = "marketable_number";
                break;

            default:
                $sort = "ASC";
                $column = "created_at";
                break;
        }

        $columns = ["1", "2", "3", "4", "5"];

        if (!in_array(request()->column, $columns) || $sort == null || $column == null) {
            $sort = "ASC";
            $column = "created_at";
        }


        $products = Product::query()->when($search, function ($products) use ($search, $column, $sort) {
            return $products->where("name", "like", "%$search%")->orWhere("description", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhere("price", "like", "%$search%")->orWhere("sold_number", "like", "%$search%")->orWhere("marketable_number", "like", "%$search%")->orWhereHas("category", function ($categories) use ($search) {
                $categories->where("name", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            })->orWhereHas("brand", function ($brands) use ($search) {
                $brands->where("original_name", "like", "%$search%")->orWhere("persian_name", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            })->orWhereHas("seller", function ($sellers) use ($search) {
                $sellers->where("name", "like", "%$search%")->orWhere("email", "like", "%$search%");
            })->with(["seller", "brand", "category"])->orderBy($column, $sort)->get();
        }, function ($products) use ($column, $sort) {
            return $products->orderBy($column, $sort)->get();
        });

        return view("admin.product.product.index", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view("admin.product.product.create", compact("categories", "brands"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated();

        if ($request->hasFile("Introduction_video_path")) {
            $file = $request->file("Introduction_video_path");
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = DIRECTORY_SEPARATOR . "video" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR;
            $file->move(public_path($filePath), $fileName);
            $inputs["Introduction_video_path"] = "video" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $fileName;
        } else {
            $inputs["Introduction_video_path"] = null;
        }

        $inputs["seller_id"] = Auth::user()->id;

        Product::create([
            "category_id" => $inputs["category_id"],
            "brand_id" => $inputs["brand_id"],
            "seller_id" => $inputs["seller_id"],
            "name" => $inputs["name"],
            "description" => $inputs["description"],
            "Introduction_video_path" => $inputs["Introduction_video_path"],
            "price" => $inputs["price"],
            "marketable_number" => $inputs["marketable_number"],
        ]);

        return to_route("admin.product.index")->with("swal-success", "محصول جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view("admin.product.product.show", compact("product"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view("admin.product.product.edit", compact("product", "categories", "brands"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Product $product)
    {
        $inputs = $request->validated();

        if ($request->hasFile("Introduction_video_path")) {
            if (File::exists(public_path($product->Introduction_video_path))) {
                File::delete(public_path($product->Introduction_video_path));
            }

            $file = $request->file("Introduction_video_path");
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = DIRECTORY_SEPARATOR . "video" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR;
            $file->move(public_path($filePath), $fileName);
            $inputs["Introduction_video_path"] = "video" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $fileName;
        } else {
            $inputs["Introduction_video_path"] = $product->Introduction_video_path;
        }

        $product->update([
            "category_id" => $inputs["category_id"],
            "brand_id" => $inputs["brand_id"],
            "name" => $inputs["name"],
            "description" => $inputs["description"],
            "Introduction_video_path" => $inputs["Introduction_video_path"],
            "price" => $inputs["price"],
            "marketable_number" => $inputs["marketable_number"],
        ]);

        return to_route("admin.product.index")->with("swal-success", "محصول مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {

            if (File::exists(public_path($product->Introduction_video_path))) {
                File::delete(public_path($product->Introduction_video_path));
            }

            $product->update([
                "slug" => $product->slug . '-' . time(),
                "name" => $product->name . ' ' . time(),
            ]);

            $product->delete();
        });
        return to_route("admin.product.index")->with("swal-success", "محصول مورد نظر با موفقیت حذف شد");
    }

    public function changeStatus(Product $product)
    {
        if ($product->status == "false") {
            $product->update([
                "status" => "true"
            ]);

            return back()->with("swal-success", "وضعیت محصول مورد نظر با موفقیت به (فعال) تغییر یافت");
        } else {
            $product->update([
                "status" => "false"
            ]);

            return back()->with("swal-success", "وضعیت محصول مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        }
    }

    public function changeSaleStatus(Product $product)
    {
        if ($product->marketable == "false") {
            $product->update([
                "marketable" => "true"
            ]);

            return back()->with("swal-success", "وضعیت فروش محصول مورد نظر با موفقیت به (مجاز) تغییر یافت");
        } else {
            $product->update([
                "marketable" => "false"
            ]);

            return back()->with("swal-success", "وضعیت فروش محصول مورد نظر با موفقیت به (غیر مجاز) تغییر یافت");
        }
    }
}
