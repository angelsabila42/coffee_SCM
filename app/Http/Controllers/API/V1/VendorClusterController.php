<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\VendorClusterResource;
use App\Models\Vendor;
use App\Models\VendorCluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VendorClusterController extends Controller
{
    public function importCsv(){
        $filePath = storage_path('app/private/suppliers_coffee_quantity.csv');
        

        if(!file_exists($filePath)){
            return "CSV file not found at {$filePath}";
        }

        $csv = array_map('str_getcsv', file($filePath));

        $headers = array_map(function ($header){
        return trim(preg_replace('/[\x{FEFF}]/u', '', $header));
        },$csv[0]);
        unset($csv[0]);

        $importedCount = 0;
        $skippedVendors =[];

        foreach ($csv as $row){
            $data = array_combine($headers, $row);

            $vendorName = trim($data['vendor'] ?? '');
            if(!$vendorName){
                Log::warning('Vendor name missing in csv row: ' . json_encode($data));
                continue;
            }

            $vendor = Vendor::whereRaw('LOWER(name) = ?',[strtolower($vendorName)])->first();
            if (!$vendor){
                Log::warning("Vendor not found for name: '{$vendorName}' ");
                $skippedVendors[] = $vendorName;
                continue;
            }

            Log::info("Parsed keys:", array_keys($data));


            VendorCluster::updateOrCreate([
                'vendor_id'=> $vendor->id,
                'robusta_(60kg_bags)' => $data['robusta_(60kg_bags)'] ?? 0,
                'arabica_(60kg_bags)' => $data['arabica_(60kg_bags)'] ?? 0,
                'avgPricePerKg_UGX' => $data['avgPricePerKg_UGX'] ?? 0,
                'total_(60kg_bags)' => $data['total_(60kg_bags)'] ?? 0,
                'yearsActive' => $data['yearsActive'] ?? 0,
                'arabica_pct' => $data['arabica_pct'] ?? 0,
                'marketShare_pct' => $data['marketShare_pct'] ?? 0,
            ]);

            $importedCount++;
        }

        $response = [
            'message' => "Import completed Successfully. Records imported: {$importedCount}. ",
        ];

        if(!empty($skippedVendors)){
            $uniqueSkipped = array_unique($skippedVendors);
            $response['skipped_vendors'] = $uniqueSkipped;
            $response['warning'] = 'Some vendor names in csv were not found in the vendors table and were skipped';
        }
        return response()->json($response);
    }

    public function exportJSON(){
        $vendorCluster = VendorCluster::with('vendor')->get();
        return VendorClusterResource::collection($vendorCluster);
    }
}
