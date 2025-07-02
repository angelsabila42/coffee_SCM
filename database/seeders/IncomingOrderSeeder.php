<?php

namespace Database\Seeders;

use App\Models\IncomingOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomingOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IncomingOrder::factory()->count(50)->create();
    }
}
