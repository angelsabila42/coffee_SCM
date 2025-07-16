<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Delivery;

class GenerateMonthlyReport extends Command
{
    protected $signature = 'report:monthly';
    protected $description = 'Generates monthly delivery report';

    public function handle()
    {
        Log::info('Monthly delivery report generation started at ' . now());

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $deliveries = Delivery::whereBetween('dispatch_date_time', [$startOfMonth, $endOfMonth])->get();

        $pdf = app('dompdf.wrapper')->loadView('livewire.delivery-report-table', ['deliveries' => $deliveries]);

        $filename = 'reports/monthly_report_' . now()->format('Y_m_d_H-i-s') . '.pdf';
        Storage::put($filename, $pdf->output());

        Log::info('Monthly delivery report generated at ' . $filename);
        $this->info('Monthly delivery report generated successfully.');
    }
}
