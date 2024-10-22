<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use App\Traits\UserStamp;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes, UserStamp;

    protected $table="order_items";
    public $timestamps = true;
    protected $guarded = [];
}
