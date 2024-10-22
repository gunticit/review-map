<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class Comment extends Model
{
    use HasFactory, UserStamp;
    protected $table='comments';
    protected $guarded = [];
}
