<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use Notifiable, HasRoles, UserStamp;

    protected $table = 'levels';
    protected $guards = [];
    public $timestamp = true;
}
