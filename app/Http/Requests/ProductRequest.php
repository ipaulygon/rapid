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
            'productBrandId' => 'required',
            'productTypeId' => 'required',
            'productName' => 'required|unique_with:product,productBrandId','productTypeId',
            'cost.*' => 'numeric|required|between:0,99999999.99',
        ];
    }

    public function messages()
    {
        return [
            'productName.unique_with'  =>  'Product already exists',
            'productBrandId.required' => 'Product brand required',
            'productName.required' => 'Product name required',
            'productTypeId.required' => 'Product type required',
            'cost.*.numeric' => 'Cost must be a valid monetary value',
            'cost.*.required' => 'Cost is required',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
