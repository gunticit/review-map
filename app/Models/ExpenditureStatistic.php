<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenditureStatistic extends Model
{
    protected $table = 'expenditure_statistics';
    public $timestamps = true;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
