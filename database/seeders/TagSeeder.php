<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Đồ uống ngon',
                'slug' => 'do-uong-ngon',
                'subject_id' => 1, // Bảng này tạo sau, 1: đại diện quán nước
            ],
            [
                'name' => 'Yên tĩnh',
                'slug' => 'yen-tinh',
                'subject_id' => 2 // 2; sở thích tính cách
            ],
            [
                'name' => 'Nhân viên thân thiện',
                'slug' => 'nhan-vien-than-thien',
                'subject_id' => 2 // 2; sở thích tính cách
            ],
            [
                'name' => 'Náo nhiệt',
                'slug' => 'nao-nhiet',
                'subject_id' => 2 // 2; sở thích tính cách
            ],
            [
                'name' => 'Cà phê ngon',
                'slug' => 'ca-phi-ngon',
                'permission_id' => 1 // quán nước
            ],
            [
                'name' => 'Không gian đẹp',
                'slug' => 'khong-gian-dep',
                'subject_id' => 1 // quán nước
            ],
            [
                'name' => 'Ưu đãi hấp dẫn',
                'slug' => 'uu-dai-hap-dan',
                'subject_id' => 1 // quán nước
            ]
        ];
        DB::table('tags')->insert($data);
    }
}
