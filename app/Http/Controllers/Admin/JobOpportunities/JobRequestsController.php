<?php

namespace App\Http\Controllers\Admin\JobOpportunities;

use App\Models\JobRequest;
use Illuminate\Http\Request;
use App\Models\JobOpportunity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class JobRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(JobOpportunity $job)
    {
        $search = request()->search;
        $sort = request()->sort;
        $column = request()->column;

        if (!in_array($sort, ["ASC", "DESC"]) || !in_array($column, ["seen_status", "approval_status"])) {
            $sort = "ASC";
            $column = "created_at";
        }

        $jobRequests = $job->requests()->when($search, function ($query) use ($search) {
            return $query->where("description", "like", "%$search%")->orWhereHas("user", function ($query) use ($search) {
                $query->where("name", "like", "%$search%")->orWhere("email", "like", "%$search%");
            })->orWhereHas("opportunity", function ($query) use ($search) {
                $query->where("title", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            });
        })->with("user", "opportunity")->orderBy($column, $sort)->get()->where("job_opportunity_id", $job->id);

        return view("admin.job-opportunities.job-requests.index", compact("job", "jobRequests"));
    }

    /**
     * Display the specified resource.
     */
    public function show(JobOpportunity $job, JobRequest $request)
    {
        return view("admin.job-opportunities.job-requests.show", compact("job", "request"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOpportunity $job, JobRequest $request)
    {
        if (File::exists(public_path($request->file_path))) {
            File::delete(public_path($request->file_path));
        }

        $request->delete();

        return back()->with("swal-success", "درخواست مورد نظر با موفقیت حذف شد");
    }

    // Changes the seen status of a job request between viewed and unviewed.
    public function changeSeenStatus(JobOpportunity $job, JobRequest $request)
    {
        // Toggle the seen status between viewed and unviewed.
        $newStatus = $request->seen_status === "unviewed" ? "viewed" : "unviewed";

        // Update the job request's seen status.
        $request->update([
            "seen_status" => $newStatus
        ]);

        // Prepare success message based on the new status.
        $message = "وضعیت دیده شدن درخواست مورد نظر با موفقیت به ";
        $message .= $newStatus === "viewed" ? "(دیده شده) تغییر کرد." : "(دیده نشده) تغییر کرد.";

        // Redirect back with a success message.
        return back()->with("swal-success", $message);
    }

    // Changes the approval status of a job request between pending, approved, and rejected.
    public function changeApprovalStatus(JobOpportunity $job, JobRequest $request)
    {
        $approval_status = '';

        // Determine the new approval status based on the current status.
        switch ($request->approval_status) {
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

        // Update the job request's approval status.
        $request->update([
            "approval_status" => $approval_status,
        ]);

        // Redirect back with a success message.
        return back()->with("swal-success", "وضعیت تایید درخواست مورد نظر با موفقیت به ($request->approval) تغییر یافت");
    }
}
