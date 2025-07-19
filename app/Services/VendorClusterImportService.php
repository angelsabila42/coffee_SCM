<?php

namespace App\Services;

use App\Models\Vendor;
use App\Models\VendorCluster;
use Illuminate\Support\Facades\Log;

class VendorClusterImportService
{
    public function importFromCsv(string $filePath): array
{
    $importedCount = 0;
    $skippedVendors = [];

    if (!file_exists($filePath)) {
        Log::warning("Vendor cluster import failed: File not found at $filePath");
        return ['importedCount' => 0, 'skippedVendors' => []];
    }

    $csv = array_map('str_getcsv', file($filePath));
    $headers = array_map(fn($h) => trim(preg_replace('/[\x{FEFF}]/u', '', $h)), $csv[0]);
    unset($csv[0]);

    foreach ($csv as $row) {
        $data = array_combine($headers, $row);
        $vendorName = trim($data['vendor'] ?? '');
        if (!$vendorName) continue;

        $vendor = Vendor::whereRaw('LOWER(name) = ?', [strtolower($vendorName)])->first();
        if (!$vendor) {
            $skippedVendors[] = $vendorName;
            continue;
        }

        VendorCluster::updateOrCreate(
            ['vendor_id' => $vendor->id],
            [
                'robusta_(60kg_bags)' => $data['robusta_(60kg_bags)'] ?? 0,
                'arabica_(60kg_bags)' => $data['arabica_(60kg_bags)'] ?? 0,
                'avgPricePerKg_UGX' => $data['avgPricePerKg_UGX'] ?? 0,
                'total_(60kg_bags)' => $data['total_(60kg_bags)'] ?? 0,
                'yearsActive' => $data['yearsActive'] ?? 0,
                'arabica_pct' => $data['arabica_pct'] ?? 0,
                'marketShare_pct' => $data['marketShare_pct'] ?? 0,
            ]
        );

        $importedCount++;
    }

    Log::info('Vendor cluster CSV imported successfully.');

    return [
        'importedCount' => $importedCount,
        'skippedVendors' => $skippedVendors,
    ];
}
}
