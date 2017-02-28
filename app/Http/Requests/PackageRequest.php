<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'packageName' => 'required|unique:package',
            'packageCost' => 'required|numeric|between:0,99999999.99',
        ];
    }
    public function messages()
    {
        return [
            'packageName.unique'  =>  'Package already exists.',
            'packageName.required' => 'Package name is required.',
            'packageCost.numeric' => 'Cost must be valid monetary value',
            'packageCost.required' => 'Cost is required',
            'packageCost.max' => 'Max value of cost is 8 digits',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
