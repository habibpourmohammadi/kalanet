<?php

namespace App\Http\Controllers\Admin\Notifications;

use Illuminate\Http\Request;
use App\Models\EmailNotification;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailNotifications;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Notification\Email\StoreRequest;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $emailNotifications = EmailNotification::query()->when($search, function ($emailNotifications) use ($search) {
            return $emailNotifications->where("title", "like", "%$search%")->orWhere("description", "like", "%$search%")->orWhereHas("author", function ($users) use ($search) {
                $users->where("name", "like", "%$search%")->orWhere("email", "like", "%$search%");
            })->with("author")->get();
        }, function ($emailNotifications) {
            return $emailNotifications->with("author")->get();
        });

        return view("admin.notifications.email.index", compact("emailNotifications"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.notifications.email.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        EmailNotification::create([
            "title" => $request->title,
            "description" => $request->description,
            "author_id" => Auth::user()->id
        ]);

        return to_route("admin.notification.email.index")->with("swal-success", "اطلاعیه ایمیلی جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailNotification $email)
    {
        return view("admin.notifications.email.show", compact("email"));
    }

    public function send(EmailNotification $email)
    {
        dispatch(new SendEmailNotifications($email));

        return back()->with("swal-success", "اطلاعیه ایمیلی مورد نظر با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailNotification $email)
    {
        return view("admin.notifications.email.edit", compact("email"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, EmailNotification $email)
    {
        $email->update([
            "title" => $request->title,
            "description" => $request->description,
        ]);

        return to_route("admin.notification.email.index")->with("swal-success", "اطلاعیه ایمیلی مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailNotification $email)
    {
        $email->delete();

        return back()->with("swal-success", "اطلاعیه ایمیلی مورد نظر با موفقیت حذف شد");
    }
}
