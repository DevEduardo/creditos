<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModel extends FormRequest
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
            'name' => 'required|string',
            'brand_id' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string'   => 'El nombre debe ser string',
            'brand_id.required' => 'La marca es requerida'
        ];
    }
}
