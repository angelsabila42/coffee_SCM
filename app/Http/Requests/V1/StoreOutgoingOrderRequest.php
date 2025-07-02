<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutgoingOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required|numeric|min:20',
            'vendor_id' => 'required|exists:vendor,id',
            'work_center_id' => 'required|exists:work_centers,id',
            'deadline' => 'required|date',
            'coffeeType' => 'required|string',
            
        ];
    }
}

