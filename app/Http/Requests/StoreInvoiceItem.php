<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceItem extends FormRequest
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
            'product_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'subtotal' => 'required',
            'pvp' => 'required_without:benefit',
            'benefit' => 'required_without:pvp',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Requerido',
            'qty.required' => 'Requerido',
            'price.required' => 'Requerido',
            'subtotal.required' => 'Requerido',
            'pvp.required_without' => 'Obligatorio si no existe Beneficio',
            'benefit.required_without' => 'Obligatorio si no existe PVP',
        ];
    }
}
