<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    // Define fillable fields
    protected $fillable = [
        'code','name', 'description', 'discount_type', 'discount_value', 'start_date', 'end_date', 'max_uses', 'min_order_value', 'created_by'
    ];

    // Define the relationship with the User model (created_by)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
