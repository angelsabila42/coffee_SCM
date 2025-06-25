<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SalesReport;
use App\Helpers\Helper;

class SalesReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for($i=0; $i<30; $i++){
            $report= SalesReport::factory()->make();
            $report->reportID = Helper::generateID(SalesReport::class,'reportID','SR',5);
            $report->save();
         }
    }
}
