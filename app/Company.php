<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['name', 'slug', 'profile_id'];


	public function profile ()
	{
		return $this->belongsTo(Profile::class);
	}


	public function stores ()
	{
		return $this->hasMany(Store::class);
	}


	public function providers ()
	{
		return $this->hasMany(Provider::class);
	}


	public function invoices ()
	{
		return $this->hasMany(Invoice::class);
	}

	public function users ()
	{
		return $this->hasMany(User::class);
	}

	public function inventories ()
	{
		return $this->hasMany(Inventory::class);
	}


	public function products ()
	{
		return $this->hasMany(Product::class);
	}


	public function sales ()
	{
		return $this->hasMany(Sale::class);
	}	


	public function clients ()
	{
		return $this->hasMany(Client::class);
	}

	public function company_info ()
	{
		return $this->hasOne(CompanyInfo::class);
	}

	public function credit_infos ()
	{
		return $this->hasmany(CreditInfo::class);
	}



	public static function updateData ($request, $id)
	{

		try {
            $company = Company::findOrFail($id);
        } catch (Exception $e) {
            throw_if(true, $e, "Error, la empresa no existe");
        }


        try {
        	
            $profile = Profile::updateProfileFromCompany($request, $company->profile_id);
        } catch (Exception $e) {
            throw_if(true, $e, "Error, al actualizar el perfil");
        }

        try {
			$company->fill($request->all());
			$company->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al editar información de la empresa");
        }

        return $company;
	}
}
