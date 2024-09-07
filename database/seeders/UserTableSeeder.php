<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin =  [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'telephone' => '0909123123',
            'password' => bcrypt('123123123123'),
        ];
        $userAdmin = User::create($admin);
        $userAdmin->assignRole([Role::ADMIN_ROLE]);


        $customer = [
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'telephone' => '0909123124',
            'password' => bcrypt('123123123123'),
        ];
        $userCustomer = User::create($customer);
        $userCustomer->assignRole([Role::CUSTOMER_ROLE]);

        $guest = [
            'name' => 'guest',
            'email' => 'guest@gmail.com',
            'telephone' => '0909123125',
            'password' => bcrypt('123123123123'),
        ];
        $userGuest = User::create($guest);
        $userGuest->assignRole([Role::GUEST_ROLE]);
    }
}
