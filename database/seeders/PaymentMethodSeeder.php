<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::insert(
            [
                'type' => 'momo',
                'owner_name' => 'Nguyen Van A',
                'account_number' => '0123456789',
            ],
            [
                'type' => 'bank',
                'owner_name' => 'Nguyen Van A',
                'account_number' => '0123456789',
                'bank_name' => 'Vietcombank (Ngân hàng TMCP Ngoại thương Việt Nam)',
                'bank_branch' => "Tan Binh, Ho Chi Minh",
                'note' => ''
            ],
            [
                'type' => 'bank',
                'owner_name' => 'Nguyen Van A',
                'account_number' => '0123456789',
                'bank_name' => 'VietinBank (Ngân hàng TMCP Công thương Việt Nam)',
                'bank_branch' => "Tan Binh, Ho Chi Minh",
                'note' => ''
            ],
            [
                'type' => 'bank',
                'owner_name' => 'Nguyen Van A',
                'account_number' => '0123456789',
                'bank_name' => 'BIDV (Ngân hàng TMCP Đầu tư và Phát triển Việt Nam)',
                'bank_branch' => "Tan Binh, Ho Chi Minh",
                'note' => ''
            ]
        );
    }
}
