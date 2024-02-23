<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    public function position()
    {
        switch ($this->banner_position) {
            case 'topLeft':
                return "بالا سمت چپ";
                break;

            case 'middle':
                return "وسط";
                break;

            case 'bottom':
                return "پایین";
                break;

            default:
                return false;
                break;
        }
    }
}
