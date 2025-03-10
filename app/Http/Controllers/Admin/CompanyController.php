<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advertiser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    function toAdminCompanies()
    {
        $companies = Advertiser::where('type', 2)->get();
        return view('admin.companies.company', compact('companies'));
    }


    public function toggleStatus($storeId)
    {
        $store = Advertiser::find($storeId);
        if ($store) {
            // Toggle the status
            $store->status = $store->status == 1 ? 0 : 1;
            $store->save();

            return response()->json([
                'success' => true,
                'new_status' => $store->status,
            ]);
        }

        return response()->json(['success' => false]);
    }


}
