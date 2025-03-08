<?php

use Otpless\OTPLessAuth;
use App\Models\Inc\Upload;
use Illuminate\Support\Str;
use App\Models\Inc\BusinessSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $setting = BusinessSetting::where('type', $key)->first();
        return $setting == null ? $default : $setting->value;
    }
}

if (!function_exists('verify_and_login_user')) {
    function verify_and_login_user($username, $otp, $otp_orderId)
    {
        $clientId = env('OTPLESS_CLIENT_ID');
        $clientSecret = env('OTPLESS_CLIENT_SECRET');
        $otpless = new OtplessAuth();
        $phone = '91' . $username;

        try {
            $res = $otpless->verifyOtp($phone, '', $otp_orderId, $otp, $clientId, $clientSecret);
            $response = json_decode($res, true);
            return $response;
        } catch (\Exception $e) {
            return 'Error verifying OTP: ' . $e->getMessage();
        }
    }
}


if (!function_exists('sendOtp')) {
    function sendOtp($phone)
    {
        $clientId = env('OTPLESS_CLIENT_ID');
        $clientSecret = env('OTPLESS_CLIENT_SECRET');
        $otpLength = 4;
        $orderId = now()->format('YmdHis');
        $phone = '91' . $phone;
        try {
            $otpless = new OtplessAuth(); // Initialize it here
            $res = $otpless->sendOtp($phone, "", $orderId, "", "", $clientId, $clientSecret, $otpLength, "SMS");
            $response = json_decode($res, true);
            if (isset($response['success']) && $response['success'] === true) {
                session()->flash('message', 'OTP Sent Successfully On Phone.');
                return  $response;
            } else {
                session()->flash('error', 'Failed to send OTP.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while sending OTP: ' . $e->getMessage());
            return false;
        }
    }
}


if (!function_exists('current_guard')) {
    function current_guard()
    {
        $request = request();

        // Check if the user is authenticated with the admin guard or is accessing an admin URL
        if ($request->is('admin/*') && Auth::guard('admin')->check()) {
            return 'admin';
        }

        // Check if the user is authenticated with the advertiser guard or is accessing an advertiser URL
        if ($request->is('advertiser/*') && Auth::guard('advertiser')->check()) {
            return 'advertiser';
        }

        // Check if the user is authenticated with the agent guard or is accessing an agent URL
        if ($request->is('agent/*') && Auth::guard('agent')->check()) {
            return 'agent';
        }

        // Check if the user is authenticated with the web guard
        if (Auth::guard('web')->check()) {
            return 'web';
        }

        return null; // Return null if no guards are authenticated
    }
}


if (!function_exists('isHttps')) {
    function isHttps()
    {
        return !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
    }
}

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = (isHttps() ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        return $root;
    }
}

if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        return getBaseURL() . 'public/';
    }
}


if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return Storage::disk('s3')->url($path);
        } else {
            return app('url')->asset($path, $secure);
            // return app('url')->asset('public/' . $path, $secure);
        }
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = Upload::find($id)) != null) {
            return my_asset($asset->file_name);
        }
        return null;
    }
}

if (!function_exists('randompassword')) {
    function randompassword($number = 5)
    {
        $randomNumber = str_pad(mt_rand(0, pow(10, $number) - 1), $number, '0', STR_PAD_LEFT);
        return $randomNumber;
    }
}
