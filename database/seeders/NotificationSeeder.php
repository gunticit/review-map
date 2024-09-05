<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();


        for ($i = 4; $i <= 50; $i++) {
            Notification::create([
                'title' => $faker->sentence,
                'content' => $faker->paragraph,
                'status' => $faker->randomElement([1, 2]),
                'user_id' => 2, 
            ]);
        }
    }
}
