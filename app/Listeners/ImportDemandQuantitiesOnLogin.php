<?php

namespace App\Listeners;

use App\Services\DemandQuantityImportService;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ImportDemandQuantitiesOnLogin
{
    /**
     * Create the event listener.
     */

    protected DemandQuantityImportService $importService;

     public function __construct(DemandQuantityImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $filePath = storage_path('app/private/demand_qtn.csv');
      
        $this->importService->importFromCsv($filePath);
        Log::info('Demand quantity CSV imported on login.');

    }
}
