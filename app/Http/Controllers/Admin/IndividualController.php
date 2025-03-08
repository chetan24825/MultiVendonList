<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndividualController extends Controller
{
    function toAdminIndividual()
    {
        return view('admin.individuals.individual');
    }
}
