<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class DiscountRequest extends FormRequest
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
            'discountName' => 'required|unique:discount',
            'discountRate' => 'numeric|required', 
        ];
    }

    public function messages()
    {
        return [
            'discountName.unique'  =>  'Discount already exists.',
            'discountName.required' => 'Discount name is required',
            'discountRate.required' => 'Discount rate is required',
            'discountRate.numeric' => 'Discount must be numeric'
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
