<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class Promotion extends Model
{
    use HasFactory, UserStamp;

    protected $table="promotions";
    public $timestamps = true;
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    
}
