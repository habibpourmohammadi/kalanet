<?php

namespace App\Http\Controllers\Home\Account;

use App\Models\City;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Address;
use App\Models\Bookmark;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\TicketMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Home\Account\StoreTicketRequest;
use App\Http\Requests\Home\Account\StoreAddressRequest;
use App\Http\Requests\Admin\Ticket\StoreMessagesRequest;
use App\Http\Requests\Home\Account\UpdateProfileRequest;

class AccountController extends Controller
{

    private $path = 'ticket' . DIRECTORY_SEPARATOR . "files" . DIRECTORY_SEPARATOR;

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
        $provinces = Province::where("status", "active")->get();
        return view("home.account.myAddresses", compact("addresses", "provinces"));
    }

    public function getCities(Province $province)
    {
        $cities = City::where('province_id', $province->id)->where("status", "active")->pluck('name', 'id');
        return response()->json($cities);
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

        $provinces = Province::where("status", "active")->get();
        return view("home.account.myAddressEdit", compact("address", "provinces"));
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

    public function showMyOrder(Order $order)
    {
        if (Auth::user()->id != $order->user_id) {
            abort(404);
        }

        return view("home.account.showMyOrder", compact("order"));
    }

    // my tickets

    public function myTickets()
    {
        $tickets = Auth::user()->tickets;
        return view("home.account.myTickets", compact("tickets"));
    }

    public function storeTicket(StoreTicketRequest $request)
    {
        $inputs = $request->validated();
        $priorities = ["low", "medium", "important", "very_important"];

        if (!in_array($inputs["priority_status"], $priorities)) {
            return back();
        }

        if (Auth::user()->name == null) {
            return to_route("home.profile.myProfile.index")->with("error", "لطفا نام خود را وارد نمایید");
        }

        $ticket_id = rand(10000000, 99999999);

        Ticket::create([
            "user_id" => Auth::user()->id,
            "ticket_id" => $ticket_id,
            "title" => $inputs["title"],
            "priority_status" => $inputs["priority_status"],
        ]);

        return to_route("home.profile.myTickets.messages.index", $ticket_id)->with("success", "تیکت شما با موفقیت ثبت شد. گفت و گوی خود را با ادمین وبسایت آغاز کنید");
    }

    public function myTicketMessages(Ticket $ticket)
    {
        if ($ticket->user->id != Auth::user()->id) {
            return back();
        }

        return view("home.account.myTicketMessages", compact("ticket"));
    }


    public function myTicketMessagesStore(StoreMessagesRequest $request, Ticket $ticket)
    {
        $inputs = $request->validated();

        if ($ticket->status == "closed") {
            return back()->with("error", "تیکت مورد نظر بسته است");
        }

        if ($request->hasFile("file_path")) {
            $file = $request->file("file_path");
            $file_size = $file->getSize();
            $file_type = $file->extension();
            $file_name = time() . '.' . $file_type;

            $inputs["file_path"] = $this->path . $file_name;
            if ($file_type == "xlsx" || $file_type == "xls" || $file_type == "docx" || $file_type == "doc" || $file_type == "pdf") {
                $file->move(public_path($this->path), $file_name);
            } elseif ($file_type == "png" || $file_type == "jpg" || $file_type == "jpeg") {
                Image::make($file->getRealPath())->save(public_path($this->path) . $file_name);
            }
        } else {
            $inputs["file_path"] = null;
        }

        TicketMessage::create([
            "ticket_id" => $ticket->id,
            "user_id" => Auth::user()->id,
            "message" => $inputs["message"],
            "file_path" => $inputs["file_path"],
        ]);

        return back()->with("success", "پیام شما با موفقیت ثبت شد");
    }
}
