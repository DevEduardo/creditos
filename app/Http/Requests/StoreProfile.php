<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfile extends FormRequest
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
            'image' => 'mimes:jpeg,bmp,png',
            'email' => 'required|string|email|max:255|unique:profiles',
            'address' => 'required',
            'postal_code' => 'required|numeric',
            'phone1' => 'numeric',
            'phone2' => 'numeric',
            'webpage' => 'url'
        ];
    }
}
