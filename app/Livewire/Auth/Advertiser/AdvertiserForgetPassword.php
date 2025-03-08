<?php

namespace App\Livewire\Auth\Advertiser;

use Livewire\Component;
use App\Models\Advertiser;
use Illuminate\Support\Facades\Auth;

class AdvertiserForgetPassword extends Component
{
    public $phone;
    public $otpSent = false;
    public $response;
    public $otp_orderId;
    public $otp;

    public function mount()
    {
        if (Auth::guard('advertiser')->check()) {
            $this->redirectIntended(route('admin.dashboard'));
        }
    }

    public function login()
    {
        $user = Advertiser::where('phone', $this->phone)->first();
        if ($user && $user->status == 1) {
            $response =  sendOtp($this->phone);
            if (isset($response['success']) && $response['success'] === true) {
                $this->otp_orderId = $response['orderId'];
                $this->otpSent = true;
                session()->flash('success', 'OTP sent successfully.');
                return true;
            }
        } else {
            session()->flash('error', 'Invalid User');
            return redirect()->back();
        }
        session()->flash('error', 'Invalid username or password.');
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.auth.advertiser.advertiser-forget-password');
    }

    public function verifyOtp()
    {
        $response = verify_and_login_user($this->phone, $this->otp, $this->otp_orderId);
        if (isset($response['success']) && $response['success'] === true && $response['isOTPVerified'] === true) {
            $user = Advertiser::where('phone', $this->phone)->first();
            if ($user) {
                Auth::guard('advertiser')->login($user);
                session()->flash('success', 'Successfully logged in.');
                return redirect()->route('advertiser.profile');
            } else {
                session()->flash('error', 'Not found.');
            }
        } else {
            session()->flash('error', 'Invalid OTP.');
        }
    }
}
