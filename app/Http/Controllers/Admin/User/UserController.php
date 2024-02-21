<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;
        $users = User::query()->when($search, function ($users) use ($search) {
            return $users->where("name", "like", "%$search%")->orWhere("email", "like", "%$search%")->orWhere("created_at", "like", "%$search%")->get();
        }, function ($users) {
            return $users->get();
        });
        return view("admin.user.user.index", compact("users"));
    }

    public function changeStatus(User $user)
    {
        if ($user->activation == "deactive") {
            $user->update([
                "activation" => "active"
            ]);

            return back()->with("swal-success", "وضعیت کاربر مورد نظر با موفقیت به (فعال) تغییر یافت");
        } else {
            $user->update([
                "activation" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت کاربر مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        }
    }
}
