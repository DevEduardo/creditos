<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryDetail extends Model
{

    protected $fillable = ['delivery_id', 'store_inventory_id', 'product_id', 'qty'];

    
    public function delivery ()
    {
    	return $this->belongsTo(Delivery::class);
    }


    public function store_inventory ()
    {
    	return $this->belongsTo(StoreInventory::class);
    }

    
    public function product ()
    {
        return $this->belongsTo(Product::class);
    }	
}
