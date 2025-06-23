<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkCenterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *'workCenterID','centerName','location
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'centerName' => $this->centerName,
            'location' => $this->location
        ];
    }
}
