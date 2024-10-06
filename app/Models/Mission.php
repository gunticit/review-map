<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;
    
    protected $table = 'missions';
    protected $guarded = [];
    public $timestamps = true;
    const STATUS_SUCCESS = 1;
    const STATUS_WORKING = 2;

    public function comments(){
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }
    public function project(){
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
