<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class TechRequest extends FormRequest
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
            'techPic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'techFirst' => 'required|unique_with:technician,techMiddle,techLast',
            'techLast' => 'required',
            'street' => 'required',
            'brgy' => 'required',
            'city' => 'required',
            'techContact' => 'required|regex:/^\d{11}/',
            'techEmail' => 'email',
        ];
    }

    public function messages()
    {
        return [
            'techFirst.unique_with'  => 'Technician exists',
            'techFirst.required' => 'First name is required',
            'techLast.required' => 'Last name is required',
            'street.required' => 'Street is required',
            'brgy.required' => 'Brgy is required',
            'city.required' => 'City is required',
            'techContact.required' => 'Contact is required',
            'techEmail.email' => 'Invalid email address',
            'techContact.regex' => 'Invalid contact'
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
