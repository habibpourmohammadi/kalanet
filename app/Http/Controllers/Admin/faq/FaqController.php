<?php

namespace App\Http\Controllers\Admin\faq;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faq\StoreRequest;
use App\Http\Requests\Admin\Faq\UpdateRequest;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("viewAny", Faq::class);

        $search = request()->search;

        $faqItems = Faq::query()->when($search, function ($query) use ($search) {
            return $query->where("question", "like", "%$search%")->orWhere("answer", "like", "%$search%");
        })->get();

        return view("admin.faq.index", compact("faqItems"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize("create", Faq::class);

        return view("admin.faq.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize("create", Faq::class);

        Faq::create([
            "question" => $request->question,
            "answer" => $request->answer,
        ]);

        return to_route("admin.faq.index")->with("swal-success", "سوال متداول جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        $this->authorize("view", [$faq]);

        return view("admin.faq.show", compact("faq"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $this->authorize("update", [$faq]);

        return view("admin.faq.edit", compact("faq"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Faq $faq)
    {
        $this->authorize("update", [$faq]);

        $faq->update([
            "question" => $request->question,
            "answer" => $request->answer,
        ]);

        return to_route("admin.faq.index")->with("swal-success", "سوال متداول مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $this->authorize("delete", [$faq]);

        DB::transaction(function () use ($faq) {
            $faq->update([
                "question" => $faq->question . " " . time()
            ]);

            $faq->delete();
        });

        return back()->with("swal-success", "سوال متداول مورد نظر با موفقیت حذف شد");
    }

    // change status
    public function changeStatus(Faq $faq)
    {
        $this->authorize("changeStatus", [$faq]);

        if ($faq->status == "inactive") {
            $faq->update([
                "status" => "active"
            ]);
            return back()->with("swal-success", "وضعیت سوال متداول مورد نظر با موفقیت به (فعال) تغییر یافت");
        } else {
            $faq->update([
                "status" => "inactive"
            ]);
            return back()->with("swal-success", "وضعیت سوال متداول مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        }
    }
}
