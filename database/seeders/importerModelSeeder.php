<?php

namespace Database\Seeders;

use App\Models\importerModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class importerModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i = 0; $i < 11; $i++) {
        importerModel::factory()->create([
            'created_at' => Carbon::now()->subMonth()->addDays(rand(0, 20)),
        ]);
    }
        for ($i = 0; $i < 9; $i++) {
        importerModel::factory()->create([
            'created_at' => Carbon::now()->subDays(rand(0, now()->day - 1)),
        ]);
        }
        // importerModel::factory()->count(20)->create();
    }
}
