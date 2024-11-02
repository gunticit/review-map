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
            'usercode' => 'RV_ADMIN',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'telephone' => '0909123123',
            'password' => bcrypt('123123123123'),
            'department_id' => 1
        ];
        $userAdmin = User::create($admin);
        $userAdmin->assignRole([Role::ADMIN_ROLE]);


        $customer = [
            [
                'usercode' => 'RV_CUSTOMER',
                'name' => 'customer',
                'email' => 'customer@gmail.com',
                'telephone' => '0909123124',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_CUSTOMER1',
                'name' => 'customer1',
                'email' => 'customer1@gmail.com',
                'telephone' => '09091231241',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_CUSTOMER2',
                'name' => 'customer2',
                'email' => 'customer2@gmail.com',
                'telephone' => '09091231242',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_CUSTOMER3',
                'name' => 'customer3',
                'email' => 'customer3@gmail.com',
                'telephone' => '09091231243',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_CUSTOMER4',
                'name' => 'customer4',
                'email' => 'customer4@gmail.com',
                'telephone' => '09091231244',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_CUSTOMER5',
                'name' => 'customer5',
                'email' => 'customer5@gmail.com',
                'telephone' => '09091231245',
                'password' => bcrypt('123123123123'),
            ]
        ];
        User::insert($customer);
        foreach($customer as $customer){
            $userCustomer = User::where('telephone', $customer['telephone'])->first();
            $userCustomer->assignRole([Role::CUSTOMER_ROLE]);
        }

        $partners = [
            [
                'usercode' => 'RV_PARTNER',
                'name' => 'partner',
                'email' => 'partner@gmail.com',
                'telephone' => '0909123125',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_PARTNER1',
                'name' => 'partner1',
                'email' => 'partner1@gmail.com',
                'telephone' => '09091231251',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_PARTNER2',
                'name' => 'partner2',
                'email' => 'partner2@gmail.com',
                'telephone' => '09091231252',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_PARTNER3',
                'name' => 'partner3',
                'email' => 'partner3@gmail.com',
                'telephone' => '09091231253',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_PARTNER',
                'name' => 'partner4',
                'email' => 'partner4@gmail.com',
                'telephone' => '09091231254',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_PARTNER4',
                'name' => 'partner5',
                'email' => 'partner5@gmail.com',
                'telephone' => '09091231255',
                'password' => bcrypt('123123123123'),
            ],
            [
                'usercode' => 'RV_PARTNER5',
                'name' => 'partner6',
                'email' => 'partner6@gmail.com',
                'telephone' => '09091231256',
                'password' => bcrypt('123123123123'),
            ]
        ];
        User::insert($partners);
        foreach($partners as $partner){
            $partnerInfo = User::where('telephone', $partner['telephone'])->first();
            $partnerInfo->assignRole([Role::PARTNER_ROLE]);
        }
    }
}
