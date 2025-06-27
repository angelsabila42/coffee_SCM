<?php

namespace Database\Seeders;

use App\Models\DeliveryReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\Helper;
class DeliveryReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for($i=0; $i<30; $i++){
            $report= DeliveryReport::factory()->make();
            $report->reportID = Helper::generateID(DeliveryReport::class,'reportID','DR',5);
            $report->save();
         }
    }
}
