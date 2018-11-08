<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrand extends FormRequest
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
            'name' => 'required|string|unique:brands',
            #image' => 'mimes:jpeg,bmp,png',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Este campo es requerido',
            'name.unique'   =>  'Este nombre ya existe',
            'name.string'   =>  'La marca debe ser string',
            #image' => 'mimes:jpeg,bmp,png',
        ];
    }
}
