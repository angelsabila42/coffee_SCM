<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         
         $staff = [
            [
            'full_name' => 'John Ayebale',
            'work_center' => 'Mbale',
            'role' => 'Supervisor',
            'status' => 'Active',
            'phone_number' => '0700123456',
            'email' => 'johnaye@gmail.com'
        ],
        [
            'full_name' => 'David Okello',
            'work_center' => 'Kampala',
            'role' => 'Supervisor',
            'status' => 'On Leave',
            'phone_number' => '0787654321',
            'email' => 'davidokello2@gmail.com',
        ],
        [
            'full_name' => 'Sarah Nakitto',
            'work_center' => 'Jinja',
            'role' => 'Warehouse Clerk',
            'status' => 'Active',
            'phone_number' => '0759988776',
            'email' => 'nakisarah@gmail.com',
            ],
        ];

        foreach ($staff as $member) {
            Staff::create($member);
        }
    }
}
