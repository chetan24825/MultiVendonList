<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advertiser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndividualController extends Controller
{
    function toAdminIndividual()
    {
        $companies = Advertiser::where('type', 1)->get();
        return view('admin.individuals.individual',compact('companies'));
    }
}
