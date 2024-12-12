<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, UserStamp;

    protected $table = 'settings';

    protected $fillable = [
        'code_setting',
        'key_setting',
        'value_setting',
    ];
}
