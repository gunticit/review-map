<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bank::insert(
            [
                'name' => 'Vietcombank (Ngân hàng TMCP Ngoại thương Việt Nam)'
            ],
            [
                'name' => 'VietinBank (Ngân hàng TMCP Công thương Việt Nam)'
            ],
            [
                'name' => 'BIDV (Ngân hàng TMCP Đầu tư và Phát triển Việt Nam)'
            ],
            [
                'name' => 'Techcombank (Ngân hàng TMCP Kỹ thương Việt Nam)'
            ],
            [
                'name' => 'MB Bank (Ngân hàng TMCP Quân đội)'
            ],
            [
                'name' => 'Sacombank (Ngân hàng TMCP Sài Gòn Thương Tín)'
            ],
            [
                'name' => 'ACB (Ngân hàng TMCP Á Châu)'
            ],
            [
                'name' => 'TPBank (Ngân hàng TMCP Tiên Phong)'
            ],
            [
                'name' => 'VPBank (Ngân hàng TMCP Việt Nam Thịnh Vượng)'
            ],
            [
                'name' => 'HDBank (Ngân hàng TMCP Phát triển Nhà TP.HCM)'
            ],
        );
    }
}
