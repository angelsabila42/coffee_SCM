<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
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
    public function rules()
    {
        $method = $this->method();

        if($method == 'PUT'){
            return [
                'name' => 'required',
                'email' => 'required|email|unique:vendor,email',
                'password' => ['required','confirmed','min:8'],
                'street' => 'nullable|string',
                'city' => 'nullable|string',
                'phone_number' => 'required|regex:/^07[0-9]{8}$/',
            ];
        }else{
            return[
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email|unique:vendor,email',
                'password' => ['sometimes','required','confirmed','min:8'],
                'street' => 'sometimes|nullable|string',
                'city' => 'sometimes|nullable|string',
                'phone_number' => 'sometimes|required|regex:/^07[0-9]{8}$/',
            ];
        }
    }

    protected function prepareForValidation(){

        if($this->has('phoneNumber')){
            $this->merge([
            'phone_number' => $this->phoneNumber
        ]);
        }
       
    }
}
