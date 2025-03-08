<?php

namespace App\Livewire\Auth\Advertiser;

use Livewire\Component;
use App\Models\Advertiser;
use Illuminate\Support\Facades\Auth;


class AdvertiserLogin extends Component
{

    public $phone;
    public $user_pin;
    public $remember = false;

    public function login()
    {
        // Validate the phone and user_pin fields
        $this->validate([
            'phone' => 'required|exists:advertisers,phone', // Removed "phone" rule since it doesn't exist in Laravel validation rules
            'user_pin' => 'required',
        ]);

        // Check if the user exists and has a status of 1
        $user = Advertiser::where('phone', $this->phone)->where('status', 1)->first();

        if (!$user) {
            session()->flash('error', 'Your account is inactive or does not exist.');
            return redirect()->back();
        }

        // Prepare the credentials
        $credentials = [
            'phone' => $this->phone,
            'password' => $this->user_pin,
        ];

        // Attempt login
        if (Auth::guard('advertiser')->attempt($credentials,$this->remember)) {
            return redirect()->route('advertiser.dashboard');
        } else {
            session()->flash('error', 'Invalid credentials.');
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.auth.advertiser.advertiser-login');
    }
}
