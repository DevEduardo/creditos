<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    
    protected $fillable = ['name'];

	
	public function profile ()
	{
		return $this->hasOne(Profile::class);
	}

	public function cities ()
	{
		return $this->hasMany(City::class);
	}

}
