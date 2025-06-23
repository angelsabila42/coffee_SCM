<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
            'name'=> $this-> name,
            'phoneNumber'=> $this-> phone_number,
            'street'=> $this-> street,
            'city'=> $this-> city
        ];
    }
}
/*'name',
        'email',
        'password',
        'phone_number',
        'street',
        'city',
        'confirm password',
    ]; */