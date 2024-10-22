<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use App\Traits\UserStamp;

class Order extends Model
{
    use HasFactory, SoftDeletes, UserStamp;

    protected $table="orders";
    public $timestamps = true;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price')->withTimestamps();
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
