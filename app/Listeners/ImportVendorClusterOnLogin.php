<?php

namespace App\Listeners;

use App\Services\VendorClusterImportService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Login as EventsLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ImportVendorClusterOnLogin
{
    /**
     * Create the event listener.
     */
     protected VendorClusterImportService $importService;

    public function __construct(VendorClusterImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
{
    try {

            $filePath = storage_path('app/private/suppliers_coffee_quantity.csv');
            $this->importService->importFromCsv($filePath);

            Log::info('Vendor cluster import triggered on login.');

    } catch (\Exception $e) {
        Log::error('Error during vendor cluster import: ' . $e->getMessage());
    }
}

}
