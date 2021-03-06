<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCredit extends FormRequest
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
            'sale_id' => 'required|numeric',
            'advance' => 'required|numeric',
            'fees' => 'required|numeric',
            'pay_lapse' => 'required',
            'interest' => 'required|numeric',
            'is_payed' => 'required|boolean'
        ];
    }
}
