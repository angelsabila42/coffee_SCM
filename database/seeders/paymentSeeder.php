<?php

namespace Database\Seeders;

use App\Models\importerModel;
use App\Models\Payment;
use Database\Factories\paymentFactory;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class paymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::factory()->count(50)->create();
    }
}
