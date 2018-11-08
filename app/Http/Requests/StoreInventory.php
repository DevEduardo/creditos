<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventory extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reference' => 'required|string|unique:inventories',
            'stock' => 'required|numeric',
            'op' => 'required',
            'qty' => 'required|numeric',
            'product_id' => 'required|numeric',
            'company_id' => 'required|numeric',
            'user_id' => 'required|numeric'
        ];
    }
}
