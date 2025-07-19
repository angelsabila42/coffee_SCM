<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Delivery;
use App\Models\DeliveryReport;
use App\Helpers\Helper;

class GenerateWeeklyReport extends Command
{
    protected $signature = 'report:weekly';
    protected $description = 'Generates and stores weekly delivery report';

    public function handle()
    {
        Log::info('Weekly delivery report generation started at ' . now());

        $startOfWeek = now()->subWeek()->startOfWeek();
        $endOfWeek = now()->subWeek()->endOfWeek();

        $deliveries = Delivery::whereBetween('dispatch_date_time', [$startOfWeek, $endOfWeek])->get();

        $reportData = [];

        foreach ($deliveries as $delivery) {
            $reportData[] = [
                'delivery_id' => $delivery->delivery_id,
                'pickup_location' => $delivery->pickup_location,
                'dispatch_date_time' => $delivery->dispatch_date_time,
                'destination' => $delivery->delivery_destination,
                'quantity' => $delivery->quantity,
                'coffee_type' => $delivery->coffee_type,
                'coffee_grade' => $delivery->coffee_grade,
                'status' => $delivery->status,
                'driver' => $delivery->assigned_driver,
                'eta' => $delivery->eta,
                'date_ordered' => $delivery->date_ordered,
            ];
        }

        DeliveryReport::create([
            'reportID' => Helper::generateID(DeliveryReport::class, 'reportID', 'DR', 5),
            'start_period' => $startOfWeek->toDateString(),
            'end_period' => $endOfWeek->toDateString(),
            'title' => 'Weekly Delivery Report (' . $startOfWeek->format('M d') . ' - ' . $endOfWeek->format('M d') . ')',
            'data' => json_encode($reportData),
            'total_deliveries' => count($deliveries),
        ]);

        Log::info('✅ Weekly delivery report saved to database.');
        $this->info('✅ Weekly delivery report saved to database.');
    }
}
