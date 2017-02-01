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
            'promoStart' => 'date|required',
            'promoEnd' => 'date|required'
        ];
    }

    public function messages()
    {
        return [
            'promoName.unique'  =>  'Promo already exists.',
            'promoName.required' => 'Promo name is required.',
            'promoStart.required' => 'Start Date is required.',
            'promoEnd.required' => 'End Date is required'
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}