<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Models\Location\Location;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    public function togetCity($id)
    {
        $cities = DB::table('pt_state_cities')->where('state_id', $id)->orderBy('city', 'asc')->get();
        return response()->json($cities);
    }

    public function toStateCityUser($country, $city)
    {
        $Location = Location::where('id', $country)->first();
        if (!$Location) {
            return response()->json(['error' => 'Invalid country'], 404);
        }
        $cities = DB::table('pt_state_cities')
            ->where('city', 'like', $city . '%')
            ->where('state_id', $Location->id)
            ->first();

        if (!$cities) {
            return response()->json(['error' => 'City not found'], 404);
        }

        $citiesPlumber = DB::table('advertisers')
            ->where('city', 'like', $city . '%')
            ->where('state', 'like', $Location->name . '%')
            ->paginate(30);

        return response()->json([
            'cities' => $cities,
            'citiesPlumber' => $citiesPlumber,
            'country' => $country,
            'city' => $city,
            'Location' => $Location,
        ]);
    }
}
