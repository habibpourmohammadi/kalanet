<?php

namespace App\Http\Controllers\Home\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Home\Account\StoreAddressRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Home\Account\UpdateProfileRequest;
use App\Models\Address;
use App\Models\Bookmark;
use App\Models\City;

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

    public function myAddresses()
    {
        $addresses = Auth::user()->addresses;
        $cities = City::where("status", "active")->get();
        return view("home.account.myAddresses", compact("addresses", "cities"));
    }

    public function storeMyAddress(StoreAddressRequest $request)
    {
        $inputs = $request->validated();

        if ($request->receiver == "true") {
            if ($inputs["recipient_first_name"] == null || $inputs["recipient_last_name"] == null || $inputs["recipient_mobile"] == null) {
                return back()->with("error", "اطلاعات گیرنده را وارد نمایید");
            }
        }

        $city = City::find($inputs["city_id"]);

        if ($city == null) {
            return back();
        }

        Address::create([
            "user_id" => Auth::user()->id,
            "province_id" => $city->province->id,
            "city_id" => $city->id,
            "address" => $inputs["address"],
            "postal_code" => $inputs["postal_code"],
            "mobile" => $inputs["mobile"],
            "no" => $inputs["no"],
            "unit" => $inputs["unit"],
            "recipient_first_name" => $inputs["recipient_first_name"],
            "recipient_last_name" => $inputs["recipient_last_name"],
            "recipient_mobile" => $inputs["recipient_mobile"],
        ]);

        return back()->with("success", "آدرس جدید شما با موفقیت ثبت شد");
    }

    public function editmyAddresses(Address $address)
    {
        if ($address->user->id != Auth::user()->id) {
            abort(404);
        }

        $cities = City::where("status", "active")->get();
        return view("home.account.myAddressEdit", compact("address", "cities"));
    }

    public function updateMyAddress(StoreAddressRequest $request, Address $address)
    {
        if ($address->user->id != Auth::user()->id) {
            abort(404);
        }


        $inputs = $request->validated();

        if ($request->receiver == "true") {
            if ($inputs["recipient_first_name"] == null || $inputs["recipient_last_name"] == null || $inputs["recipient_mobile"] == null) {
                return back()->with("error", "اطلاعات گیرنده را وارد نمایید");
            }
        }

        $city = City::find($inputs["city_id"]);

        if ($city == null) {
            return back();
        }

        $address->update([
            "province_id" => $city->province->id,
            "city_id" => $city->id,
            "address" => $inputs["address"],
            "postal_code" => $inputs["postal_code"],
            "mobile" => $inputs["mobile"],
            "no" => $inputs["no"],
            "unit" => $inputs["unit"],
            "recipient_first_name" => $inputs["recipient_first_name"],
            "recipient_last_name" => $inputs["recipient_last_name"],
            "recipient_mobile" => $inputs["recipient_mobile"],
        ]);

        return to_route("home.profile.myAddresses.index")->with("success", "آدرس مورد نظر با موفقیت ویرایش شد");
    }

    // My Orders - Index page
    public function myOrders()
    {
        $sort = request()->sort;
        $column = "payment_status";


        switch ($sort) {
            case '1':
                $sort = "paid";
                break;

            case '2':
                $sort = "unpaid";
                break;

            case '3':
                $sort = "returned";
                break;

            case '4':
                $sort = "canceled";
                break;

            default:
                $sort = Auth::user()->id;
                $column = "user_id";
                break;
        }

        $orders = Auth::user()->orders()->where($column, $sort)->get();
        return view("home.account.myOrders", compact("orders"));
    }
}
