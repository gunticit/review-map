<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class Support extends Model
{
    use HasFactory, UserStamp;
    protected $table = 'supports';
    protected $guarded = [];
    public $timestamps = true;

    const COMPLETE_SUPPORT = 1; // Đã xử lý
    const INCOMPLETE_SUPPORT = 2; // Chưa xử lý
    const PROCESSING_SUPPORT = 3; // Đang xử lý
    const CLOSE_SUPPORT = 4; // Đóng
    
    static public function generateSupportCode(){
        return 'SPC_'.time().rand(1000,9999);
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }
}
