<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|confirmed|string|min:6',
            'password_confirmation'  => 'required|string|min:6',
            'image'     => 'mimes:jpeg,bmp,png',
            'email'     => 'required|string|email|max:255|unique:profiles',
            'address'   => 'required',
            'postal_code' => 'required|string',
            'phone1'    => 'required',
            #'webpage'   => 'url'
        ];
    }

    public function messages()
    {
        return [
            'name.required'     =>  'El nombre es requerido',
            'email.required'    =>  'El email es requerido',
            'email.email'       =>  'El email es incorrecto',
            'email.unique'       =>  'El email ya está en uso',
            'password.required' =>  'La contraseña es obligatoria',
            'password.confirmed' =>  'La contraseña debe ser igual a la anterior',
            'password.min'      =>  'La contraseña debe ser mayor a 6 caracteres',
            
            'password_confirmation.required' =>  'Repetir contraseña es obligatoria',
            'password_confirmation.confirmed' =>  'La contraseña debe ser igual a la anterior',
            'password_confirmation.min'      =>  'La contraseña debe ser mayor a 6 caracteres',

            'image.mimes'       =>  'La imagen debe ser en formato: jpeg, bmp ó png',
            'address.required'  =>  'La dirección es requerida',
            'postal_code.required'  =>  'El código postal es requerido',
            'postal_code.string'   =>  'El código postal debe ser string',
            'phone1.required'    =>  'El número de teléfono es requerido',
            #'webpage.url'       =>  'La dirección web es incorrecta'
        ];
    }
}
