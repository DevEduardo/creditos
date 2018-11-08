<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePriceProducts extends FormRequest
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
            #'products[]' => 'required',
            'percent'    => 'required',
            'op'        =>  'required'
        ];
    }


    public function messages()
    {
        return [
            #'products[].required' => 'Selecciona al menos un producto',
            'percent.required'    =>  'El porcentaje es requerido',
            'op.required'         =>  'La opreación es requerida',
        ];
    }
}
