<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

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
}
