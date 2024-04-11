<?php

namespace App\Http\Controllers\Admin\JobOpportunities;

use Illuminate\Http\Request;
use App\Models\JobOpportunity;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Admin\JobOpportunities\StoreRequest;
use App\Http\Requests\Admin\JobOpportunities\UpdateRequest;

class JobOpportunitiesController extends Controller
{
    private $path = "images" . DIRECTORY_SEPARATOR . "job-opportunities" . DIRECTORY_SEPARATOR;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', JobOpportunity::class);

        $search = request()->search;

        $jobOpportunities = JobOpportunity::query()->when($search, function ($query) use ($search) {
            return $query->where("title", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhere("description", "like", "%$search%");
        })->with("requests")->get();

        return view("admin.job-opportunities.index", compact("jobOpportunities"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', JobOpportunity::class);

        return view("admin.job-opportunities.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', JobOpportunity::class);

        // Process the uploaded image
        $image_path = null;
        if ($request->hasFile("image_path")) {
            $image = $request->file("image_path");
            // Generate a unique file name based on the current time
            $imageName = time() . '.' . $image->extension();
            // Define the image path
            $imagePath = public_path($this->path . $imageName);
            $image_path = $this->path . $imageName;
            // Save the image
            Image::make($image->getRealPath())->save($imagePath);
        }

        // Create the job opportunity
        JobOpportunity::create([
            "title" => $request->title,
            "description" => $request->description,
            "image_path" => $image_path,
        ]);

        // Redirect to the job opportunities index page with a success message
        return to_route("admin.job-opportunities.index")->with("swal-success", "فرصت شغلی جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOpportunity $job)
    {
        $this->authorize('update', [$job]);

        return view("admin.job-opportunities.edit", compact("job"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, JobOpportunity $job)
    {
        $this->authorize('update', [$job]);

        // Process the uploaded image
        $image_path = $job->image_path;
        if ($request->hasFile("image_path")) {
            // Delete the previous image if it exists
            if ($job->image_path != null && File::exists(public_path($job->image_path))) {
                File::delete(public_path($job->image_path));
            }

            // Save the new image
            $image = $request->file("image_path");
            // Generate a unique file name based on the current time
            $imageName = time() . '.' . $image->extension();
            // Define the image path
            $imagePath = public_path($this->path . $imageName);
            $image_path = $this->path . $imageName;

            // Save the image
            Image::make($image->getRealPath())->save($imagePath);
        }

        // Update the job opportunity
        $job->update([
            "title" => $request->title,
            "description" => $request->description,
            "image_path" => $image_path,
        ]);

        // Redirect to the job opportunities index page with a success message
        return to_route("admin.job-opportunities.index")->with("swal-success", "فرصت شغلی مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOpportunity $job)
    {
        $this->authorize('delete', [$job]);

        // Delete the associated image if it exists
        if ($job->image_path != null && File::exists(public_path($job->image_path)))
            File::delete(public_path($job->image_path));

        // Use a transaction to update the title and delete the job opportunity
        DB::transaction(function () use ($job) {
            // Update the title by appending the current timestamp to make it unique
            $job->update([
                "title" => $job->title . ' ' . time(),
            ]);

            // Delete the job opportunity
            $job->delete();
        });

        // Redirect back with a success message
        return back()->with("swal-success", "فرصت شغلی مورد نظر با موفقیت حذف شد");
    }

    // Changes the status of a job opportunity between active and inactive
    public function changeStatus(JobOpportunity $job)
    {
        $this->authorize('changeStatus', [$job]);

        // Toggle the status between active and inactive
        $newStatus = $job->status === "inactive" ? "active" : "inactive";

        // Update the job opportunity's status
        $job->update([
            "status" => $newStatus
        ]);

        // Prepare success message based on the new status
        $message = "وضعیت فرصت شغلی مورد نظر با موفقیت به ";
        $message .= $newStatus === "active" ? "(فعال) تغییر کرد." : "(غیر فعال) تغییر کرد.";

        // Redirect back with a success message
        return back()->with("swal-success", $message);
    }
}
