<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    use HasFactory;

    protected $table = 'support_messages';

    protected $guarded = [];

    public function support(){
        return $this->belongsTo(Support::class, 'support_id');
    }

    public function sender(){
        return $this->belongsTo(User::class, 'send_id');
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'receive_id');
    }
}
