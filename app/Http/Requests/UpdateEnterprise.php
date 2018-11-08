<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnterprise extends FormRequest
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
            'cuit' => 'required|string',
            'email'             => 'required|string|email',
            'address'           => 'required|string', 
            'postal_code'       => 'required|string',
            'phone1'            => 'required',
            'image'             => 'mimes:jpeg,png'
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Este campo es requerido',
            'name.unique'   =>  'Este nombre ya existe',
            'name.string'   =>  'La empresa debe ser string',
            'cuit.required' => 'El CUIT es requerido',
            'cuit.string'   =>  'El CUIT debe ser string',
            'email.required'             => 'El email es requerido',
            'email.string'               => 'El email debe ser string',
            'email.email'                => 'El email tiene un formato invalido',
            'address.required'           => 'la dirección es requerida',
            'address.string'             => 'la dirección debe ser string', 
            'postal_code.required'       => 'El código postal es requerido',
            'postal_code.string'         => 'El código postal debe ser string',
            'phone1.required'            => 'El teléfono es requerido',
            'image.mimes'                => 'La imagen debe ser en formato JPEG o PNG'
        ];
    }
}
