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
        \App\Models\Staff::query()->delete();
        $staff = [
            [
            'full_name' => 'John Ayebale',
            'role' => 'Supervisor',
            'status' => 'Active',
            'phone_number' => '0700123456',
            'email' => 'johnaye@gmail.com',
            'is_admin' => false, 
        ],
        [
            'full_name' => 'David Okello',
            'role' => 'Warehouse Clerk',
            'status' => 'On Leave',
            'phone_number' => '0787654321',
            'email' => 'davidokello2@gmail.com',
            'is_admin' => true, // Make this staff an admin
        ],
        [
            'full_name' => 'Alice Admin',
            'role' => 'Supervisor',
            'status' => 'Active',
            'phone_number' => '0759988776',
            'email' => 'admin@example.com',
            'is_admin' => true, 
            ],
        ];

        foreach ($staff as $member) {
            Staff::create($member);
        }
        // Add 20 more fake staff using the factory
        Staff::factory()->count(20)->create();
    }
}

