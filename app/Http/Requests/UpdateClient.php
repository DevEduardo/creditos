<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClient extends FormRequest
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
            'dni'               => 'required|string',
            'client_type_id'    => 'required|numeric',
            #'profile_id'        => 'required|numeric',
            'image_dni'         => 'mimes:jpeg,png',
            'image_service'     => 'mimes:jpeg,png',
            #'is_working'        => 'required',
            'profession'        => 'required_if:client_type_id,1,2,3|string',
            'email'             => 'nullable|string|email',
            'address'           => 'required_if:client_type_id,1,2,3|string', 
            'postal_code'       => 'required_if:client_type_id,1,2,3|string',
            'phone1.0'            => 'required_if:client_type_id,1,2,3',
            'district'          => 'required_if:client_type_id,1,2,3',
            'between_street'    => 'required_if:client_type_id,1,2,3',
            'location'          => 'required_if:client_type_id,1,2,3',
            'enterprise.name'   => 'required_if:client_type_id,2',
            'enterprise.cuit'   => 'required_if:client_type_id,2',
            'enterprise.email'   => 'required_if:client_type_id,2',
            'enterprise.location'   => 'required_if:client_type_id,2',
            'enterprise.postal_code'   => 'required_if:client_type_id,2',
            'enterprise.district'   => 'required_if:client_type_id,2',
            'enterprise.between_street'   => 'required_if:client_type_id,2',
            'enterprise.phone1'   => 'required_if:client_type_id,2',
            'enterprise.address'   => 'required_if:client_type_id,2',
        ];
    }



    public function messages()
    {
        return [
            'name.required'              => 'El nombre es requerido',
            'name.string'                => 'El nombre debe ser string',
            'dni.string'                 => 'El DNI debe ser string',
            'client_type_id.required'    => 'El tipo de cliente es requerido',
            'client_type_id.numeric'     => 'El tipo de cliente debe ser numérico',
            #'profile_id.required'        => 'El perfil es requeridonumeric',
            'image_dni.mimes'            => 'La imagen del DNI debe ser jpge ó png',
            'image_service.mimes'        => 'La imagen del serivicio debe ser jpeg ó png',
            #'is_working.required'        => 'El campo trabaja? es requerido',
            'profession.required_if'        => 'La profesión u ocupación es requerida',
            'profession.string'          => 'La profesión debe ser string',
            //'email.required'             => 'El email es requerido',
            'email.string'               => 'El email debe ser string',
            'email.email'                => 'El email tiene un formato invalido',
            'address.required_if'           => 'la dirección es requerida',
            'address.string'             => 'la dirección debe ser string', 
            'postal_code.required_if'       => 'El código postal es requerido',
            'postal_code.string'         => 'El código postal debe ser string',
            'phone1.0.required_if'            => 'El teléfono es requerido',
            'district.required_if'          => 'Ingrese el barrio',
            'between_street.required_if'    => 'Ingrese entre calles',
            'location.required_if'          => 'Debe ingresar la localidad',
            'enterprise.name.required_if'     => 'Debe ingresar el nombre de la empresa.',
            'enterprise.cuit.required_if'     => 'Debe ingresar el CUIT de la empresa.',
            'enterprise.email.required_if'     => 'Debe ingresar el email de la empresa.',
            'enterprise.location.required_if'   => 'Debe ingresar la localidad de la empresa.',
            'enterprise.postal_code.required_if'    => 'Debe ingresar el codigo postal de la empresa.',
            'enterprise.district.required_if'   => 'Debe ingresar el barrio de la empresa',
            'enterprise.between_street.required_if' => 'Debe ingresar la entre calle de la empresa',
            'enterprise.phone1.required_if' => 'Debe ingresar un numero telefonico',
            'enterprise.address.required_if' => 'Debe ingresar la direccion de la empresa',
        ];
    }
}
