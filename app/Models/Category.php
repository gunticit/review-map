<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, UserStamp;

    protected $table = 'categories';
    public $timestamps = true;
    protected $guarded = [];
    
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }


}
