<?php

namespace App\Models;

use App\Models\User;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Guarantee;
use App\Models\ProductImage;
use App\Models\ProductOption;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $guarded = ["id"];

    protected $table = "products";

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function seller()
    {
        return $this->belongsTo(User::class, "seller_id");
    }

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, "brand_id");
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class)->withPivot("price");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function guarantees()
    {
        return $this->belongsToMany(Guarantee::class)->withPivot("price");
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
