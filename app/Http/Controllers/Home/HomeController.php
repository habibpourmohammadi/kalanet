<?php

namespace App\Http\Controllers\Home;

use App\Models\Brand;
use App\Models\Banner;
use App\Models\Slider;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // sliders
        $sliders = Slider::where("status", "true")->get();

        // banners
        $topLeftBanners = Banner::where("banner_position", "topLeft")->where("status", "true")->get();
        $middleBanners = Banner::where("banner_position", "middle")->where("status", "true")->get();
        $bottomBanner = Banner::where("banner_position", "bottom")->where("status", "true")->first();

        // products
        $bestSellingProducts = Product::where("status", "true")->orderBy("sold_number", "DESC")->take(11)->with("images", "colors")->get();
        $recommendedProducts = Product::take(11)->with("images", "colors")->get();

        // brands
        $brands = Brand::all();

        return view("home.index", compact("sliders", "topLeftBanners", "bestSellingProducts", "middleBanners", "recommendedProducts", "bottomBanner", "brands"));
    }

    public function addToBookmark(Product $product)
    {
        $bookmark = Auth::user()->bookmarks->where("product_id", $product->id)->first();
        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['success' => true, "message" => "محصول از لیست علاقه مندی های شما حذف شد", "status" => "deleted"]);
        } else {
            Bookmark::create([
                "product_id" => $product->id,
                "user_id" => Auth::user()->id,
            ]);
            return response()->json(['success' => true, "message" => "محصول با موفقیت به لیست علاقه مندی شما اضافه شد", "status" => "added"]);
        }
    }
}
