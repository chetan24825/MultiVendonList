<div>
    @section('meta_title'){{ config('app.name') }} User Login Forgot Password @stop
    @section('meta_keywords'){{ config('app.name') }} User Login Forgot Password @stop
    @section('meta_description'){{ config('app.name') }} User Login Forgot Password @stop
    <div class="breadcumb">
        <div class="container">
            <div class="row">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="{{ url()->current() }}">Forgot Password</a></li>
                </ul>
            </div>
        </div>
    </div>



    <div class="cart-page">

        <div class="container">
            <div class="row justify-content-center">

                @if (session()->has('message') || session()->has('error') || session()->has('success'))
                    <div
                        class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                        {{ session('message') ?? (session('error') ?? session('success')) }}
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="register">
                        <h4 class="mb-3">{{ !$otpSent ? 'User Forgot Pin' : 'Account Verification of User' }}</h4>


                        <div class="billing-box">
                            <form method="post" action="#"
                                wire:submit.prevent="{{ !$otpSent ? 'login' : 'verifyOtp' }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            @if ($otpSent)
                                                <input type="text" wire:model="otp" placeholder="Please Enter Otp">
                                                @error('otp')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            @endif

                                            <input type="text" wire:model="phone"
                                                class="{{ !$otpSent ? 'd-block' : 'd-none' }}"
                                                placeholder="Enter your Phone Number">
                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="w-100">{{ !$otpSent ? 'Reset Now' : 'SUBMIT' }}</button>
                                </div>
                                <br>
                                <p><a href="{{ route('login') }}">Back To Login</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
