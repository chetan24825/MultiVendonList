<?php

namespace App\Livewire\Auth\User;

use App\Models\Inc\Favourite;
use App\Models\Inc\Store;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserRegister extends Component
{

    // Otp Configuration
    public $otpSent = false;
    public $response;
    public $otp_orderId;
    public $otp;
    public $phone;
    public $store;

    public $name;


    function otpsend()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'unique:users,phone',
                'regex:/^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/',
            ],
        ]);
        $response =  sendOtp($this->phone);
        if (isset($response['success']) && $response['success'] === true) {
            $this->otp_orderId = $response['orderId'];
            $this->otpSent = true;
            session()->flash('success', 'OTP sent successfully.');
            return true;
        } else {
            return false;
        }
    }

    public function register()
    {
        $this->validate([
            'otp' => 'required',
        ]);
        $response = verify_and_login_user($this->phone, $this->otp, $this->otp_orderId);
        if (isset($response['success']) && $response['success'] === true && $response['isOTPVerified'] === true) {
            $password = randompassword(5);

            $user = User::create([
                'phone' => $this->phone,
                'password' => bcrypt($password),
            ]);
            Auth::guard('web')->login($user);
            session()->flash('success', 'Register Successfully ');
            return redirect()->route('user.dashboard');
        }
    }


    public function render()
    {
        return view('livewire.auth.user.user-register');
    }
}
