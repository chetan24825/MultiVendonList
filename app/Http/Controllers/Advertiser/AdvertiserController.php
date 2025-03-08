<?php

namespace App\Http\Controllers\Advertiser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdvertiserController extends Controller
{
    function toAdvertiserDashboard()
    {
        return view('advertisers.home.dashboard');
    }


    // --------------------------------------------------------------------------------------------------
    // ---------------------------------------------Profile Link--------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------


    function toAdvertiserprofile()
    {
        return view('advertisers.form.profile');
    }

    function toAdvertiserprofileUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:advertisers,email,' . Auth::id(),
            'phone' => 'required|numeric|digits:10',
            'phone_2' => 'nullable|numeric|digits:10',
            'avatar' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'user_pin' => 'required|string|min:6',
            // 'agent_code' => 'nullable|exists:agents,agent_code',
        ]);

        if (Auth::user()->agent_code || $request->agent_code != null) {
            $validatedData['agent_code_status'] = 1;
        }
        $validatedData['user_pin'] = $request->user_pin;
        $validatedData['password'] = Hash::make($request->user_pin);
        if (auth()->user()->update($validatedData)) {
            return redirect()->back()->with('success', 'Updated successfully.');
        }
    }
}
