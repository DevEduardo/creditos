<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Laracasts\Flash\Flash;

use Illuminate\Contracts\Validation\Validator;

class StoreClient extends FormRequest
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

    private $rules = [

            'rules' =>[

                'name'              => 'required',
                'dni'               => 'required|string|unique:clients',
                'client_type_id'    => 'required|numeric',
                'image_dni'         => 'required|mimes:jpeg,png',
                'image_service'     => 'required|mimes:jpeg,png',
                'profession'        => 'required|string',
                'email'             => 'required|string|email',
                'address'           => 'required|string', 
                'postal_code'       => 'required|string',
                'phone1'            => 'required',
            ],

            'messages' => [

                'name.required'              => 'El nombre es requerido',
                'dni.required'               => 'El DNI es requerido',
                'dni.string'                 => 'El DNI debe ser string',
                'dni.unique'                 => 'El DNI ya existe',
                'client_type_id.required'    => 'El tipo de cliente es requerido',
                'client_type_id.numeric'     => 'El tipo de cliente debe ser numérico',
                'image_dni.required'         => 'La imagen del DNI es requerida',
                'image_dni.mimes'            => 'La imagen del DNI debe ser jpge ó png',
                'image_service.required'     => 'La imagen del serivicio es requerida',
                'image_service.mimes'        => 'La imagen del serivicio debe ser jpeg ó png',
                'profession.required'        => 'La profesión u ocupación es requerida',
                'profession.string'          => 'La profesión debe ser string',
                'email.required'             => 'El email es requerido',
                'email.string'               => 'El email debe ser string',
                'email.email'                => 'El email tiene un formato invalido',
                'address.required'           => 'la dirección es requerida',
                'address.string'             => 'la dirección debe ser string', 
                'postal_code.required'       => 'El código postal es requerido',
                'postal_code.string'         => 'El código postal debe ser string',
                'phone1.required'            => 'El teléfono es requerido',

            ]

        ];

        private $enterpriseInformation = [

            'rules'     => [

                'enterprise[name]' => 'required|string|unique:enterprises',
                'enterprise[cuit]' => 'required|string|unique:enterprises',
                'enterprise[email]'             => 'required|string|email',
                'enterprise[address]'           => 'required|string', 
                'enterprise[postal_code]'       => 'required|string',
                'enterprise[phone1]'            => 'required',
            ],

            'messages'  => [
                'enterprise[name].required' => 'Este campo es requerido',
                'enterprise[name].unique'   =>  'Este nombre ya existe',
                'enterprise[name].string'   =>  'La empresa debe ser string',
                'enterprise[cuit].required' => 'Este campo es requerido',
                'enterprise[cuit].unique'   =>  'Este CUIT ya existe',
                'enterprise[cuit].string'   =>  'El CUIT debe ser string',
                'enterprise[email].required'             => 'El email es requerido',
                'enterprise[email].string'               => 'El email debe ser string',
                'enterprise[email].email'                => 'El email tiene un formato invalido',
                'enterprise[address].required'           => 'la dirección es requerida',
                'enterprise[address].string'             => 'la dirección debe ser string', 
                'enterprise[postal_code].required'       => 'El código postal es requerido',
                'enterprise[postal_code].string'         => 'El código postal debe ser string',
                'enterprise[phone1].required'            => 'El teléfono es requerido',
            ]

        ];

   

    /**

     * Get the validation rules that apply to the request.

     *

     * @return array

     */

    public function rules()
    {
        dd($this->request->all());

        if($request->has('enterprise'))
        {

            return array_merge($this->rules['rules'], $this->enterpriseInformation['rules']);

        }

        return $this->rules['rules'];

    }

    public function messages()
    {
        if( $this->request->has('enterprise'))
        {

            return array_merge($this->rules['messages'], $this->enterpriseInformation['messages']);

        }

        return $this->rules['messages'];

    }

    protected function failedValidation(Validator $validator)

    {

        //Flash::error('Disculpe!, debe verificar los datos ingresados.')->important();
        
        dd($validator);

        //alert()->flash($validator, 'warning', ['text' => 'Error intenta nuevamente.']);


        return parent::failedValidation($validator);   

    }

}