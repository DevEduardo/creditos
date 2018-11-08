<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Http\Requests\StoreTax;
use App\Http\Requests\UpdateTax;
use Illuminate\Support\Facades\DB;

use Exception;

class Tax extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'value'];


	public function invoice_detail_taxes ()
    {
    	return $this->hasMany(InvoiceDetailTax::class);
    }


	public static function saveData ($request)
	{
	
		try {
			$tax = new self();
			$tax->fill($request->all());
			$tax->save();

        } catch (\Illuminate\Database\QueryException $e) {
        	dd($e);
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar el impuesto");
        }

        return $tax;
	}


	public static function updateData ($request, $id)
	{
		try {
			$tax = tax::findOrFail($id);
			$tax->fill($request->all());
			$tax->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al actualizar los datos");
        }

        return $tax;
	}
}
