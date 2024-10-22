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
                'name' => 'view notifications',
                'guard_name' => 'web'
            ], 
            [
                'name' => 'create notifications',
                'guard_name' => 'web'
            ],
            [
                'name' => 'edit notifications',
                'guard_name' => 'web'
            ],
            [
                'name' => 'delete articles',
                'guard_name' => 'web'
            ],
            //------------ Project -------------
            [
                'name' => 'view projects',
                'guard_name' => 'web'
            ], 
            [
                'name' => 'create projects',
                'guard_name' => 'web'
            ],
            [
                'name' => 'edit projects',
                'guard_name' => 'web'
            ],
            [
                'name' => 'delete projects',
                'guard_name' => 'web'
            ],
            //------------ Wallet (customer: deposit, partner: withdraw) -------------
            [
                'name' => 'view wallet',
                'guard_name' => 'web'
            ], 
            [
                'name' => 'create wallet',
                'guard_name' => 'web'
            ],
            [
                'name' => 'edit wallet',
                'guard_name' => 'web'
            ],
            [
                'name' => 'delete wallet',
                'guard_name' => 'web'
            ],
        ];
        Permission::upsert($permissions, ['name', 'guard_name']);

        // Tạo vai trò và gán quyền

        $roles = [
            ['name' => Role::ADMIN_ROLE, 'guard_name' => 'web'],
            ['name' => Role::CUSTOMER_ROLE, 'guard_name' => 'web'],
            ['name' => Role::PARTNER_ROLE, 'guard_name' => 'web'],
        ];
        Role::upsert($roles, ['name', 'guard_name']);
    }
}
