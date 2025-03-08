<?php

namespace App\Livewire\Auth\Advertiser;

use Livewire\Component;
use App\Models\Advertiser;
use Illuminate\Support\Facades\Auth;

class AdvertiserRegister extends Component
{

    // Otp Configuration
    public $otpSent = false;
    public $response;
    public $otp_orderId;
    public $otp;
    public $phone;

    public $name;


    function otpsend()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'unique:advertisers,phone',
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
            $user = Advertiser::create([
                'name' => $this->name,
                'phone' => $this->phone,
            ]);
            // Auth::guard('advertiser')->login($user);



            // session()->flash('success', 'Register Successfully ');

            return redirect()->route('advertiser.verification', $user->id);
        }
    }
    public function render()
    {
        return view('livewire.auth.advertiser.advertiser-register');
    }
}
