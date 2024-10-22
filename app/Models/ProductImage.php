<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class ProductImage extends Model
{
    use HasFactory, UserStamp;

    protected $table="product_images";
    public $timestamps = true;
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
