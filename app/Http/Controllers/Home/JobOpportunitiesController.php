<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Models\JobOpportunity;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Home\JobOpportunities\SubmitJobRequest;
use App\Models\JobRequest;
use Illuminate\Support\Facades\Auth;

class JobOpportunitiesController extends Controller
{
    private $path = 'file' . DIRECTORY_SEPARATOR . "job-requests" . DIRECTORY_SEPARATOR;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobOpportunities = JobOpportunity::where("status", "active")->get();
        return view("home.job-opportunities.index", compact("jobOpportunities"));
    }

    /**
     * Display the specified resource.
     */
    public function show(JobOpportunity $job)
    {
        return view("home.job-opportunities.show", compact("job"));
    }

    // Submits a job request for a specific job opportunity
    public function submitJobRequest(SubmitJobRequest $request, JobOpportunity $job)
    {
        // Check if the user has already submitted a request for this job opportunity
        if ($job->requests()->where("user_id", Auth::user()->id)->exists())
            return back()->with("swal-error", "درخواست همکاری شما قبلا ثبت شده است!");

        // Process the uploaded file
        if ($request->hasFile("file_path")) {
            $file = $request->file("file_path");
            // Generate a unique file name based on the current time
            $fileName = time() . '.' . $file->extension();
            // Define the file path
            $filePath = public_path($this->path . $fileName);
            $file_path = $this->path . $fileName;

            // Move the file to the specified directory
            if ($file->extension() == "pdf") {
                $file->move(public_path($this->path), $fileName);
            } else {
                // If it's not a PDF file, convert it to an image (assuming it's an image)
                Image::make($file->getRealPath())->save($filePath);
            }
        } else {
            return back()->with("swal-error", "مشکلی پیش آمده ، لطفا دوباره تلاش کنید");
        }

        // Create a new job request
        JobRequest::create([
            "user_id" => Auth::user()->id,
            "job_opportunity_id" => $job->id,
            "description" => $request->description,
            "file_path" => $file_path,
        ]);

        // Redirect back with success message
        return back()->with("swal-success", "درخواست همکاری شما با موفقیت ثبت شد ، به زودی همکاران ما با شما تماس خواهند گرفت");
    }
}
