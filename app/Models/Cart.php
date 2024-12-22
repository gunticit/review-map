<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, UserStamp;

    protected $table = 'carts';
    protected $guarded = [];
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'cart_product', 'cart_id', 'product_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function cartProducts(){
        return $this->hasMany(CartProduct::class);
    }
}

