<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Sale;
use App\User;
use App\Token;
use App\Credit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreditLimit implements Rule
{
    protected $sale;
    protected $other;
    protected $auth;
    protected $incorrect;
    protected $typeSale;
    protected $otherCredits;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($auth = null, $typeSale = null)
    {

        $this->sale = Sale::where([
            ['finished', 0],
            ['user_id', Auth::id()]
        ])->whereNull('deleted_at')->firstOrFail();

        $this->sale->load('client.client_type');

        $this->other = false;
        $this->auth = $auth;
        $this->incorrect = false;
        $this->typeSale = $typeSale;

        $this->otherCredits = Credit::where('is_payed', false)
            ->join('sales', 'credits.sale_id', '=', 'sales.id')
            ->whereNotIn('sales.type', ['moto', 'simple', 'sing'])
            ->where('sales.client_id', $this->sale->client->id)
            ->where('credits.status', 'active')
            ->select('credits.*')
            ->get();
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

        if ($this->typeSale != 'moto' && $this->typeSale != 'simple' && $this->typeSale != 'sing') {
            if ($this->typeSale == 'two_advance') {
                $value = ($value / 2);
            }elseif ($this->typeSale == 'without_advance') {
                $value = 0;
            }

            if ($val && $this->auth == null) 
            {
                if (($this->otherCredits->sum('amount') + ($this->sale->total - $value)) >= $this->sale->client->client_type->credit) {
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
            }
        }

        return $val;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->other) {
            return json_encode(['El monto máxmimo de crédito para este cliente no puede exceder de: '.number_format($this->sale->client->client_type->credit, 0, ',', '.').' ARS. ', 'auth']);
        }

        if ($this->incorrect) {
            return json_encode(['Por favor, ingrese una clave de usuario superior válida para autorizar; en el siguiente campo:', 'auth']);
        }
    }
}
