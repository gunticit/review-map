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
                'name' => 'Phòng kinh doanh',
            ],
            [
                'name' => 'Phòng kế toán',
            ],
            [
                'name' => 'Phòng kỹ thuật',
            ]
        ];
        DB::table('departments')->insert($data);
    }
}
