<?php

namespace App\Services;

use App\Models\AnnualCoffeeSale;
use Illuminate\Support\Facades\Log;

class AnnualCoffeeSaleImportService
{
    public function importFromCsv(string $filePath): string
    {
        if (!file_exists($filePath)) {
            return "CSV file not found at {$filePath}";
        }

        $csv = array_map('str_getcsv', file($filePath));
        $headers = array_map(function ($header) {
            return trim(preg_replace('/[\x{FEFF}]/u', '', $header));
        }, $csv[0]);
        unset($csv[0]);

        foreach ($csv as $row) {
            $data = array_combine($headers, $row);

            if (!empty($data['year'])) {
                try {
                    AnnualCoffeeSale::updateOrCreate(
                        ['year' => $data['year']],
                        [
                            'bags_60kg' => $data['bags_60kg'],
                            'metric_tonnes' => $data['metric_tonnes'],
                            'value_usd' => $data['value_usd'],
                            'unit_value_usd_per_kg' => $data['unit_value_usd_per_kg'],
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error('Annual Coffee Sale Import failed', ['data' => $data, 'error' => $e->getMessage()]);
                }
            }
        }

        return "Import completed successfully";
    }
}
