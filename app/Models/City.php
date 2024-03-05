<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    protected $table = "cities";

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
