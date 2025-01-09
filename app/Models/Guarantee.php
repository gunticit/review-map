<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Guarantee extends Model
{
    use Notifiable, HasFactory, HasRoles, UserStamp;

    protected $table = 'guarantees';
    protected $guarded = [];
    public $timestamps = true;
}
