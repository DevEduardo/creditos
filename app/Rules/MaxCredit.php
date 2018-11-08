<?php

namespace App\Rules;

use App\Sale;
use Illuminate\Contracts\Validation\Rule;

class MaxCredit implements Rule
{
    protected $sale;
    protected $type;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type = null)
    {
        $this->type = $type;
        
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

        if ($this->sale->client->client_type->code == '03') {
            return ($value <= env('MAX_CREDIT_O3'));
        } else {
            return ($value <= env('MAX_CREDIT_O10'));
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->sale->client->client_type->code == '03') {
            return 'El monto maxmimo de credito para este cliente no puede exceder de: '.env('MAX_CREDIT_O3');
        } else {
            return 'El monto maxmimo de credito para este cliente no puede exceder de: '.env('MAX_CREDIT_O10');
        }
    }
}
