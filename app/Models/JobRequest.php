<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    protected $table = "job_requests";

    public function opportunity()
    {
        return $this->belongsTo(JobOpportunity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
