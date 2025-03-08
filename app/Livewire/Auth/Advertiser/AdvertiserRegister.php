<?php

namespace App\Livewire\Auth\Advertiser;

use Livewire\Component;
use App\Models\Role\Advertiser;
use Illuminate\Support\Facades\Auth;

use App\Models\Packages\PackageOrder;
use App\Models\Packages\Package;
class AdvertiserRegister extends Component
{

    // Otp Configuration
    public $otpSent = false;
    public $response;
    public $otp_orderId;
    public $otp;
    public $phone;


    function otpsend()
    {
        $this->validate([
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
            // 'phone' => [
            //     'required',
            //     'unique:advertisers,phone',
            //     'regex:/^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/',
            // ],
            'otp' => 'required',
        ]);
        $response = verify_and_login_user($this->phone, $this->otp, $this->otp_orderId);
        if (isset($response['success']) && $response['success'] === true && $response['isOTPVerified'] === true) {
            $user = Advertiser::create([
                'phone' => $this->phone,
            ]);
            // $freePackage = Package::where('price', 0)->first();
            // if ($freePackage) {
            //     PackageOrder::create([
            //         'user_id' => $user->id,
            //         'order_id' => $freePackage->id,
            //         'package_id' => $freePackage->id,
            //         'package_name' => $freePackage->package_name,
            //         'status' => 1, // Active status
            //         'package_status' => 1, // 1 publish status
            //         'guard' => 'advertiser', // Assuming 'advertiser' is the guard for this user type
            //         'package_details'  => json_encode($freePackage->toArray()),
            //         'created_at' => now(),
            //     ]);
            // }
            Auth::guard('advertiser')->login($user);

            session()->flash('success', 'Register Successfully ');

            return redirect()->route('advertiser.profile');
        }
    }
    public function render()
    {
        return view('livewire.auth.advertiser.advertiser-register');
    }
}
