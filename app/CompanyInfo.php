<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
	protected $fillable = ['advance', 'interest', 'company_id'];


	public function company ()
	{
		return $this->belongsTo(Company::class);
	}
}
