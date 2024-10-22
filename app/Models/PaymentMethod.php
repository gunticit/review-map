<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class PaymentMethod extends Model
{
    use HasFactory, UserStamp;

    protected $table = 'payment_methods';
    protected $guarded = [];
}
