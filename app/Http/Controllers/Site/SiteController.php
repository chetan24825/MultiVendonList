<?php

namespace App\Http\Controllers\Site;

use Inertia\Inertia;
use App\Models\Advertiser;
use Illuminate\Http\Request;
use App\Models\Location\Location;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{


    public function index()
    {
        $table = Location::orderby('name', 'asc')->get();
        return Inertia::render('WebSite/Home', [
            'table' => $table,
        ]);
    }



    function toState()
    {
        $table = Location::orderby('name', 'asc')->get();
        return Inertia::render('WebSite/State', [
            'table' => $table,
        ]);
    }




    function toStateCity($id)
    {
        $Location = Location::where('slug', $id)->first();
        if ($Location) {
            $sortname = $Location->sortname;
            $cities = DB::table('pt_state_cities')
                ->where('state_id', $Location->id)
                ->orderBy('city', 'asc')
                ->get();

            return Inertia::render('City/City', [
                'id' => $id,
                'cities' => $cities,
                'sortname' => $sortname
            ]);
        }

        return redirect()->route('error.404');
    }



    function toStateCityUser($country, $city)
    {
        $Location = Location::where('slug', $country)->firstOrFail();
        $city = str_replace('-', ' ', $city);

        $cities = DB::table('pt_state_cities')
            ->where('city', 'like', $city . '%')
            ->where('state_id', $Location['id'])
            ->first();

        if ($cities) {
            $citiesPlumber = DB::table('advertisers')
                ->where('city', 'like', $city . '%')
                ->where('state', 'like', $Location['name'] . '%')
                ->get();

            // dd($citiesPlumber, $country, $cities->city_slug, $Location->sortname);

            return Inertia::render('City/StateCityUser', [
                'citiesPlumber' => $citiesPlumber,
                'country' => $country,
                'city' => $city,
                'slug' => $cities->city_slug,
                'zipcode' => $cities->zipcode,
                'sortname' => $Location->sortname
            ]);
        }

        return redirect()->route('error.404');
    }



    function toStateCityUserPlumber($country, $city, $plumber)
    {
        dd($country, $city, $plumber);
        $state = Location::where('slug', $country)->pluck('name')->first();
        $city = ucwords(str_replace('-', ' ', $city));

        $plumber = Advertiser::where('company_slug', $plumber)
            ->where('state', $state)
            ->where('city', $city)
            ->firstOrFail();

        return Inertia::render('City/StateCityUserDescription', [
            'country' => $country,
            'city' => $city,
            'plumber' => $plumber
        ]);
    }
}
