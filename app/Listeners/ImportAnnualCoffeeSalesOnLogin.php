<?php

namespace App\Listeners;

use App\Services\AnnualCoffeeSaleImportService;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ImportAnnualCoffeeSalesOnLogin
{
    /**
     * Create the event listener.
     */

    
    protected $importService;
    public function __construct(AnnualCoffeeSaleImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
{

    try {
        $filePath = storage_path('app/private/annual_coffee_sales.csv');
        $this->importService->importFromCsv($filePath);

        Log::info('Annual Coffee Sales CSV imported on login.');
    } catch (\Exception $e) {
        Log::error('Annual Coffee Sales import failed: ' . $e->getMessage());
    }
}

}
