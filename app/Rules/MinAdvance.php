<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Sale;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MinAdvance implements Rule
{
    protected $type;
    protected $sale;
    protected $other;
    protected $auth;
    protected $saleType;
    protected $incorrect;
    /**
     * Create a new rule instance.
     *
     * @param String $type es el tipo de la venta que sale del campo way_sale
     *
     * @return void
     */
    public function __construct($type = null, $auth = null, $saleType)
    {
        $this->type = $type;

        $this->saleType = $saleType;

        $this->sale = Sale::where([
            ['finished', 0],
            ['user_id', Auth::id()],
            ['type', $this->saleType]
        ])->whereNull('deleted_at')->firstOrFail();

        $this->sale->load('client.client_type');

        $this->other = false;
        $this->auth = $auth;
        $this->incorrect = false;

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
        $val = true;

        if ($this->type != 'without_advance') {

            /*if ($this->type == 'sing') {
                return ($value >= $this->sale->total*0.5);
            }*/

            if ($this->type == 'two_advance') {
                $val = ($value >= ($this->sale->total*0.25)/2);
            }

            if ($this->type == 'credit') {
                $val = ($value >= $this->sale->total*0.25);
            }

            /*if ($val && $this->auth == null) 
            {
                if (($this->sale->total - $value) >= $this->sale->client->client_type->credit) {
                    $this->other = true;
                    return false;
                }
            }
            elseif ($val && $this->auth != null) 
            {
                try {
                    $supervisor = Token::where('value', $this->auth)->firstOrFail();
                } catch (ModelNotFoundException $e) {
                    $this->incorrect = true;
                    return false;
                }

                $supervisor->load('authorization');

                if (! empty($supervisor->authorization)) {
                    $this->incorrect = true;
                    return false;
                }
            }*/

            return $val;
        }

        /*if ($val && $this->auth == null) 
        {
            if (($this->sale->total - $value) >= $this->sale->client->client_type->credit) {
                $this->other = true;
                return false;
            }
        }
        elseif ($val && $this->auth != null) 
        {
            try {
                $supervisor = Token::where('value', $this->auth)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $this->incorrect = true;
                return false;
            }

            $supervisor->load('authorization');

            if (! empty($supervisor->authorization)) {
                $this->incorrect = true;
                return false;
            }
        }*/

        return $val;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        /*if ($this->other) {
            return json_encode(['El monto máxmimo de crédito para este cliente no puede exceder de: '.number_format($this->sale->client->client_type->credit, 0, ',', '.').' ARS. ', 'auth']);
        }

        if ($this->incorrect) {
            return json_encode(['Por favor, ingrese una clave de usuario superior válida para autorizar; en el siguiente campo:', 'auth']);
        }*/

        if ($this->type == 'two_advance') {
            return 'El monto del anticipo, debe ser mayor o igual a la mitad del 25% de la venta. M&iacute;nimo '. number_format((($this->sale->total*0.25)/2), 0, ',', '.');
        }

        if ($this->type == 'sing') {
            return 'El monto del anticipo, debe ser mayor o igual a la mitad del monto de la venta. M&iacute;nimo '. number_format($this->sale->total*0.5, 0, ',', '.');
        }
        
        return 'El monto del anticipo, debe ser mayor o igual al 25% del monto de la venta. M&iacute;nimo '. number_format($this->sale->total*0.25, 0, ',', '.');
    }
}
