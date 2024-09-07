<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'status', 'user_id'];

    // Định nghĩa relationship với model User
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}