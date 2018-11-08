<?php
namespace App\Observers;

use App\Store;

class StoreObserver
{
	public function deleted(Store $store)
	{
		$store->load('store_inventories');

		if ($store->store_inventories->count() > 0) {
			$store->store_inventories->each(function ($inventory) {
				$inventory->delete();
			});
		}
	}
}