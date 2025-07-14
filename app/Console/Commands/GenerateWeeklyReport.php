<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Delivery;

class GenerateWeeklyReport extends Command
{
    protected $signature = 'report:weekly';
    protected $description = 'Generates weekly delivery report';

    public function handle()
    {
        Log::info('Weekly delivery report generation started at ' . now());

        $startOfWeek = now()->subWeek()->startOfWeek();
        $endOfWeek = now()->subWeek()->endOfWeek();

        $deliveries = Delivery::whereBetween('dispatch_date_time', [$startOfWeek, $endOfWeek])->get();

        $pdf = app('dompdf.wrapper')->loadView('reports.weekly_orders', ['deliveries' => $deliveries]);

        $filename = 'reports/weekly_report_' . now()->format('Y_m_d_H-i-s') . '.pdf';
        Storage::put($filename, $pdf->output());

        Log::info('Weekly delivery report generated at ' . $filename);
        $this->info('Weekly delivery report generated successfully.');
    }
}
