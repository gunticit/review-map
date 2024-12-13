<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\UserStamp;
use Spatie\Permission\Traits\HasRoles;

class Level extends Model
{
    use Notifiable, HasRoles, UserStamp;

    protected $table = 'levels';
    protected $guards = [];
    public $timestamp = true;
}
