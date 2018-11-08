<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceDetail extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'invoice_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'price' => 'required|numeric',
            'qty' => 'required|numeric',
            'subtotal' => 'required|numeric'
        ];
    }
}
