<?php

namespace App\Http\Controllers\Admin\BecomeSeller;

use App\Http\Controllers\Controller;
use App\Models\SellerRequest;
use Illuminate\Http\Request;

class SellerRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', SellerRequest::class);

        $search = request()->search;

        $sort = request()->sort;
        $column = request()->column;

        if (!in_array($sort, ["ASC", "DESC"]) || !in_array($column, ["seen_status", "approval_status"])) {
            $sort = "ASC";
            $column = "created_at";
        }

        $sellerRequests = SellerRequest::query()->when($search, function ($query) use ($search) {
            return $query->where("description", "like", "%$search%")->orWhereHas("user", function ($query) use ($search) {
                $query->where("name", "like", "%$search%");
            });
        })->with("user")->orderBy($column, $sort)->get();

        return view("admin.become-seller.index", compact("sellerRequests"));
    }

    /**
     * Display the specified resource.
     */
    public function show(SellerRequest $seller)
    {
        $this->authorize('view', [$seller]);

        return view("admin.become-seller.show", compact("seller"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SellerRequest $seller)
    {
        $this->authorize('delete', [$seller]);

        $seller->delete();

        return back()->with("swal-success", "پیام مورد نظر با موفقیت حذف شد");
    }

    // change seen status
    public function changeSeenStatus(SellerRequest $seller)
    {
        $this->authorize('changeSeenStatus', [$seller]);

        if ($seller->seen_status == "unviewed") {
            $seller->update([
                "seen_status" => "viewed"
            ]);
            return back()->with("swal-success", "وضعیت دیده شدن پیام مورد نظر با موفقیت به (دیده شده) تغییر یافت");
        } else {
            $seller->update([
                "seen_status" => "unviewed"
            ]);
            return back()->with("swal-success", "وضعیت دیده شدن پیام مورد نظر با موفقیت به (دیده نشده) تغییر یافت");
        }
    }

    // change approval status
    public function changeApprovalStatus(SellerRequest $seller)
    {
        $this->authorize('changeApprovalStatus', [$seller]);

        $approval_status = '';

        switch ($seller->approval_status) {
            case 'pending':
                $approval_status = "approved";
                break;

            case 'approved':
                $approval_status = "rejected";
                break;

            case 'rejected':
                $approval_status = "pending";
                break;

            default:
                $approval_status = "pending";
                break;
        }

        $seller->update([
            "approval_status" => $approval_status,
        ]);

        return back()->with("swal-success", "وضعیت تایید پیام مورد نظر با موفقیت به ($seller->approval) تغییر یافت");
    }
}
