<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class History extends Model
{
    use HasFactory, UserStamp;

    protected $table = "histories";
    protected $guarded = [];
    public $timestamps = true;

}
