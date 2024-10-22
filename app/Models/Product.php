<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserStamp;

class Product extends Model
{
    use HasFactory, SoftDeletes, UserStamp;

    protected $guarded = [];

    public $timestamps = true;
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function images(){
        return $this->hasMany(ProductImage::class);
    }
    public function created_by(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function promotions(){
        return $this->hasMany(Promotion::class);
    }
    public function orders(){
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')->withPivot('quantity', 'price');
    }

    public function carts() {
        return $this->belongsToMany(Cart::class, 'cart_product', 'product_id', 'cart_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
