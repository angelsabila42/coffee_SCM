<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OutgoingOrderChartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'=> $this-> id,
            'quantity'=> $this-> quantity,
            'status'=> $this-> status,
            'created_at'=> $this->created_at,

            'vendor' => $this->vendorProfile ? [
                       'name' => $this->vendorProfile->name,
                       'id' => $this->vendorProfile->id,
                        ] : null,
        ];
    }
}
