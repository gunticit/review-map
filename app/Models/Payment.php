<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class Payment extends Model
{
    use HasFactory, UserStamp;

    protected $table = 'payments';
    public $timestamps = true;
    public $guarded = [];
}
