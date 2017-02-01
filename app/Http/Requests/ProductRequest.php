<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
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
            'productBrand' => 'required',
            'productName' => 'required|unique_with:product,productBrand','productType',
            'productType' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'productBrand.unique_with'  =>  'Product already exists',
            'productBrand.required' => 'Product brand required',
            'productName.required' => 'Product name required',
            'productType.required' => 'Product type required'
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
