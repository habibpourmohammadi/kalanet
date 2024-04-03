<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Home\ContactUs\StoreRequest;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("home.contact-us.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        ContactMessage::create([
            "user_id" => Auth::user()->id,
            "title" => $request->title,
            "message" => $request->message,
        ]);

        return to_route("home.index")->with("swal-success", "پیام شما با موفقیت ثبت شد ✔");
    }
}
