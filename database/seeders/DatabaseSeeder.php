<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\NotificationSeeder;
use Database\Seeders\FaqsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserTableSeeder::class,
            TagSeeder::class,
            NotificationSeeder::class,
            DepartmentSeeder::class,
            FaqsSeeder::class
        ]);
    }
}
