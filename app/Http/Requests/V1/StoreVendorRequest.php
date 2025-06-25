<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreVendorRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:vendor,email',
            'password' => ['required','confirmed','min:8'],
            'street' => '',
            'city' => '',
            'phoneNumber' => 'required|regex:/^07[0-9]{8}$/',
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'phone_number' => $this->phoneNumber
        ]);
    }
}
