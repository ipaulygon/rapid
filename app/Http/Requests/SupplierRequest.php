<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class SupplierRequest extends FormRequest
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
            'supplierName' => 'required|unique:supplier',
            'supplierPerson' => 'required',
            'supplierContact' => 'required|regex:/^\d{11}$/',
        ];
    }

    public function messages()
    {
        return [
            'supplierName.unique'  =>  'Supplier already exists.',
            'supplierName.required' => 'Supplier is required',
            'supplierPerson.required' => 'Supplier contact person is required',
            'supplierContact.required' => 'Supplier contact no. is required',
            'supplierContact.regex' => 'Invalid format of contact No.',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
