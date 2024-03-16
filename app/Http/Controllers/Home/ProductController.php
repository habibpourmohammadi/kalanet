<?php

namespace App\Http\Controllers\Home;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Home\Product\AddToCartRequest;
use App\Http\Requests\Home\Product\CreateCommentRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Home\Product\SubmitCommentRequest;
use App\Models\CartItem;
use App\Models\GeneralDiscount;

class ProductController extends Controller
{
    // show product
    public function show(Product $product)
    {
        if ($product->status == "false") {
            abort(404);
        }
        if ($product->images->first() == null) {
            abort(404);
        }
        $categoryProducts = $product->category->products()->whereNotIn('id', [$product->id])->where('status', 'true')->has("images")->get();
        $generalDiscount = GeneralDiscount::where("start_date", "<", now())->where("end_date", ">", now())->where("status", "active")->get()->last();
        return view("home.show-product", compact("product", "categoryProducts", "generalDiscount"));
    }

    // submit comment answer
    public function submitComment(SubmitCommentRequest $request, Product $product)
    {
        $inputs = $request->validated();
        $comment = $product->comments()->where("id", $inputs["parent_id"])->first();

        if ($comment == null) {
            return back()->with("swal-error", "لطفا دوباره تلاش کنید");
        } elseif (Auth::user()->name == null) {
            return to_route("home.profile.myProfile.index")->with("swal-error", "لطفا نام و نام خانوادگی خود را وارد کنید");
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
            return to_route("home.profile.myProfile.index")->with("swal-error", "لطفا نام و نام خانوادگی خود را وارد کنید");
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
    public function addToCart(AddToCartRequest $request, Product $product)
    {
        $inputs = $request->validated();

        if ($product->marketable_number <= 0 || $product->marketable != 'true') {
            return back()->with("swal-error", "محصول مورد نظر شما موجود نیست");
        } elseif ($inputs["number"] > $product->marketable_number) {
            return back()->with("swal-error", "متاسفانه فقط " . $product->marketable_number . " عدد از این محصول موجود است");
        } elseif ($product->status != "true") {
            return to_route("home.product.show", $product);
        }

        $productGuarantees = $product->guarantees();
        $productColors = $product->colors();

        $color = null;
        $guarantee = null;

        if ($productGuarantees->count() > 0) {
            if (!isset($inputs["guarantee_id"])) {
                return back()->with("swal-error", "انتخاب کردن گارانتی برای محصول الزامی است");
            } elseif ($productGuarantees->where("id", $inputs["guarantee_id"])->first() == null) {
                return back()->with("swal-error", "گارانتی انتخابی شما برای محصول مورد نظر یافت نشد");
            } else {
                $guarantee = $productGuarantees->where("id", $inputs["guarantee_id"])->first();
            }
        }

        if ($productColors->count() > 0) {
            if (!isset($inputs["color_id"])) {
                return back()->with("swal-error", "انتخاب کردن رنگ برای محصول الزامی است");
            } elseif ($productColors->where("id", $inputs["color_id"])->first() == null) {
                return back()->with("swal-error", "رنگ انتخابی شما برای محصول مورد نظر یافت نشد");
            } else {
                $color = $productColors->where("id", $inputs["color_id"])->first();
            }
        }

        if ($color == null) {
            $inputs["color_id"] = null;
        }

        if ($guarantee == null) {
            $inputs["guarantee_id"] = null;
        }

        $cartItem = CartItem::where('user_id', Auth::user()->id)->where('product_id', $product->id)->where("color_id", $inputs["color_id"])->where("guarantee_id", $inputs["guarantee_id"])->first();


        if ($cartItem == null) {
            CartItem::create([
                "user_id" => Auth::user()->id,
                "product_id" => $product->id,
                "color_id" => $inputs["color_id"],
                "guarantee_id" => $inputs["guarantee_id"],
                "number" => $inputs["number"],
            ]);

            return back()->with("swal-success", "محصول مورد نظر با موفقیت به سبد خرید شما اضافه شد");
        } else {
            $cartItem->update([
                "number" => ($cartItem->number + $inputs["number"])
            ]);

            return back()->with("swal-success", "تعداد محصول مورد نظر در سبد خرید شما ویرایش شد");
        }
    }

    // delete order from customer cart
    public function deleteFromCart(CartItem $cartItem)
    {
        if (Auth::user()->id == $cartItem->user->id) {
            $cartItem->delete();
            return back()->with("swal-success", "محصول مورد نظر با موفقیت از سبد خرید شما حذف شد!");
        } else {
            return back();
        }
    }
}
