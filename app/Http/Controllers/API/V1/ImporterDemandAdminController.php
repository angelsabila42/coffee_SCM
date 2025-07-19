<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ImporterDemandResource;
use App\Models\ImporterDemand;
use App\Models\ImporterModel;
use App\Services\ImporterDemandImportService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ImporterDemandAdminController extends Controller
{
    protected $importService;

    public function __construct(ImporterDemandImportService $importService){
        $this->importService = $importService;
    }
    public function importCsv(){
        $filePath = storage_path('app/private/importer_coffee_quantity.csv');

        $result = $this->importService->importFromCsv($filePath);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 404);
        }

        $response = [
            'message' => "Import completed successfully. Records imported: {$result['imported']}.",
        ];

        if (!empty($result['skipped'])) {
            $response['skipped_importers'] = $result['skipped'];
            $response['warning'] = 'Some importer names in CSV were not found and were skipped.';
        }

        return response()->json($response);
    }



    public function exportJSON(){
        $demand = ImporterDemand::with('importerModel')->get();
        return ImporterDemandResource::collection($demand);
    }
}
