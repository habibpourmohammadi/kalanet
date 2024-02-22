<?php

namespace App\Http\Controllers\Admin\Appearance;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Admin\Appearance\Slider\StoreRequest;
use App\Http\Requests\Admin\Appearance\Slider\UpdateRequest;

class SliderController extends Controller
{

    private $path = 'images' . DIRECTORY_SEPARATOR . "appearance" . DIRECTORY_SEPARATOR . "slider" . DIRECTORY_SEPARATOR;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $sliders = Slider::query()->when($search, function ($sliders) use ($search) {
            return $sliders->where("title", "like", "%$search%")->orWhere("slider_size", "like", "%$search%")->orWhere("slider_type", "like", "%$search%")->get();
        }, function ($sliders) use ($search) {
            return $sliders->get();
        });

        return view("admin.appearance.slider.index", compact("sliders"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.appearance.slider.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated();

        if ($request->hasFile("slider_path")) {
            $slider = $request->file("slider_path");
            $slider_size = $slider->getSize();
            $slider_type = $slider->extension();
            $slider_name = time() . '.' . $slider_type;

            $inputs["slider_path"] = $this->path . $slider_name;
            if ($slider_type == "gif") {
                $slider->move(public_path($this->path), $slider_name);
            } else {
                Image::make($slider->getRealPath())->save(public_path($this->path) . $slider_name);
            }
        } else {
            return to_route("admin.appearance.slider.index")->with("swal-error", "لطفا دوباره تلاش کنید");
        }

        Slider::create([
            "title" => $inputs["title"],
            "slider_path" => $inputs["slider_path"],
            "slider_size" => $slider_size,
            "slider_type" => $slider_type,
        ]);

        return to_route("admin.appearance.slider.index")->with("swal-success", "اسلایدر جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view("admin.appearance.slider.edit", compact("slider"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Slider $slider)
    {
        $inputs = $request->validated();

        if ($request->hasFile("slider_path")) {
            if (File::exists(public_path($slider->slider_path)))
                File::delete(public_path($slider->slider_path));

            $sliderFile = $request->file("slider_path");
            $slider_size = $sliderFile->getSize();
            $slider_type = $sliderFile->extension();
            $slider_name = time() . '.' . $slider_type;

            $inputs["slider_path"] = $this->path . $slider_name;
            if ($slider_type == "gif") {
                $sliderFile->move(public_path($this->path), $slider_name);
            } else {
                Image::make($sliderFile->getRealPath())->save(public_path($this->path) . $slider_name);
            }
        } else {
            $inputs["slider_path"] = $slider->slider_path;
            $slider_size = $slider->slider_size;
            $slider_type = $slider->slider_type;
        }

        $slider->update([
            "title" => $inputs["title"],
            "slider_path" => $inputs["slider_path"],
            "slider_size" => $slider_size,
            "slider_type" => $slider_type,
        ]);

        return to_route("admin.appearance.slider.index")->with("swal-success", "اسلایدر مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if (File::exists(public_path($slider->slider_path))) {
            File::delete(public_path($slider->slider_path));
        }

        $slider->delete();

        return to_route("admin.appearance.slider.index")->with("swal-success", "اسلایدر مورد نظر با موفقیت حذف شد");
    }

    public function changeStatus(Slider $slider)
    {
        if ($slider->status == 'false') {
            $slider->update([
                "status" => "true"
            ]);

            return to_route("admin.appearance.slider.index")->with("swal-success", "وضعیت اسلایدر مورد نظر با موفقیت به (فعال) تغییر یافت");
        } else {
            $slider->update([
                "status" => "false"
            ]);

            return to_route("admin.appearance.slider.index")->with("swal-success", "وضعیت اسلایدر مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        }
    }
}
