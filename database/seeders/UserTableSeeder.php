<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'admin',
                'role_id' => 1,
                'permission_id' => 1,
                'email' => 'admin@gmail.com',
                'telephone' => '0909123123',
                'password' => bcrypt('123123123123'),
            ],
            [
                'name' => 'customer',
                'role_id' => 2,
                'permission_id' => 2,
                'email' => 'customer@gmail.com',
                'telephone' => '0909123124',
                'password' => bcrypt('123123123123'),
            ],
            [
                'name' => 'guest',
                'role_id' => 3,
                'permission_id' => 3,
                'email' => 'guest@gmail.com',
                'telephone' => '0909123125',
                'password' => bcrypt('123123123123'),
            ],
        ];
        DB::table('users')->insert($data);
    }
}
