<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class VarianceRequest extends FormRequest
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
            'varianceSize' => 'required',
            'varianceUnitId' => 'required|unique_with:variance,varianceSize',
        ];
    }

    public function messages()
    {
        return [
            'varianceUnitId:unique_with' => 'Variance already exists',
            'varianceSize.required' => 'Size is required',
            'varianceUnitId.required' => 'Unit is required',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
