<?php

namespace Database\Seeders;

use App\Models\OutgoingOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutgoingOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OutgoingOrder::factory()->count(50)->create();
    }
}
