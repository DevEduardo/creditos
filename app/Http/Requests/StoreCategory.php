<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategory extends FormRequest
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
            'name' => 'required|string|unique:categories',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string'   => 'El nombre debe ser string',
            'name.unique' => 'El nombre ya existe'
        ];
    }
}
