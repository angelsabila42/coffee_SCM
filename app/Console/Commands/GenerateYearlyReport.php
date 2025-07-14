<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Delivery;

class GenerateYearlyReport extends Command
{
    protected $signature = 'report:yearly';
    protected $description = 'Generates yearly delivery report';

    public function handle()
    {
        Log::info('Yearly delivery report generation started at ' . now());

        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();

        $deliveries = Delivery::whereBetween('dispatch_date_time', [$startOfYear, $endOfYear])->get();

        $pdf = app('dompdf.wrapper')->loadView('reports.yearly_orders', ['deliveries' => $deliveries]);

        $filename = 'reports/yearly_report_' . now()->format('Y_m_d_H-i-s') . '.pdf';
        Storage::put($filename, $pdf->output());

        Log::info('Yearly delivery report generated at ' . $filename);
        $this->info('Yearly delivery report generated successfully.');
    }
}
