<?php

namespace App\Http\Controllers\Basic;

use Carbon\Carbon;
use App\Models\Inc\Lead;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserLeadsController extends Controller
{
    public function toAdminLeads(Request $request)
    {
        $query = Lead::query();

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        // Date Range Filter (Only apply if at least one date is provided)
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
            $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($startDate) {
                $query->where('created_at', '>=', $startDate);
            } else {
                $query->where('created_at', '<=', $endDate);
            }
        }

        $count = $query->count();
        $leads = $query->orderByDesc('id')->paginate(10);

        return view('admin.leads.general', compact('leads', 'count'));
    }

    function toUpdateOrder(Request $request)
    {

        $request->validate([
            "id"          => "required|numeric",
            "title"       => "required|string|max:255",
            "status"      => "required|in:0,1",
            "browse"      => "nullable|string",
            "start_range" => "required|numeric|min:0",
            "end_range"   => "required|numeric|gt:start_range",
            "description" => "nullable|string",
            'status_workflow'=> "required|in:0,1,2,3",
        ]);

        $order = Lead::find($request->id);
        $order->title = $request->title;
        $order->status_workflow = $request->status_workflow;
        $order->title_slug = Str::slug($request->title);
        $order->status = $request->status;
        $order->browse = $request->browse;
        $order->start_range = $request->start_range;
        $order->end_range = $request->end_range;
        $order->description = $request->description;
        if ($order->save()) {
            return redirect()->back()->with('success', 'Order updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Order updated failed.');
        }
    }
}
