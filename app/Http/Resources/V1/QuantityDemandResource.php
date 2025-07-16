<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuantityDemandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'year' => $this->year,
            'quantity_(60kg_bags)' => $this['quantity_(60kg_bags)'],
            'yearsAsCustomer' => $this->yearsAsCustomer,
            'orderFreqPerYear' => $this->orderFreqPerYear,
            'avgOrderSize_kg' => $this->avgOrderSize_kg,

            'importer'=>[
                'name'=> $this->importerModel->name,
                'continent'=> $this->importerModel->continent,
                'country'=> $this->importerModel->country,
            ],
        ];
    }
}
