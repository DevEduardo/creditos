<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoice extends FormRequest
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
            'date' =>  'required|date',
            'code' => 'required|unique:invoices',
            'provider_id' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'date'          => 'Fecha requerida',
            'code'          => 'Número de factura requerida',
            'provider_id'   => 'Proveedor requerido',
            'subtotal'      => 'Subtotal requerido',
            'total'         => 'Total requerido',
        ];
    }
}
