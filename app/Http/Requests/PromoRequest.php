<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PromoRequest extends FormRequest
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
            'promoName' => 'required|unique:promo',
            'promoCost' => 'required|numeric|between:0,99999999.99',
            'promoSupplies' => 'numeric',
            'promoStart' => 'date',
            'promoEnd' => 'date',
            'qty.*' => 'required|numeric|between:0,999'
        ];
    }

    public function messages()
    {
        return [
            'promoName.unique'  =>  'Promo already exists.',
            'promoName.required' => 'Promo name is required.',
            'promoStart.date' => 'Start date must be a valid date.',
            'promoEnd.date' => 'End date must be a valid date.',
            'promoCost.numeric' => 'Cost must be valid monetary value',
            'promoCost.required' => 'Cost is required',
            'promoCost.max' => 'Max value of cost is 8 digits',
            'qty.*.required' => 'Quantity is required',
            'qty.*.numeric' => 'Quantity must be numeric',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
