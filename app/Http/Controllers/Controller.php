<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Response;

use App\City;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getCities($id) {
        $cities = City::orderBy("name", "ASC")->where("state_id",$id)->pluck("name","id");

        return response()->json($cities);

    }


    public function getPostalCode ($city_id)
    {
    	$postal_code = City::find($city_id);

        return response()->json($postal_code);

    }
}
