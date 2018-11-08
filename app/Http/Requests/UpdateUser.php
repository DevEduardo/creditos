<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'password'  => 'nullable|min:6',
            'password_confirmation'  => 'required_with:password|same:password',
            'image'     => 'mimes:jpeg,bmp,png',
            'email'     => 'required|string|email|max:255',
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
            'password.min'      =>  'La contraseña debe ser mayor a 6 caracteres',
            'password_confirmation.required_with' => 'La conformacion de contraseña debe estar presente',
            'password_confirmation.same' => 'La conformacion de contraseña debe ser igual a la contraseña',
            'image.mimes'       =>  'La imagen debe ser en formato: jpeg, bmp ó png',
            'address.required'  =>  'La dirección es requerida',
            'postal_code.required'  =>  'El código postal es requerido',
            'postal_code.string'   =>  'El código postal debe ser string',
            'phone1.required'    =>  'El número de teléfono es requerido',
            #'webpage.url'       =>  'La dirección web es incorrecta'
        ];
    }
}
