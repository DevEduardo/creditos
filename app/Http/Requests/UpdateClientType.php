<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientType extends FormRequest
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
            'code'      =>  'required|string',
            'name'      =>  'required|string',
            'credit'    =>   'required|numeric',
            'max_fees'  =>  'required|numeric',
            'interest'  => 'required',
            'daily_interest' => 'required|numeric',
            'surcharge' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'code.required'      =>    'El código es requerido',
            'code.string'        =>    'El código debe ser string',
            'name.required'      =>    'El nombre es requerido',
            'name.string'        =>    'El nombre debe ser string',
            'credit.required'    =>    'El monto es requerido',
            'credit.numeric'     =>    'El monto debe ser numerico',
            'max_fees.required'  =>    'La cantidad de cuotas es requerida',
            'max_fees.numeric'   =>    'La cantidad de cuotas debe ser numérica',
            'surcharge.required' =>  'El recargo debe ser enviado',
            'interest.required' => 'El interés debe ser enviado',
            'daily_interest' => 'El % de interés diario dede ser enviado',
            'surcharge.numeric' => 'El recargo debe ser numerico',
            'daily_interest.numeric' => 'El % de interes diario debe ser numerico'
        ];
    }
}
