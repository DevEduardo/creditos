<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStore extends FormRequest
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
            'name' => 'required|string|unique:stores',
            'company_id' => 'required|numeric',
            'profile_id' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>  'El nombre es requerido',
            'name.unique'   =>  'El nombre ya existe',
        ];
    }
}
