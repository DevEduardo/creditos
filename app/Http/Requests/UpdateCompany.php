<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompany extends FormRequest
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
            'name'              => 'required|string',
            'profile.email'             => 'required|string|email',
            'profile.address'           => 'required|string', 
            'profile.postal_code'       => 'required|string',
            'profile.phone1'            => 'required',
            'profile.image'             => 'mimes:jpeg,png'
        ];
    }


    public function messages()
    {
        return [
            'name.required'              => 'El nombre es requerido',
            'name.string'                => 'El nombre debe ser string',
            'profile.email.required'             => 'El email es requerido',
            'profile.email.string'               => 'El email debe ser string',
            'profile.email.email'                => 'El email tiene un formato invalido',
            'profile.address.required'           => 'la dirección es requerida',
            'profile.address.string'             => 'la dirección debe ser string', 
            'profile.postal_code.required'       => 'El código postal es requerido',
            'profile.postal_code.string'         => 'El código postal debe ser string',
            'profile.phone1.required'            => 'El teléfono es requerido',
            'profile.image.mimes'                => 'La imagen debe ser en formato JPEG o PNG'
        ];
    }
}
