<?php

namespace Database\Seeders;

use App\Models\IncomingOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class IncomingOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
        IncomingOrder::factory()->create([
            'created_at' => Carbon::now()->subMonth()->addDays(rand(0, 20)),
        ]);
    }
        for ($i = 0; $i < 24; $i++) {
        IncomingOrder::factory()->create([
            'created_at' => Carbon::now()->subDays(rand(0, now()->day - 1)),
        ]);
        }
        // IncomingOrder::factory()->count(50)->create();
    }
}
