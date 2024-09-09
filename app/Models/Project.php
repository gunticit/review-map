<?php

namespace App\Models;

use App\Traits\UserStamp;
use App\Traits\GeminiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, UserStamp, GeminiTrait;

    protected $table = 'projects';
    protected $guarded = [];
    public $timestamps = true;
    const CANCEL_PROJECT = 0; // Hủy
    const COMPLETED_PROJECT = 1; // Hoàn thành
    const WORKING_PROJECT = 2; // Đang thực hiện
    const RETURN_PROJECT = 3; // Hoàn lại
    const STOPPED_PROJECT = 4; // Tạm ngưng
    const UNPAID = 5; // Chưa thanh toán

    public function generateComments($keywords = array())
    {
        $prompt = "Viết một đoạn mô tả ngắn cho comment sử dụng các từ khóa sau: " . $keywords;
        return $this->generateText($prompt);
    }
}
