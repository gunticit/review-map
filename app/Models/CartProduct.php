<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory, UserStamp;

    protected $table = 'cart_product';
    protected $guarded = [];
    public $timestamps = true;

    public function products(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
