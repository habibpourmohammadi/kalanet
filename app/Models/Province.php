<?php

namespace App\Models;

use App\Models\City;
use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    protected $table = "provinces";

    public function cities()
    {
        return $this->hasMany(City::class);
    }


    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
