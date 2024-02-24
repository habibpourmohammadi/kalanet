<?php

namespace App\Http\Controllers\Home\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Home\Account\UpdateProfileRequest;
use App\Models\Bookmark;

class AccountController extends Controller
{
    public function myProfile()
    {
        return view("home.account.myProfile");
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        Auth::user()->update([
            "name" => $request->name
        ]);

        return back()->with("success", "نام شما با موفقیت ویرایش شد");
    }


    public function myBookmarks()
    {
        $bookmarks = Auth::user()->bookmarks;
        return view("home.account.myBookmarks", compact("bookmarks"));
    }

    public function removeBookmark(Bookmark $bookmark)
    {
        $bookmark->delete();

        return back()->with("success", "محصول مورد نظر با موفقیت از لیست علاقه مندی های شما حذف شد");
    }
}
