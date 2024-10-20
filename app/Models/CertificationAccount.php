<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class CertificationAccount extends Model
{
    use HasFactory,UserStamp;

    protected $table = 'certification_accounts';
    protected $guarded = [];
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
