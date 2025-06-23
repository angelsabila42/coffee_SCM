<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\WorkCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          WorkCenter::factory()->count(5)->create();
    }
}
