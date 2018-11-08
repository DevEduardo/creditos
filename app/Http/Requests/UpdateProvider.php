<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProvider extends FormRequest
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
            'is_active' => 'required|boolean',
            'image'     => 'mimes:jpeg,png',
            'email'     => 'nullable|string|email',
            //'address'   => 'required',
            'postal_code' => 'nullable|string',
            'phone1'    => 'required',
            //'district'          => 'required',
            //'between_street'    => 'required',
            //'location'          => 'required',
            #'state_id'  =>  'required',
            #'city_id'   =>  'required'
            #'webpage'   => 'url'
            #'profile_id' =>  'required|numeric',
            #'company_id'=> 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required'     =>  'El nombre es requerido',
            'name.string'       =>  'El nombre debe ser string',
            'cuit.required'     =>  'El CUIT es requerido',
            'cuit.string'       =>  'El CUIT debe ser string',
            'profile.email.required'    =>  'El email es requerido',
            'profile.email.email'       =>  'El email es incorrecto',
            'profile.image.mimes'       =>  'La imagen debe ser en formato: jpeg ó png',
            'profile.address.required'  =>  'La dirección es requerida',
            'profile.postal_code.required'  =>  'El código postal es requerido',
            'profile.postal_code.string'   =>  'El código postal debe ser string',
            'profile.phone1.required'       =>  'El número de teléfono es requerido',
            'district.required'          => 'Ingrese el barrio',
            'between_street.required'    => 'Ingrese entre calles',
            'location.required'          => 'Debe ingresar la localidad',
            #'state_id'  =>  'La provincia es requerida',
            #'city_id'   =>  'La ciudad es requerida'
            #'webpage.url'           =>  'La dirección web es incorrecta'
        ];
    }
}
