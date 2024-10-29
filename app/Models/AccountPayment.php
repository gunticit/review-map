<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPayment extends Model
{
    use HasFactory;
    protected $table = 'account_payments';
    protected $fillable = [
        'user_id',
        'account_name',
        'payment_method',
        'account_number',
        'bank_name',
        'phone_number',
    ];
}
