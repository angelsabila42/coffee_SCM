<?php

namespace Database\Seeders;

use App\Models\importerModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class importerModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        importerModel::factory()->count(20)->create();
    }
}
