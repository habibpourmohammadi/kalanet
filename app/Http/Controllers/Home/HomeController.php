<?php

namespace App\Http\Controllers\Home;

use App\Models\Brand;
use App\Models\Banner;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Bookmark;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\GeneralDiscount;
use App\Http\Controllers\Controller;
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
        $bestSellingProducts = Product::where("status", "true")->has("images")->orderBy("sold_number", "DESC")->take(11)->with("images", "colors")->get();
        $recommendedProducts = Product::where("status", "true")->has("images")->take(11)->with("images", "colors")->get();

        // brands
        $brands = Brand::where("logo_path", '!=', null)->get();

        $generalDiscount = GeneralDiscount::where("start_date", "<", now())->where("end_date", ">", now())->where("status", "active")->get()->last();

        return view("home.index", compact("sliders", "topLeftBanners", "bestSellingProducts", "middleBanners", "recommendedProducts", "bottomBanner", "brands", "generalDiscount"));
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

    // Search
    public function search(Request $request, Category $category = null)
    {
        $generalDiscount = GeneralDiscount::where("start_date", "<", now())->where("end_date", ">", now())->where("status", "active")->get()->last();
        $brands = Brand::all();

        if ($category) {
            $categoryFilter = $category;
            $productModel = $category->products();
        } else {
            $categoryFilter = null;
            $productModel = new Product();
        }

        $categories = Category::whereNull("parent_id")->get();

        switch ($request->sort) {
            case '1':
                $colum = "created_at";
                $dirication = "DESC";
                break;
            case '2':
                $colum = "price";
                $dirication = "DESC";
                break;
            case '3':
                $colum = "price";
                $dirication = "ASC";
                break;
            case '4':
                $colum = "sold_number";
                $dirication = "DESC";
                break;

            default:
                $colum = "created_at";
                $dirication = "ASC";
        }

        if ($request->search) {
            $query = $productModel->where('name', "LIKE", "%" . $request->search . "%")->orderBy($colum, $dirication);
        } else {
            $query =  $productModel->orderBy($colum, $dirication);
        }

        $products = $request->max_price && $request->min_price ? $query->whereBetween("price", [$request->min_price, $request->max_price]) : $query->when($request->min_price, function ($query) use ($request) {
            $query->where('price', ">=", $request->min_price)->get();
        })->when($request->max_price, function ($query) use ($request) {
            $query->where('price', "<=", $request->max_price)->get();
        })->when(!($request->max_price && $request->min_price), function ($query) {
            $query->get();
        });
        $products = $products->when($request->brands, function () use ($request, $products) {
            $products->WhereHas("brand", function ($query) use ($request) {
                $query->whereIn("persian_name", $request->brands);
            })->with("brand");
        });

        $products = $products->has("images")->paginate(15);
        $products->appends($request->query());
        return view("home.search", compact("categories", "brands", "products", "categoryFilter", "generalDiscount"));
    }
}
