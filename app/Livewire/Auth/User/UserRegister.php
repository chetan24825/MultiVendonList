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


    function otpsend()
    {
        $this->validate([
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
            // 'phone' => [
            //     'required',
            //     'unique:users,phone',
            //     'regex:/^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/',
            // ],
            'otp' => 'required',
        ]);
        $response = verify_and_login_user($this->phone, $this->otp, $this->otp_orderId);
        if (isset($response['success']) && $response['success'] === true && $response['isOTPVerified'] === true) {
            $user = User::create([
                'phone' => $this->phone,
            ]);
            Auth::guard('web')->login($user);
            if (session()->has('redirect_favorite_store_id')) {
                $storeId = session('redirect_favorite_store_id');
                $store = Store::find($storeId);
                if ($store) {
                    $this->addToFavoritesForRegisteredUser($store);
                }

                session()->forget('redirect_favorite_store_id');}

            session()->flash('success', 'Register Successfully ');
            return redirect()->route('user.profile');
        }
    }
    public function addToFavoritesForRegisteredUser($store)
    {
        $attributes = [
            'user_id' => Auth::id(),
            'guard' => current_guard(),
            'seller_id' =>$store->user_id,
            'seller_guard' => $store->guard,
            'store_id' => $store->id,
        ];

        $favourite = Favourite::where($attributes)->first();

        if (!$favourite) {
            Favourite::create($attributes); 
        }
    }

    public function render()
    {
        return view('livewire.auth.user.user-register');
    }
}