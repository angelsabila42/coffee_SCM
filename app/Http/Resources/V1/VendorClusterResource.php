<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorClusterResource extends JsonResource
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
            'avgPricePerKg_UGX' => $this->avgPricePerKg_UGX,
            'yearsActive' => $this->yearsActive,
            'total_(60kg_bags)' => $this['total_(60kg_bags)'],
            'arabica_pct' => $this->arabica_pct,
            'marketShare_pct' => $this->marketShare_pct,

            'vendor'=>[
                'name'=> $this->vendor->name,
                'region'=> $this->vendor->region,
                'organicCertified'=> $this->vendor->organicCertified,
            ],
        ];
    }
}
