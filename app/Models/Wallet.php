<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory, UserStamp;

    protected $table = 'wallets';
    protected $fillable = ['user_id', 'balance', 'currency'];
    // protected $guarded = [];
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactionHistories() {
        return $this->hasMany(TransactionHistory::class, 'wallet_id', 'id');
    }
}
