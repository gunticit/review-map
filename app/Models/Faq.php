<?php

namespace App\Models;

use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory, UserStamp;

    protected $table = 'faqs';
    protected $guarded = [];
    public $timestamps = true;
}
