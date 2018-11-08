<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quoting extends Model
{
    protected $fillable = [
    	'type',
    	'share',
    	'percentage'
    ];

    protected $table = 'quoting';
}
