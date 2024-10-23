<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserStamp;
class TransactionHistory extends Model
{
    use HasFactory, SoftDeletes, UserStamp;

    protected $table = 'transaction_histories';
    protected $guarded = [];
    public $timestamps = true;

    // public function user() {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }

    public function user()
    {
        return $this->hasOneThrough(User::class, Wallet::class, 'id', 'id', 'wallet_id', 'user_id');
    }

    public function wallet() {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    public function paymentMethod() {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
