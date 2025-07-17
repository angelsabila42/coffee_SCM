<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnualCoffeeSalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'year'=> $this-> year,
            '60kg_bags'=> $this->bags_60kg,
            'metric_tonnes'=> $this->metric_tonnes,
            'value_usd'=> $this->value_usd,
            'unit_value_usd_per_kg'=> $this-> unit_value_usd_per_kg,
        ];
    }
}
