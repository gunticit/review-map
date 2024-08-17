<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasRoles{

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }  

        return !! $role->intersect($this->roles)->count();
    }

    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }

        return !! $permission->intersect($this->permissions)->count();
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission);
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
        }

        return $this->roles()->save($role);
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
        }

        return $this->roles()->detach($role);
    }

    public function assignPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstOrFail();
        }

        return $this->permissions()->save($permission);
    }

    public function removePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstOrFail();
        }

        return $this->permissions()->detach($permission);
    }

}