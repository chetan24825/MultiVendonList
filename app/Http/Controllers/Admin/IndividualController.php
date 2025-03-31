<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Advertiser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndividualController extends Controller
{
    function toAdminIndividual(Request $request)
    {
        $query = Advertiser::where('type', 1);

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

        return view('admin.individuals.individual',compact('companies','count'));
    }
}
