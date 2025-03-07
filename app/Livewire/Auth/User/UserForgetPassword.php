<?php

namespace App\Livewire\Auth\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserForgetPassword extends Component
{

    public $phone;
    public $otpSent = false;
    public $response;
    public $otp_orderId;
    public $otp;

    public function mount()
    {
        if (Auth::guard('web')->check()) {
            $this->redirectIntended(route('admin.dashboard'));
        }
    }

    public function login()
    {
        $user = User::where('phone', $this->phone)->first();
        if ($user && $user->status == '1') {
            $response =  sendOtp($this->phone);
            if (isset($response['success']) && $response['success'] === true) {
                $this->otp_orderId = $response['orderId'];
                $this->otpSent = true;
                session()->flash('success', 'OTP sent successfully.');
                return true;
            }
        } else {
            session()->flash('error', 'Invalid User');
            return redirect()->route('login'); // Adjust this route as needed;
        }
        session()->flash('error', 'Invalid username or password.');
        return redirect()->route('login'); // Adjust this route as needed;
    }


    public function render()
    {
        return view('livewire.auth.user.user-forget-password');
    }

    public function verifyOtp()
    {
        $response = verify_and_login_user($this->phone, $this->otp, $this->otp_orderId);
        if (isset($response['success']) && $response['success'] === true && $response['isOTPVerified'] === true) {
            $user = User::where('phone', $this->phone)->first();
            if ($user) {
                Auth::guard('web')->login($user);
                session()->flash('success', 'Successfully logged in.');
                return redirect()->route('user.profile')->with('forget', 'Successfully logged in.');
            } else {
                session()->flash('error', 'User not found.');
            }
        } else {
            session()->flash('error', 'Invalid OTP.');
        }
    }
}
