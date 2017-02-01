<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ServiceRequest extends FormRequest
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
            'serviceName' => 'required|unique:service',
            'serviceCategoryId' => 'required',
            'servicePrice' => 'numeric|required'
        ];
    }

    public function messages()
    {
        return [
            'serviceName.unique'  =>  'Service already exists',
            'serviceName.required' => 'Service name is required',
            'serviceCategoryId.required' => 'Category is required',
            'servicePrice.required' => 'Price is required',
            'servicePrice.numeric' => 'Price must be numeric'
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
