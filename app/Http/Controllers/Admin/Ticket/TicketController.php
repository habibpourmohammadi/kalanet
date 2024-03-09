<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Admin\Ticket\StoreMessagesRequest;

class TicketController extends Controller
{
    private $path = 'ticket' . DIRECTORY_SEPARATOR . "files" . DIRECTORY_SEPARATOR;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $sort = request()->sort;
        $column = request()->column;

        switch ($column) {
            case 'status':
                $column = "status";
                break;

            case 'priority_status':
                $column = "priority_status";
                break;

            default:
                $column = "created_at";
                break;
        }

        switch ($sort) {
            case 'ASC':
                $sort = "ASC";
                break;

            case 'DESC':
                $sort = "DESC";
                break;

            default:
                $sort = "ASC";
                break;
        }


        $tickets = Ticket::query()->when($search, function ($tickets) use ($search, $column, $sort) {
            return $tickets->where("ticket_id", "like", "%$search%")->orWhere("title", "like", "%$search%")->orWhereHas("user", function ($users) use ($search) {
                $users->where("name", "like", "%$search%")->orWhere("email", "like", "%$search%");
            })->with("user")->orderBy($column, $sort)->get();
        }, function ($tickets) use ($column, $sort) {
            return $tickets->orderBy($column, $sort)->get();
        });

        return view("admin.ticket.index", compact("tickets"));
    }


    public function messages(Ticket $ticket)
    {
        $unseenMessages = $ticket->messages()->where("seen", "false")->get();

        foreach ($unseenMessages as $message) {
            $message->update([
                "seen" => "true"
            ]);
        }

        return view("admin.ticket.messages", compact("ticket"));
    }


    public function storeMessages(StoreMessagesRequest $request, Ticket $ticket)
    {
        $inputs = $request->validated();

        if ($ticket->status == "closed") {
            return back()->with("swal-error", "تیکت مورد نظر بسته است");
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
            "isAdmin" => "true",
            "seen" => "true",
        ]);

        return back()->with("swal-success", "پیام شما با موفقیت ثبت شده");
    }


    public function changeStatus(Ticket $ticket)
    {
        if ($ticket->status == "closed") {
            $ticket->update([
                "status" => "open"
            ]);

            return back()->with("swal-success", "وضعیت تیکت مورد نظر با موفقیت به (باز) تغییر یافت");
        } else {
            $ticket->update([
                "status" => "closed"
            ]);

            return back()->with("swal-success", "وضعیت تیکت مورد نظر با موفقیت به (بسته) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $messages = $ticket->messages()->whereNotNull("file_path")->get();

        if ($messages->count() != 0) {
            foreach ($messages as $message) {
                if (File::exists(public_path($message->file_path))) {
                    File::delete(public_path($message->file_path));
                }
            }
        }

        $ticket->delete();

        return back()->with("swal-success", "تیکت مورد نظر با موفقیت حذف شد");
    }
}
