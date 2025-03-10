<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use App\Models\Location\City;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function getCitiesByState(Request $request)
    {
        $state = $request->state;
        $cities = City::where('state_id', $state)->get();
        return response()->json($cities);
    }
}
