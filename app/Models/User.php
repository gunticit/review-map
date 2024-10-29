<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UserStamp;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, UserStamp;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'telephone',
        'role_id',
        'permission_id',
        'password',
        'avatar',
        'country_code',
        'company_id',
        'google_id',
        'usercode'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public $timestamps = true;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function transactionHistories(){
        return $this->hasMany(TransactionHistory::class);
    }

    public function certificationAccount() {
        return $this->hasOne(CertificationAccount::class, 'user_id', 'id');
    }

    public function wallet() {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function missions(){
        return $this->hasMany(Mission::class, 'user_id', 'id');
    }

    public function accountPayment() {
        return $this->hasOne(AccountPayment::class, 'user_id', 'id');
    }
}
