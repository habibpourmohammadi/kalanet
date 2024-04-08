<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Home\BecomeSeller\StoreRequest;
use App\Models\SellerRequest;
use Illuminate\Support\Facades\Auth;

class BecomeSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("home.become-seller.index");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        SellerRequest::create([
            "user_id" => Auth::user()->id,
            "description" => $request->description,
        ]);

        return back()->with("swal-success", "درخواست همکاری شما با موفقیت ثبت شد. تیم ما به زودی با شما تماس خواهد گرفت.");
    }
}
