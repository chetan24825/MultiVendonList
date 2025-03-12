<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Advertiser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function toAdminCompanies(Request $request)
    {
        $query = Advertiser::where('type', 2);

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('company_name', 'like', "%{$search}%");
        }

        // Date Range Filter - Only apply if at least one date is provided
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
            $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($startDate) {
                $query->where('created_at', '>=', $startDate);
            } elseif ($endDate) {
                $query->where('created_at', '<=', $endDate);
            }
        }
        $count = $query->count();

        $companies = $query->orderByDesc('id')->paginate(10);



        // dd($companies);

        return view('admin.companies.company', compact('companies', 'count'));
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
