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

    public function children(){
        return $this->hasMany(SupportMessage::class, 'parent_id', 'id');
    }
}
