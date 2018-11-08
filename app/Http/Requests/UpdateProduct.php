<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest
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
            'name'          => 'required|string', 
            #'code'          => 'required',
            'reference'     => 'required',
            'price'         => 'required|numeric',
            #'color'         => 'required',
            'original_price' => 'required|numeric',
            #'tax'           => 'required|numeric',
            #'stock'         => 'required|numeric',
            'stock_minimun' => 'required|numeric',
            #'brand_id'      => 'required',
            #'model_id'      => 'required|numeric', 
            'company_id'    => 'required'
        ];
    }


    public function messages()
    {
        return [
            'name.required'     => 'El nombre es requerido',
            'name.string'       => 'El nombre debe ser string',
            #'code.required'     => 'El código es requerido',
            #'code.unique'       => 'El código ya existe',
            'price.required'    => 'El precio es requerido',
            'price.numeric'     => 'El precio debe ser numerico',
            #'color.required'    => 'El color es requerido',
            #'tax.required'      => 'El impuesto es requerido',
            #'tax.numeric'       => 'El impuesto debe ser numerico',
            #'stock.required'    => 'El stock es requerido',
            #'stock.numeric'     => 'El stock debe ser numerico',
            #'brand_id.required' => 'La marca es requerida',
            #'model_id.required' => 'El modelo es requerido',
            #'model_id.numeric' => 'El modelo es requerido',
            'company_id.required'       => 'La compañia es requerida',
            'original_price.required'   => 'El precio original es requerido',
            'original_price.numeric'    => 'El precio debe ser numerico',
            'reference.required'        => 'La referencia es requerida',
            'stock_minimun.numeric'     => 'El stock debe ser numerico',
            'stock_minimun.required'    => 'El stock es requerido',
        ];
    }
}
