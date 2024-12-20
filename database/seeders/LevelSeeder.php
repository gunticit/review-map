<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Level::insert([
            ['name' => 'Cấp 1', 'time_limit' => 12, 'required_tasks' => 0, 'reward' => 10000],
            ['name' => 'Cấp 2', 'time_limit' => 6, 'required_tasks' => 5, 'reward' => 11000],
            ['name' => 'Cấp 3', 'time_limit' => 3, 'required_tasks' => 10, 'reward' => 12000],
            ['name' => 'Cấp 4', 'time_limit' => 2, 'required_tasks' => 50, 'reward' => 13000],
            ['name' => 'Cấp 5', 'time_limit' => 1, 'required_tasks' => 100, 'reward' => 14000],
        ]);
    }
}
