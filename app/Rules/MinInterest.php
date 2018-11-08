<?php

namespace App\Rules;

use App\Sale;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class MinInterest implements Rule
{
    protected $sale;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sale = Sale::where([
            ['finished', 0],
            ['user_id', Auth::id()]
        ])->whereNull('deleted_at')->firstOrFail();

        $this->sale->load('client.client_type');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        return ($value >= $this->sale->client->client_type->interest);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        
        return 'El monto minimo de interés para este cliente no puede ser menor de: '.$this->sale->client->client_type->interest.'%';
    }
}
