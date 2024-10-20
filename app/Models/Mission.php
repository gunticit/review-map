<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserStamp;

class Mission extends Model
{
    use HasFactory, UserStamp;
    
    protected $table = 'missions';
    protected $guarded = [];
    public $timestamps = true;
    const STATUS_SUCCESS = 1; // Đã hoàn thành 
    const STATUS_WORKING = 2; // Đang thực hiện
    const STATUS_WATTING_SYSTEM = 3; // Chờ hệ thống duyệt
    const STATUS_WATTING_ADMIN = 4; // Chờ admin duyệt
    const STATUS_DENY = 5; // Đã từ chối
    const STATUS_EXPIRED = 6; // Đã hết hạn

    public function comments(){
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function images(){
        return $this->belongsTo(ProjectImage::class, 'image_id', 'id');
    }
}
