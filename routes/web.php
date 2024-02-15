<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Product\BrandController;
use App\Http\Controllers\Admin\Product\CategoryController;
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
    });
});
