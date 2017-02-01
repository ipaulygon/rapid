<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class InspectItemRequest extends FormRequest
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
            'inspectItemName' => 'required',
            'inspectItemTypeId' => 'required|unique_with:inspect_item,inspectItemName',
        ];
    }

    public function messages()
    {
        return [
            'inspectItemTypeId:unique_with' => 'Inspection item already exists',
            'inspectItemName.required' => 'Inspection item is required',
            'inspectItemTypeId.required' => 'Inspection type is required',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
