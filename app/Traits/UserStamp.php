<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait UserStamp
{
    /**
     * Boot the userstamps trait for a model.
     *
     * @return void
     */
    public static function bootUserStamp()
    {
        static::creating(function (Model $model) {
            $authId = Auth::id() ?? 0;
            $model->created_by = $authId;
            $model->created_at = dateNow();
        });

        static::updating(function (Model $model) {
            $authId = Auth::id() ?? 0;
            $model->updated_by = $authId;
            $model->updated_at = dateNow();
        });

        static::deleting(function (Model $model) {
            $authId = Auth::id() ?? 0;
            $model->deleted_by = $authId;
            $model->deleted_at = dateNow();
            $model->save();
        });
    }


    /**
     * Get the user that created the model.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that edited the model.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user that deleted the model.
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
