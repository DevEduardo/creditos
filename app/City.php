<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'postal_code', 'state_id'];


    public function state ()
    {
    	return $this->belongsTo(State::class);
    }

    public function profile ()
    {
    	return $this->hasOne(Profile::class);
    }
}
