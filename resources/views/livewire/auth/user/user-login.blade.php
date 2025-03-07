<div>
    @section('meta_title'){{ config('app.name') }} User Login @stop
    @section('meta_keywords'){{ config('app.name') }} User Login @stop
    @section('meta_description'){{ config('app.name') }} User Login @stop
    <div class="breadcumb">
        <div class="container">
            <div class="row">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="{{ url()->current() }}">login</a></li>
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
                        <h4 class="mb-3">User Login</h4>


                        <div class="billing-box">
                            <form method="post" action="#" wire:submit.prevent="login">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" wire:model="phone" class=""
                                                placeholder="Enter your Phone Number">
                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group position-relative">
                                            <input type="password" wire:model="user_pin" id="userPinInput"
                                                class="form-control" placeholder="Enter your User Pin">
                                            <span
                                                class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer"
                                                onclick="togglePasswordVisibility()">
                                                <i id="togglePasswordIcon" class="fas fa-eye"></i>
                                            </span>
                                            @error('user_pin')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="d-flex justify-content-between">
                                            <div class="form-check float-left">
                                                <input type="checkbox" wire:model="remember" name="remember"
                                                    id="remember" class="form-check-input">
                                                <label for="remember" class="form-check-label">Remember Me</label>
                                            </div>
                                            <p> <a href="{{ route('forget.password') }}">Forgot Pin ?</a></p>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button class="w-100"> Login</button>
                                </div>
                                <br>

                                <p>Don't have an account? <a href="{{ route('register') }}">Register</a> </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('site-scripts')
    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('userPinInput');
            const icon = document.getElementById('togglePasswordIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endpush
