<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CensorshipHistory extends Model
{
    use HasFactory, UserStamp, SoftDeletes;
    protected $table='censorship_history';
    protected $guarded = [];
    public $timestamps = true;

    public function missions(){
        return $this->belongsTo(Mission::class);
    }

    public function partner(){
        return $this->belongsTo(User::class);
    }

    public function approver(){
        return $this->belongsTo(User::class);
    }

}
