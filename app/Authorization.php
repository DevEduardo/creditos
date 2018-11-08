<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $fillable = [
        'fees',
    	'token_id',
    	'sale_id'
    ];

    public function sale()
    {
    	return $this->belongsTo(Sale::class);
    }

    public function token()
    {
    	return $this->belongsTo(Token::class);
    }
}
