<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Sale;
use Illuminate\Support\Facades\Auth;

class MaxAdvance implements Rule
{
    protected $type;
    protected $sale;
    protected $saleType;

    /**
     * Create a new rule instance.
     *
     * @param String $type es el tipo de la venta que sale del campo way_sale
     *
     * @return void
     */
    public function __construct($type = null, $saleType)
    {
        $this->type = $type;
        $this->saleType = $saleType;

        $this->sale = Sale::where([
            ['finished', 0],
            ['user_id', Auth::id()],
            ['type', $this->saleType]
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
        if ($this->type != 'without_advance') {
        
            return ($value <= $this->sale->total);
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        
        return 'El monto del anticipo, no puede ser mayor al monto de la venta.'. $this->sale->total;
    }
}
