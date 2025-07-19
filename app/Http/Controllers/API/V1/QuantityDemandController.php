<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\QuantityDemandResource;
use App\Models\ImporterModel;
use App\Models\QuantityDemand;
use App\Services\DemandQuantityImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuantityDemandController extends Controller
{
    protected $importService;

    public function __construct(DemandQuantityImportService $importService)
    {
        $this->importService = $importService;
    }

    public function importCsv()
    {
        $filePath = storage_path('app/private/demand_qtn.csv');
        $result = $this->importService->importFromCsv($filePath);

        if (isset($result['error'])) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    public function exportJSON(){
        $demand = QuantityDemand::with('importerModel')->get();
        return QuantityDemandResource::collection($demand);
    }
}
