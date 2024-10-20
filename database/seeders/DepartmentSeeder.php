<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Phòng chăm sóc đối tác',
            ],
            [
                'name' => 'Phòng kế toán',
            ]
        ];
        DB::table('departments')->insert($data);
    }
}
