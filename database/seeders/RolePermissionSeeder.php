<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['edit articles', 'delete articles', 'publish articles'];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Tạo vai trò và gán quyền
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'customer', 'guard_name' => 'web']);
        Role::create(['name' => 'guest', 'guard_name' => 'web']);
    }
}
