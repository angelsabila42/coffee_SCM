<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Delivery;
use Carbon\Carbon;

class CreateSampleDeliveries extends Command
{
    protected $signature = 'create:sample-deliveries';
    protected $description = 'Create 3 sample delivery records in the deliveries table';

    public function handle()
    {
        $this->info('Creating 3 sample delivery records...');

        // Check existing count and create unique IDs
        $existingCount = Delivery::count();
        $baseId = $existingCount + 1;

        // Sample delivery 1
        $deliveryId1 = 'NX_' . str_pad($baseId, 3, '0', STR_PAD_LEFT);
        Delivery::create([
            'delivery_id' => $deliveryId1,
            'pickup_location' => 'Kampala Coffee Warehouse',
            'dispatch_date_time' => Carbon::now()->addDays(2)->setTime(8, 0),
            'delivery_destination' => 'Germany',
            'quantity' => 3000,
            'coffee_type' => 'Arabica',
            'coffee_grade' => 'AA',
            'status' => 'Scheduled',
            'assigned_driver' => 'Higenyi William',
            'eta' => Carbon::now()->addDays(15)->toDate(),
            'date_ordered' => Carbon::now()->subDays(3)->toDate(),
            'order_reference' => 'ORD-2025-' . str_pad($baseId, 3, '0', STR_PAD_LEFT),
            'confirmed_by_admin' => 'Admin User',
            'admin_confirmed_at' => Carbon::now()->subDays(1),
        ]);

        // Sample delivery 2
        $deliveryId2 = 'NX_' . str_pad($baseId + 1, 3, '0', STR_PAD_LEFT);
        Delivery::create([
            'delivery_id' => $deliveryId2,
            'pickup_location' => 'Entebbe Processing Center',
            'dispatch_date_time' => Carbon::now()->addDays(5)->setTime(10, 30),
            'delivery_destination' => 'Netherlands',
            'quantity' => 2500,
            'coffee_type' => 'Robusta',
            'coffee_grade' => 'Grade 1',
            'status' => 'In Transit',
            'assigned_driver' => 'Sarah Nakamura',
            'eta' => Carbon::now()->addDays(12)->toDate(),
            'date_ordered' => Carbon::now()->subDays(7)->toDate(),
            'order_reference' => 'ORD-2025-' . str_pad($baseId + 1, 3, '0', STR_PAD_LEFT),
            'confirmed_by_admin' => 'Admin User',
            'admin_confirmed_at' => Carbon::now()->subDays(5),
        ]);

        // Sample delivery 3
        $deliveryId3 = 'NX_' . str_pad($baseId + 2, 3, '0', STR_PAD_LEFT);
        Delivery::create([
            'delivery_id' => $deliveryId3,
            'pickup_location' => 'Mbarara Coffee Hub',
            'dispatch_date_time' => Carbon::now()->subDays(10)->setTime(14, 0),
            'delivery_destination' => 'United States',
            'quantity' => 4200,
            'coffee_type' => 'Arabica',
            'coffee_grade' => 'AAA',
            'status' => 'Delivered',
            'assigned_driver' => 'John Mubarak',
            'eta' => Carbon::now()->subDays(2)->toDate(),
            'date_ordered' => Carbon::now()->subDays(20)->toDate(),
            'order_reference' => 'ORD-2025-' . str_pad($baseId + 2, 3, '0', STR_PAD_LEFT),
            'confirmed_by_admin' => 'Admin User',
            'admin_confirmed_at' => Carbon::now()->subDays(18),
        ]);

        $this->info('✅ Successfully created 3 sample delivery records:');
        $this->line("  1. $deliveryId1 - Scheduled delivery to Germany (3000kg Arabica)");
        $this->line("  2. $deliveryId2 - In Transit delivery to Netherlands (2500kg Robusta)");
        $this->line("  3. $deliveryId3 - Delivered to United States (4200kg Arabica)");
        
        $this->info('📊 Total deliveries in database: ' . Delivery::count());
    }
}
