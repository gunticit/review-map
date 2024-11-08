<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, UserStamp, SoftDeletes;

    protected $table = 'faqs';
    protected $guarded = [];
    public $timestamps = true;

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
