<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionHistory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'transaction_histories';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
