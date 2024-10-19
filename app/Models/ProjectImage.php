<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use HasFactory, UserStamp;
    protected $table = 'image_projects';
    protected $guarded = [];
    public $timestamps = true;

    public function project(){
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function mission(){
        return $this->hasOne(Mission::class, 'image_id', 'id');
    }
}
