<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, UserStamp;

    protected $table = 'tags';
    protected $guarded = [];
    public $timestamps = true;
}
