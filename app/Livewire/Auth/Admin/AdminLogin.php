<?php

namespace App\Livewire\Auth\Admin;

use App\Models\Admin;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Component
{

    public $phone;
    public $user_pin;
    public $remember = false;

    public function login()
    {
        // Validate the phone and user_pin fields
        $this->validate([
            'phone' => 'required|exists:admins,phone', // Removed "phone" rule since it doesn't exist in Laravel validation rules
            'user_pin' => 'required',
        ]);

        // Check if the user exists and has a status of 1
        $user = Admin::where('phone', $this->phone)->where('status', 1)->first();

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
        if (Auth::guard('admin')->attempt($credentials, $this->remember)) {
            return redirect()->route('admin.dashboard');
        } else {
            session()->flash('error', 'Invalid credentials.');
            return redirect()->back();
        }
    }


    public function render()
    {
        return view('livewire.auth.admin.admin-login');
    }
}
