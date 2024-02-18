<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Product\BrandController;
use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\ColorController;
use App\Http\Controllers\Admin\Product\CommentController;
use App\Http\Controllers\Admin\Product\GuaranteeController;
use App\Http\Controllers\Admin\Product\OptionProductController;
use App\Http\Controllers\Admin\Product\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix("admin")->group(function () {
    Route::get("/", [AdminController::class, "index"])->name("admin.index");


    Route::prefix("product")->group(function () {

        // Category
        Route::controller(CategoryController::class)->prefix("category")->group(function () {
            Route::get("/", "index")->name("admin.product.category.index");
            Route::get("/create", "create")->name("admin.product.category.create");
            Route::post("/", "store")->name("admin.product.category.store");
            Route::get("/{category}", "edit")->name("admin.product.category.edit");
            Route::put("/{category}", "update")->name("admin.product.category.update");
            Route::delete("/{category}", "destroy")->name("admin.product.category.delete");
        });

        // Brand
        Route::controller(BrandController::class)->prefix("brand")->group(function () {
            Route::get("/", "index")->name("admin.product.brand.index");
            Route::get("/create", "create")->name("admin.product.brand.create");
            Route::post("/", "store")->name("admin.product.brand.store");
            Route::get("/{brand}", "edit")->name("admin.product.brand.edit");
            Route::put("/{brand}", "update")->name("admin.product.brand.update");
            Route::delete("/{brand}", "destroy")->name("admin.product.brand.delete");
        });


        // Color
        Route::controller(ColorController::class)->prefix("color")->group(function () {
            Route::get("/", "index")->name("admin.product.color.index");
            Route::get("/create", "create")->name("admin.product.color.create");
            Route::post("/", "store")->name("admin.product.color.store");
            Route::get("/{color}", "edit")->name("admin.product.color.edit");
            Route::put("/{color}", "update")->name("admin.product.color.update");
            Route::delete("/{color}", "destroy")->name("admin.product.color.delete");
        });

        // Guarantee
        Route::controller(GuaranteeController::class)->prefix("guarantee")->group(function () {
            Route::get("/", "index")->name("admin.product.guarantee.index");
            Route::get("/create", "create")->name("admin.product.guarantee.create");
            Route::post("/", "store")->name("admin.product.guarantee.store");
            Route::get("/{guarantee}", "edit")->name("admin.product.guarantee.edit");
            Route::put("/{guarantee}", "update")->name("admin.product.guarantee.update");
            Route::delete("/{guarantee}", "destroy")->name("admin.product.guarantee.delete");
        });

        // Product
        Route::controller(ProductController::class)->group(function () {
            Route::get("/", "index")->name("admin.product.index");
            Route::get("/create", "create")->name("admin.product.create");
            Route::get("/show/{product}", "show")->name("admin.product.show");
            Route::post("/", "store")->name("admin.product.store");
            Route::get("/{product}", "edit")->name("admin.product.edit");
            Route::put("/{product}", "update")->name("admin.product.update");
            Route::delete("/{product}", "destroy")->name("admin.product.delete");
        });

        // Product comments
        Route::controller(CommentController::class)->prefix("comment")->group(function () {
            Route::get("/{product}", "index")->name("admin.product.comment.index");
            Route::get("/show/{product}/{comment}", "show")->name("admin.product.comment.show")->scopeBindings();
            Route::get("/change-status/{product}/{comment}", "changeStatus")->name("admin.product.comment.changeStatus")->scopeBindings();
            Route::get("/change-seen-status/{product}/{comment}", "changeSeenStatus")->name("admin.product.comment.changeSeenStatus")->scopeBindings();
            Route::delete("/delete/{product}/{comment}", "destroy")->name("admin.product.comment.delete")->scopeBindings();
        });

        // Product options
        Route::controller(OptionProductController::class)->prefix("option")->group(function () {
            Route::get("/{product}", "index")->name("admin.product.option.index");
            Route::get("/create/{product}", "create")->name("admin.product.option.create");
            Route::post("/store/{product}", "store")->name("admin.product.option.store");
            Route::get("/show/{product}/{option}", "show")->name("admin.product.option.show")->scopeBindings();
            Route::get("/edit/{product}/{option}", "edit")->name("admin.product.option.edit")->scopeBindings();
            Route::put("/update/{product}/{option}", "update")->name("admin.product.option.update")->scopeBindings();
            Route::delete("/delete/{product}/{option}", "destroy")->name("admin.product.option.delete")->scopeBindings();
        });
    });
});
