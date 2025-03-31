<?php

namespace App\Http\Controllers\Basic;

use Carbon\Carbon;
use App\Models\Inc\Lead;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inc\MessageLead;

class UserLeadsController extends Controller
{
    public function toAdminLeads(Request $request)
    {
        $query = Lead::with('user');

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

    public function toAdminLeadMessage(Request $request)
    {
        $query = MessageLead::with('advertiser');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
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

        $Url = get_setting('custom_slug');

        return view('admin.leads.message', compact('leads', 'Url', 'count'));
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
            'status_workflow' => "required|in:0,1,2,3",
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


    function toUpdateMessage(Request $request)
    {
        $request->validate([
            "id"       => "required|exists:message_leads,id",

            "status"    => "required|numeric|in :0,1",
            "message"   => "nullable|string",
        ]);

        $order = MessageLead::find($request->id);
        $order->status = $request->status;
        $order->lead_type = $request->lead_type;
        $order->message = $request->message;
        if ($order->save()) {
            return redirect()->back()->with('success', 'Order updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Order updated failed.');
        }
    }


    function toDeleteMessage($id)
    {
        $user = MessageLead::findOrFail($id);
        if ($user->delete()) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
