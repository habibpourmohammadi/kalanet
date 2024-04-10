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
        return $this->belongsTo(JobOpportunity::class, "job_opportunity_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getApprovalAttribute()
    {
        switch ($this->approval_status) {
            case 'pending':
                return "در حال انتظار";
                break;

            case 'approved':
                return "تایید شده";
                break;

            case 'rejected':
                return "رد شده";
                break;

            default:
                return "نامعلوم";
                break;
        }
    }
}
