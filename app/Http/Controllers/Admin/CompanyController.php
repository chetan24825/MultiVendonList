<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    function toAdminCompanies()
    {
        return view('admin.companies.company');
    }
}
