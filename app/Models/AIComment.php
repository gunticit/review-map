<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIComment extends Model
{
    use HasFactory;
    protected $table = 'ai_comments';
    protected $guarded = [];
    public $timestamps = true;
}
