<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Delivery extends Model
{
     use SoftDeletes;

	protected $dates = ['deleted_at', 'date', 'updated_at', 'created_at'];

	protected $fillable = ['date', 'observation', 'completed', 'user_id', 'sale_id'];


	public function user ()
	{
		return $this->belongsTo(User::class);
	}


	public function sale ()
	{
		return $this->belongsTo(Sale::class);
	}

	public function delivery_details ()
	{
		return $this->hasMany(DeliveryDetail::class);
	}

  public static function saveDelivery($sale, $user)
  {
      try {

          $delivery = new self();
          $date = new \Carbon\Carbon();

          $delivery->date = $date->format('Y-m-d');
          $delivery->completed = 0;
          $delivery->observation = "N/A";
          $delivery->sale_id = $sale;
          $delivery->user_id = $user;

          $delivery->save();

      } catch (Exception $e) {
          throw_if(true, \Exception::class, "Despacho no almacenado.");
      }

      return $delivery;
  }

  public function scopeOrderDispatch($query, $delivery)
  {
    return $query->select('deliveries.id', 'deliveries.created_at', 'sales.type', 'sales.id AS sID', 'deliveries.created_at', 'clients.name AS client', 'profiles.district', 'profiles.address', 'profiles.between_street')
                ->leftjoin('sales', 'sales.id','=','deliveries.sale_id')
                ->leftJoin('clients', 'clients.id','=','sales.client_id')
                ->leftJoin('profiles', 'profiles.id','=','clients.profile_id')
                ->leftJoin('sale_details', 'sale_details.sale_id','=','sales.id')
                ->where('deliveries.id',$delivery)
                ->first();
  }
}
