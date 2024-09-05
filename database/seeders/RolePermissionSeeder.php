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
        $permissions = [
            [
                'name' => 'edit articles',
                'guard_name' => 'web'
            ], 
            [
                'name' => 'delete articles',
                'guard_name' => 'web'
            ],
            [
                'name' => 'publish articles',
                'guard_name' => 'web'
            ]
        ];
        Permission::upsert($permissions, ['name', 'guard_name']);

        // Tạo vai trò và gán quyền

        $roles = [
            ['name' => Role::ADMIN_ROLE, 'guard_name' => 'web'],
            ['name' => Role::CUSTOMER_ROLE, 'guard_name' => 'web'],
            ['name' => Role::GUEST_ROLE, 'guard_name' => 'web'],
        ];
        Role::upsert($roles, ['name', 'guard_name']);
    }
}
