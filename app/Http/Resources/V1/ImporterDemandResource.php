<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImporterDemandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'robusta_(60kg_bags)' => $this['robusta_(60kg_bags)'],
            'arabica_(60kg_bags)' => $this['arabica_(60kg_bags)'],
            'yearsAsCustomer' => $this->yearsAsCustomer,
            'orderFreqPerYear' => $this->orderFreqPerYear,
            'total_(60kg_bags)' => $this['total_(60kg_bags)'],
            'arabica_pct' => $this->arabica_pct,
            'avgOrderSize' => $this->avgOrderSize,

            'importer'=>[
                'name'=> $this->importerModel->name,
                'continent'=> $this->importerModel->continent,
                'country'=> $this->importerModel->country,
            ],
        ];
    }
}
