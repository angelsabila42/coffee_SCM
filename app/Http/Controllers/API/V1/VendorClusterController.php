<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\VendorClusterResource;
use App\Models\Vendor;
use App\Models\VendorCluster;
use App\Services\VendorClusterImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VendorClusterController extends Controller
{
    protected $importService;
    public function __construct(VendorClusterImportService $importService)
    {
        $this->importService = $importService;
    }
    public function importCsv(){
     
        $filePath = storage_path('app/private/suppliers_coffee_quantity.csv');

        try {
            $result = $this->importService->importFromCsv($filePath);

            $response = [
                'message' => "Import successful. Imported: {$result['importedCount']}"
            ];

            if (!empty($result['skippedVendors'])) {
                $response['skipped_vendors'] = $result['skippedVendors'];
                $response['warning'] = 'Some vendors not found and skipped.';
            }

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }


    public function exportJSON(){
        $vendorCluster = VendorCluster::with('vendor')->get();
        return VendorClusterResource::collection($vendorCluster);
    }
}
