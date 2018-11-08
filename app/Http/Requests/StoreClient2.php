<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient2 extends FormRequest
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
                'name'              => 'required',
                'dni'               => 'required|numeric|unique:clients',
                'client_type_id'    => 'required|numeric',
                'image_dni'         => 'required_if:client_type_id,1,2,3|mimes:jpeg,png',
                'image_service'     => 'required_if:client_type_id,1,2,3|mimes:jpeg,png',
                'profession'        => 'required_if:client_type_id,1,2,3|nullable|string',
                'email'             => 'nullable|string|email',
                'address'           => 'required_if:client_type_id,1,2,3|nullable|string', 
                'postal_code'       => 'required_if:client_type_id,1,2,3|nullable|string',
                'phone1.0'            => 'required_if:client_type_id,1,2,3',
                'desc_phone'        => 'required_if:client_type_id,1,2,3',
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

    public function messages ()
    {
        return [
                'name.required'              => 'El nombre es requerido',
                'dni.required'               => 'El DNI es requerido',
                'dni.string'                 => 'El DNI debe ser string',
                'dni.unique'                 => 'El DNI ya existe',
                'client_type_id.required'    => 'El tipo de cliente es requerido',
                'client_type_id.numeric'     => 'El tipo de cliente debe ser numérico',
                'image_dni.required_if'         => 'La imagen del DNI es requerida',
                'image_dni.mimes'            => 'La imagen del DNI debe ser jpge ó png',
                'image_service.required_if'     => 'La imagen del serivicio es requerida',
                'image_service.mimes'        => 'La imagen del serivicio debe ser jpeg ó png',
                'profession.required_if'        => 'La profesión u ocupación es requerida',
                'profession.string'          => 'La profesión debe ser string',
                'email.required_if'             => 'El email es requerido',
                'email.string'               => 'El email debe ser string',
                'email.email'                => 'El email tiene un formato invalido',
                'address.required_if'           => 'la dirección es requerida',
                'address.string'             => 'la dirección debe ser string', 
                'postal_code.required_if'       => 'El código postal es requerido',
                'postal_code.string'         => 'El código postal debe ser string',
                'phone1.0.required_if'            => 'El teléfono es requerido',
                'desc_phone.required_if'        => 'Debe ingresar la descripción del telefono',
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
