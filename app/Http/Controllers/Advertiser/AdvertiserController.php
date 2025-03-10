<?php

namespace App\Http\Controllers\Advertiser;

use Illuminate\Http\Request;
use App\Models\Location\City;
use App\Models\Location\State;
use App\Http\Controllers\Controller;
use App\Models\Inc\Technology;
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
        $states = State::get();
        $cities = City::where('id', Auth::user()->city)->first();
        $technologies = Technology::get();
        return view('advertisers.form.profile', compact('states', 'cities', 'technologies'));
    }

    public function toAdvertiserprofileUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'   => 'nullable|string|max:50',
            'last_name'    => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:100',
            'email'        => 'nullable|email|max:100',
            'phone'        => 'required|digits:10',
            'phone_2'      => 'nullable|digits:10',
            'country'      => 'nullable|string|max:50',
            'state'        => 'nullable|exists:states,id',
            'city'         => 'nullable|exists:cities,id',
            'avatar'       => 'nullable|string',
            'address'      => 'nullable|string|max:255',
        ]);

        // Get authenticated user
        $user = Auth::user();

        // Check user type and update fields accordingly
        if ($user->type == 1) { // Individual
            $user->first_name = $validatedData['first_name'];
            $user->last_name = $validatedData['last_name'];
        } elseif ($user->type == 2) { // Company
            $user->company_name = $validatedData['company_name'];
            $user->phone2 = $validatedData['phone_2'];
        }

        // Update common fields
        $user->email = $validatedData['email'] ?? $user->email;
        $user->phone = $validatedData['phone'];
        $user->country = $validatedData['country'] ?? $user->country;
        $user->state = $validatedData['state'] ?? $user->state;
        $user->city = $validatedData['city'] ?? $user->city;
        $user->avatar = $validatedData['avatar'] ?? $user->avatar;
        $user->address = $validatedData['address'] ?? $user->address;
        $user->technologies = $request['technologies'] ?? $user->technologies;


        // Save the updated user data
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function toAdvertiserprofileChangePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        // Get authenticated user
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
