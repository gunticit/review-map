<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class Company extends Model
{
    use HasFactory, UserStamp;
    protected $table = 'companies';
    protected $guarded = [];
    public $timestamps = true;
}
