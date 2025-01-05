<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class Message extends Model
{
    use HasFactory, UserStamp;
    protected $guarded = [];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receive_id');
    }
    public function sender(){
        return $this->belongsTo(User::class, 'send_id');
    }
}
