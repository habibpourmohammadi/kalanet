<?php

namespace App\Http\Controllers\Home;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Home\Product\CreateCommentRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Home\Product\SubmitCommentRequest;

class ProductController extends Controller
{
    // show product
    public function show(Product $product)
    {
        if ($product->status == "false")
            abort(404);
        $categoryProducts = $product->category->products()->whereNotIn('id', [$product->id])->where('status', 'true')->has("images")->get();
        return view("home.show-product", compact("product", "categoryProducts"));
    }

    // submit comment answer
    public function submitComment(SubmitCommentRequest $request, Product $product)
    {
        $inputs = $request->validated();
        $comment = $product->comments()->where("id", $inputs["parent_id"])->first();

        if ($comment == null) {
            return back()->with("error", "لطفا دوباره تلاش کنید");
        } elseif (Auth::user()->name == null) {
            return to_route("home.profile.myProfile.index")->with("error", "لطفا نام و نام خانوادگی خود را وارد کنید");
        }

        Comment::create([
            "parent_id" => $comment->id,
            "product_id" => $product->id,
            "user_id" => Auth::user()->id,
            "comment" => $inputs["comment"],
        ]);

        return back()->with("success", "پاسخ شما با موفقیت ثبت شد ، پس از تایید ادمین نمایش داده می شود");
    }

    // create comment for product
    public function createComment(CreateCommentRequest $request, Product $product)
    {
        $inputs = $request->validated();

        if (Auth::user()->name == null) {
            return to_route("home.profile.myProfile.index")->with("error", "لطفا نام و نام خانوادگی خود را وارد کنید");
        }

        Comment::create([
            "parent_id" => null,
            "product_id" => $product->id,
            "user_id" => Auth::user()->id,
            "comment" => $inputs["comment"],
        ]);

        return back()->with("success", "دیدگاه شما با موفقیت ثبت شد ، پس از تایید ادمین نمایش داده می شود");
    }

    // add order in customer cart
    public function addToCart(Request $request, Product $product)
    {
        dd($product, $request->all());
    }
}
