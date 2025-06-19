<?php

namespace Database\Seeders;

use App\Models\SalesReport;
use App\Models\DeliveryReport;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@lightbp.com',
            'password' => Hash::make('secret'),
            
        ]);

        $this->call([
            SalesReportSeeder::class,
            DeliveryReportSeeder::class,
            WorkCenterSeeder::class,
        ]);
    }
}
