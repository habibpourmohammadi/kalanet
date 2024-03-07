<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $this->authorize('update', [$product]);

        $search = request()->search;

        $sort = request()->sort;
        $column = "";

        switch (request()->column) {
            case '1':
                $column = "status";
                break;
            case '2':
                $column = "seen";
                break;

            default:
                $sort = "ASC";
                $column = "created_at";
                break;
        }

        $columns = ["1", "2"];

        if (!in_array(request()->column, $columns) || $sort == null || $column == null) {
            $sort = "ASC";
            $column = "created_at";
        }

        $comments = $product->comments()->when($search, function ($comments) use ($search, $sort, $column) {
            return $comments->where("comment", "like", "%$search%")->orWhereHas("author", function ($users) use ($search) {
                $users->where("name", "like", "%$search%")->orWhere("email", "like", "%$search%");
            })->orWhereHas("product", function ($products) use ($search) {
                $products->where("name", "like", "%$search%");
            })->with("author", "product")->orderBy($column, $sort)->get();
        }, function ($comments) use ($sort, $column) {
            return $comments->orderBy($column, $sort)->get();
        });

        return view("admin.product.comment.index", compact("comments", "product"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, Comment $comment)
    {
        $this->authorize('update', [$product]);

        return view("admin.product.comment.show", compact("product", "comment"));
    }


    public function changeStatus(Product $product, Comment $comment)
    {
        $this->authorize('update', [$product]);

        if ($comment->status == "false") {
            $comment->update([
                "status" => "true"
            ]);
            return back()->with("swal-success", "وضعیت کامنت مورد نظر با موفقیت به (تایید شده) تغییر کرد");
        } else {
            $comment->update([
                "status" => "false"
            ]);
            return back()->with("swal-success", "وضعیت کامنت مورد نظر با موفقیت به (تایید نشده) تغییر کرد");
        }
    }


    public function changeSeenStatus(Product $product, Comment $comment)
    {
        $this->authorize('update', [$product]);

        if ($comment->seen == "false") {
            $comment->update([
                "seen" => "true"
            ]);
            return back()->with("swal-success", "وضعیت کامنت مورد نظر با موفقیت به (دیده شده) تغییر کرد");
        } else {
            $comment->update([
                "seen" => "false"
            ]);
            return back()->with("swal-success", "وضعیت کامنت مورد نظر با موفقیت به (دیده نشده) تغییر کرد");
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Comment $comment)
    {
        $this->authorize('update', [$product]);

        $comment->delete();
        return back()->with("swal-success", "کامنت مورد نظر با موفقیت حذف شد");
    }
}
