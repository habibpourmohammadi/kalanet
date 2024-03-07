<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Guarantee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\Guarantee\StoreRequest;
use App\Http\Requests\Admin\Product\Guarantee\UpdateRequest;

class GuaranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Guarantee::class);

        $search = request()->search;

        $guarantees = Guarantee::query()->when($search, function ($guarantees) use ($search) {
            return $guarantees->where("persian_name", "like", "%$search%")->orWhere("original_name", "like", "%$search%")->orWhere("description", "like", "%$search%")->get();
        }, function ($guarantees) {
            return $guarantees->get();
        });

        return view("admin.product.guarantee.index", compact("guarantees"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Guarantee::class);

        return view("admin.product.guarantee.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Guarantee::class);

        $inputs = $request->validated();

        Guarantee::create([
            "persian_name" => $inputs["persian_name"],
            "original_name" => $inputs["original_name"],
            "description" => $inputs["description"],
        ]);

        return to_route("admin.product.guarantee.index")->with("swal-success", "گارانتی جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guarantee $guarantee)
    {
        $this->authorize('update', [$guarantee]);

        return view("admin.product.guarantee.edit", compact("guarantee"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Guarantee $guarantee)
    {
        $this->authorize('update', [$guarantee]);

        $inputs = $request->validated();

        $guarantee->update([
            "persian_name" => $inputs["persian_name"],
            "original_name" => $inputs["original_name"],
            "description" => $inputs["description"],
        ]);

        return to_route("admin.product.guarantee.index")->with("swal-success", "گارانتی مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guarantee $guarantee)
    {
        $this->authorize('delete', [$guarantee]);

        DB::transaction(function () use ($guarantee) {
            $guarantee->update([
                "persian_name" => $guarantee->persian_name . '-' . $guarantee->id,
                "original_name" => $guarantee->original_name . '-' . $guarantee->id,
            ]);

            $guarantee->delete();
        });

        return back()->with("swal-success", "گارانتی مورد نظر با موفقیت حذف شد");
    }
}
