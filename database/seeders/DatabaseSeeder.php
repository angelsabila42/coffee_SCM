<?php

namespace Database\Seeders;

use App\Models\SalesReport;
use App\Models\DeliveryReport;
use App\Models\importerModel;
use App\Models\IncomingOrder;
use App\Models\OutgoingOrder;
use App\Models\User;
use App\Models\WorkCenter;
use App\Models\Staff;
use App\Models\LeaveHistory;
use Database\Factories\IncomingOrderFactory;
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


        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@lightbp.com',
        //     'password' => Hash::make('secret'),
            
        // ]);

        $this->call([

            VendorSeeder::class,
            importerModelSeeder::class,
            WorkCenterSeeder::class,
            IncomingOrderSeeder::class,
            OutgoingOrderSeeder::class,
            SalesReportSeeder::class,
            DeliveryReportSeeder::class,
            WorkCenterSeeder::class,
            ChatTestSeeder::class,
            InventorySeeder::class,
            paymentSeeder::class, // Add chat test data

        



        ]);

    }
}
