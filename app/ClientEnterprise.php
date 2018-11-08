<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientEnterprise extends Model
{
    protected $fillable = ['client_id', 'enterprise_id'];


    public function client ()
    {
    	return $this->belongsTo(Client::class);
    }


    public function enterprise ()
    {
    	return $this->belongsTo(Enterprise::class);
    }
}
