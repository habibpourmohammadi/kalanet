<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    protected $table = "categories";

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    public function getChildrenIds($category = null, &$ids = [])
    {
        if (is_null($category)) {
            $category = $this;
        }

        foreach ($category->children as $children) {
            $ids[] = $children->id;
            $this->getChildrenIds($children, $ids);
        }

        return $ids;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
