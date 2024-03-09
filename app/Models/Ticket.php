<?php

namespace App\Models;

use App\Models\User;
use App\Models\TicketMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    protected $table = "tickets";

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPriorityAttribute()
    {
        switch ($this->priority_status) {
            case 'low':
                return "کم";
                break;
            case 'medium':
                return "متوسط";
                break;
            case 'important':
                return "مهم";
                break;
            case 'very_important':
                return "خیلی مهم";
                break;
            default:
                return "";
                break;
        }
    }
}
