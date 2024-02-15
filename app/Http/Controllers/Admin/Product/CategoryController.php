<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\Category\StoreRequest;
use App\Http\Requests\Admin\Product\Category\UpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;
        $sort = request()->sort;

        if ($sort == null) {
            $sort = "ASC";
        }

        $categories = Category::query()->when($search, function ($categories) use ($search, $sort) {
            return $categories->where("name", "like", "%$search%")->orWhere("description", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhereHas("parent", function ($categories) use ($search) {
                $categories->where("name", "like", "%$search%");
            })->with("parent")->orderBy("parent_id", $sort)->get();
        }, function ($categories) use ($sort) {
            return $categories->orderBy("parent_id", $sort)->get();
        });

        return view("admin.product.category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("admin.product.category.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated();

        $inputs["slug"] = str_replace(" ", "-", $inputs["name"]);


        Category::create([
            "name" => $inputs["name"],
            "parent_id" => $inputs["parent_id"],
            "slug" => $inputs["slug"],
            "description" => $inputs["description"],
        ]);

        return to_route("admin.product.category.index")->with("swal-success", "دسته بندی جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $unauthorized_ids = [$category->id];

        $unauthorized_ids = array_merge($unauthorized_ids, $category->getChildrenIds());

        $categories = Category::whereNotIn('id', $unauthorized_ids)->get();
        return view("admin.product.category.edit", compact("categories", 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $inputs = $request->validated();

        $unauthorized_ids = [$category->id];
        $unauthorized_ids = array_merge($unauthorized_ids, $category->getChildrenIds());

        if (in_array($inputs["parent_id"], $unauthorized_ids)) {
            return to_route("admin.product.category.index")->with("swal-error", "لطفا دوباره تلاش کنید");
        }

        $inputs["slug"] = str_replace(" ", "-", $inputs["name"]);

        $category->update([
            "name" => $inputs["name"],
            "parent_id" => $inputs["parent_id"],
            "slug" => $inputs["slug"],
            "description" => $inputs["description"],
        ]);

        return to_route("admin.product.category.index")->with("swal-success", "دسته بندی مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::transaction(function () use ($category) {
            $category->update([
                "name" => $category->name . "-" . $category->id,
                "slug" => $category->slug . "-" . $category->id,
            ]);

            $category->delete();
        });

        return back()->with("swal-success", "دسته بندی مورد نظر با موفقیت حذف شد");
    }
}
