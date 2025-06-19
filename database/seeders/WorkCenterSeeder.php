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
           for($i=0; $i<5; $i++){
            $center = WorkCenter::factory()->make();
            $center->workCenterID = Helper::generateID(WorkCenter::class,'workCenterID',5,"WK");
            $center->save();
                
            }
    }
}
