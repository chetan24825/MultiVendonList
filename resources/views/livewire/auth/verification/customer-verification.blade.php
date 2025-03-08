<div>
    @section('meta_title'){{ config('app.name') }} Customer Detail @stop
    @section('meta_keywords'){{ config('app.name') }} Customer Detail @stop
    @section('meta_description'){{ config('app.name') }} Customer Detail @stop
    <div class="breadcumb">
        <div class="container">
            <div class="row">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="{{ url()->current() }}">Customer Detail</a></li>
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
                        <h4 class="mb-5">Customer Detail</h4>

                        <div class="billing-box">
                            <div>
                                <form method="post" wire:submit.prevent="save">
                                    <!-- Type Selection -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <select wire:model="type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="1">Individual</option>
                                                <option value="2">Company</option>
                                            </select>
                                            @error('type')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Individual Fields -->
                                    <div x-data="{ type: @entangle('type') }">
                                        <div x-show="type == '1'">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <input type="text" wire:model="first_name" class="form-control"
                                                        placeholder="First Name">
                                                    @error('first_name')
                                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" wire:model="last_name" class="form-control"
                                                        placeholder="Last Name">
                                                    @error('last_name')
                                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <input type="text" wire:model="phone" class="form-control"
                                                        placeholder="Phone">
                                                    @error('phone')
                                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <input type="email" wire:model="email" class="form-control"
                                                        placeholder="Email">
                                                    @error('email')
                                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Company Fields -->
                                        <div x-show="type == '2'">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <input type="text" wire:model="company_name" class="form-control"
                                                        placeholder="Company Name">
                                                    @error('company_name')
                                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" wire:model="email" class="form-control"
                                                        placeholder="Email">
                                                    @error('email')
                                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <input type="text" wire:model="phone" class="form-control"
                                                        placeholder="Phone">
                                                    @error('phone')
                                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <input type="text" wire:model="phone2" class="form-control"
                                                        placeholder="Phone 2">
                                                    @error('phone2')
                                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Common Fields -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <input type="text" wire:model="country" class="form-control"
                                                    placeholder="Country">
                                                @error('country')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <select wire:model.defer="state" wire:change="loadCities"
                                                    class="form-control">
                                                    <option value="">Select State</option>
                                                    @foreach ($allState as $stateOption)
                                                        <option value="{{ $stateOption->id }}">
                                                            {{ $stateOption->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('state')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="col-md-6 mt-3">
                                                <select wire:model="city" class="form-control">
                                                    <option value="">Select City</option>
                                                    @foreach ($allCity as $cityOption)
                                                        <option value="{{ $cityOption->id }}">{{ $cityOption->name }}
                                                        </option>
                                                    @endforeach
                                                    <option value="10">Others </option>
                                                </select>
                                                @error('city')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <textarea wire:model="address" class="form-control" placeholder="Address" rows="4"></textarea>
                                                @error('address')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <button class="btn btn-primary w-100">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
