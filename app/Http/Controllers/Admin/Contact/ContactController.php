<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', ContactMessage::class);

        $search = request()->search;
        $sort = request()->sort;
        $column = "seen";

        if (!in_array($sort, ["ASC", "DESC"])) {
            $sort = "ASC";
            $column = "created_at";
        }

        $contactMessages = ContactMessage::query()->when($search, function ($query) use ($search) {
            return $query->where("title", "like", "%$search%")->orWhere("message", "like", "%$search%")->orWhereHas("user", function ($query) use ($search) {
                $query->where("name", "like", "%$search%");
            });
        })->with("user")->orderBy($column, $sort)->get();

        return view("admin.contact-us.index", compact("contactMessages"));
    }


    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $contactMessage)
    {
        $this->authorize('view', [$contactMessage]);

        return view("admin.contact-us.show", compact("contactMessage"));
    }

    // change status
    public function changeStatus(ContactMessage $contactMessage)
    {
        $this->authorize('changeStatus', [$contactMessage]);

        if ($contactMessage->seen == "false") {
            $contactMessage->update([
                "seen" => "true"
            ]);
            return back()->with("swal-success", "وضعیت پیام مورد نظر با موفقیت به (دیده شده) تغییر یافت");
        } else {
            $contactMessage->update([
                "seen" => "false"
            ]);
            return back()->with("swal-success", "وضعیت پیام مورد نظر با موفقیت به (دیده نشده) تغییر یافت");
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $this->authorize('delete', [$contactMessage]);

        $contactMessage->delete();

        return back()->with("swal-success", "پیام مورد نظر با موفقیت حذف شد");
    }
}
