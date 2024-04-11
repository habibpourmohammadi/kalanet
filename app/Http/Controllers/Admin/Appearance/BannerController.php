<?php

namespace App\Http\Controllers\Admin\Appearance;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Admin\Appearance\Banner\StoreRequest;
use App\Http\Requests\Admin\Appearance\Banner\UpdateRequest;

class BannerController extends Controller
{

    private $path = 'images' . DIRECTORY_SEPARATOR . "appearance" . DIRECTORY_SEPARATOR . "banner" . DIRECTORY_SEPARATOR;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Banner::class);

        $search = request()->search;

        $banners = Banner::query()->when($search, function ($banners) use ($search) {
            return $banners->where("title", "like", "%$search%")->orWhere("banner_size", "like", "%$search%")->orWhere("banner_type", "like", "%$search%")->get();
        }, function ($banners) {
            return $banners->get();
        });

        return view("admin.appearance.banner.index", compact("banners"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Banner::class);

        return view("admin.appearance.banner.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Banner::class);

        $inputs = $request->validated();

        switch ($inputs["banner_position"]) {
            case '1':
                $inputs["banner_position"] = "topLeft";
                break;

            case '2':
                $inputs["banner_position"] = "middle";
                break;

            case '3':
                $inputs["banner_position"] = "bottom";
                break;

            default:
                return back()->with("swal-error", "لطفا دوباره تلاش کنید");
                break;
        }

        $positionCount = Banner::where("banner_position", $inputs["banner_position"])->count();

        if ($inputs["banner_position"] == "topLeft") {
            if ($positionCount == 2)
                return back()->with("swal-error", "شما بیشتر از 2 بنر را در موقعیت (بالا سمت چپ) نمیتوانید بزارید");
        } elseif ($inputs["banner_position"] == "middle") {
            if ($positionCount == 2)
                return back()->with("swal-error", "شما بیشتر از 2 بنر را در موقعیت (وسط) نمیتوانید بزارید");
        } elseif ($inputs["banner_position"] == "bottom") {
            if ($positionCount == 1)
                return back()->with("swal-error", "شما بیشتر از 1 بنر را در موقعیت (پایین) نمیتوانید بزارید");
        }

        if ($request->hasFile("banner_path")) {
            $banner = $request->file("banner_path");
            $banner_size = $banner->getSize();
            $banner_type = $banner->extension();
            $banner_name = time() . '.' . $banner_type;

            $inputs["banner_path"] = $this->path . $banner_name;
            if ($banner_type == "gif") {
                $banner->move(public_path($this->path), $banner_name);
            } else {
                Image::make($banner->getRealPath())->save(public_path($this->path) . $banner_name);
            }
        } else {
            return back()->with("swal-error", "لطفا دوباره تلاش کنید");
        }

        Banner::create([
            "title" => $inputs["title"],
            "banner_path" => $inputs["banner_path"],
            "banner_size" => $banner_size,
            "banner_type" => $banner_type,
            "banner_position" => $inputs["banner_position"],
            "url" => $inputs["url"],
        ]);

        return to_route("admin.appearance.banner.index")->with("swal-success", "بنر جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $this->authorize('update', [$banner]);

        return view("admin.appearance.banner.edit", compact("banner"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Banner $banner)
    {
        $this->authorize('update', [$banner]);

        $inputs = $request->validated();

        switch ($inputs["banner_position"]) {
            case '1':
                $inputs["banner_position"] = "topLeft";
                break;

            case '2':
                $inputs["banner_position"] = "middle";
                break;

            case '3':
                $inputs["banner_position"] = "bottom";
                break;

            default:
                return back()->with("swal-error", "لطفا دوباره تلاش کنید");
                break;
        }

        $positionCount = Banner::where("banner_position", $inputs["banner_position"])->whereNotIn("id", [$banner->id])->count();

        if ($inputs["banner_position"] == "topLeft") {
            if ($positionCount == 2)
                return back()->with("swal-error", "شما بیشتر از 2 بنر را در موقعیت (بالا سمت چپ) نمیتوانید بزارید");
        } elseif ($inputs["banner_position"] == "middle") {
            if ($positionCount == 2)
                return back()->with("swal-error", "شما بیشتر از 2 بنر را در موقعیت (وسط) نمیتوانید بزارید");
        } elseif ($inputs["banner_position"] == "bottom") {
            if ($positionCount == 1)
                return back()->with("swal-error", "شما بیشتر از 1 بنر را در موقعیت (پایین) نمیتوانید بزارید");
        }

        if ($request->hasFile("banner_path")) {
            $bannerFile = $request->file("banner_path");
            $banner_size = $bannerFile->getSize();
            $banner_type = $bannerFile->extension();
            $banner_name = time() . '.' . $banner_type;

            $inputs["banner_path"] = $this->path . $banner_name;
            if ($banner_type == "gif") {
                $bannerFile->move(public_path($this->path), $banner_name);
            } else {
                Image::make($bannerFile->getRealPath())->save(public_path($this->path) . $banner_name);
            }
        } else {
            $banner_size = $banner->banner_size;
            $banner_type = $banner->banner_type;
            $inputs["banner_path"] = $banner->banner_path;
        }

        $banner->update([
            "title" => $inputs["title"],
            "banner_path" => $inputs["banner_path"],
            "banner_size" => $banner_size,
            "banner_type" => $banner_type,
            "banner_position" => $inputs["banner_position"],
            "url" => $inputs["url"],
        ]);

        return to_route("admin.appearance.banner.index")->with("swal-success", "بنر مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $this->authorize('delete', [$banner]);

        if (File::exists(public_path($banner->banner_path)))
            File::delete(public_path($banner->banner_path));

        $banner->delete();

        return back()->with("swal-success", "بنر مورد نظر با موفقیت حذف شد");
    }

    public function changeStatus(Banner $banner)
    {
        $this->authorize('update', [$banner]);

        if ($banner->status == 'false') {
            $banner->update([
                "status" => "true"
            ]);

            return back()->with("swal-success", "وضعیت بنر مورد نظر با موفقیت به (فعال) تغییر یافت");
        } else {
            $banner->update([
                "status" => "false"
            ]);

            return back()->with("swal-success", "وضعیت بنر مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        }
    }
}
