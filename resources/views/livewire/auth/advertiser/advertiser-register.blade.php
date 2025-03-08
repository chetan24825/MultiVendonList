<div>
    @section('meta_title'){{ config('app.name') }} Advertiser Register @stop
    @section('meta_keywords'){{ config('app.name') }} Advertiser Register @stop
    @section('meta_description'){{ config('app.name') }} Advertiser Register @stop
    <div class="breadcumb">
        <div class="container">
            <div class="row">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="{{ route('advertiser.register') }}">Advertiser</a></li>
                    <li><a href="{{ url()->current() }}">Register</a></li>
                </ul>
            </div>
        </div>
    </div>



    <div class="cart-page">
        <div class="container">
            <div class="row justify-content-center">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('message') || session()->has('error') || session()->has('success'))
                    <div
                        class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                        {{ session('message') ?? (session('error') ?? session('success')) }}
                    </div>
                @endif

                <div class="col-md-6">
                    <div class="register">
                        <h4>{{ !$otpSent ? 'Advertiser Registration' : 'Account Verification of Advertiser' }}</h4>
                        <p></p>
                        <div class="billing-box">
                            <form method="post" wire:submit.prevent="{{ !$otpSent ? 'otpsend' : 'register' }}">
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
                                    <button class="w-100">{{ !$otpSent ? 'Send OTP' : 'SUBMIT' }}</button>
                                </div>
                                <br>
                                <p>Already have an account? <a href="{{ route('advertiser.login') }}">Log in</a> </p>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
