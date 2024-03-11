<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailNotification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "email_notifications";

    protected $guarded = ["id"];


    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
