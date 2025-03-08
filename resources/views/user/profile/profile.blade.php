@extends('user.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        @if (session('success'))
                            <div class="alert alert-success" id="success-message">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (!Auth::user()->user_pin || session('forget'))
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header card-header-bordered justify-content-between">
                                        <h3 class="card-title">Epin </h3>

                                    </div>
                                    <div class="card-body">
                                        <form class="row g-3" action="{{ route('user.epin.generate') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="col-md-12">
                                                <label for="name" class="form-label">Enter Pin (Min 6 Character)
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="user_pin" maxlength="6"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6)"
                                                     value="{{ old('user_pin') }}" />
                                                @error('user_pin')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary text-white">Sumbit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-xl-12">
                            <div class="card">

                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Profile

                                    </h4>
                                    <!-- Edit Button on the right -->
                                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editActivityModal">
                                        Edit Profile
                                    </button>
                                </div>


                            </div>

                            <div class="card">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">Full Name</p>
                                                </div>
                                                <div class="col-sm-8">
                                                    <p class="text-muted mb-0">{{ Auth::user()->name }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">Email</p>
                                                </div>
                                                <div class="col-sm-8">
                                                    <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">Phone No..</p>
                                                </div>
                                                <div class="col-sm-8">
                                                    <p class="text-muted mb-0">{{ Auth::user()->phone_2 }}</p>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">State</p>
                                                </div>
                                                <div class="col-sm-8">
                                                    <p class="text-muted mb-0">{{ Auth::user()->state }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">Address</p>
                                                </div>
                                                <div class="col-sm-8">
                                                    <p class="text-muted mb-0">{{ Auth::user()->address }}</p>
                                                </div>
                                            </div>
                                            <hr>


                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">Phone</p>
                                                </div>
                                                <div class="col-sm-8">
                                                    <p class="text-muted mb-0">{{ Auth::user()->phone }}</p>
                                                </div>
                                            </div>



                                            <hr>
                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">City</p>
                                                </div>
                                                <div class="col-sm-8">
                                                    <p class="text-muted mb-0">{{ Auth::user()->city }}</p>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <p class="mb-0">Pin</p>
                                                </div>
                                                <div class="col-sm-8">
                                                    <p class="text-muted mb-0">
                                                        {{ Str::mask(Auth::user()->user_pin, '*', 0, 3) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for Editing profile -->
                                <div class="modal fade" id="editActivityModal" tabindex="-1"
                                    aria-labelledby="editActivityModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editActivityModalLabel">Edit Profile</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Edit Profile Form -->
                                                <form action="{{ route('user.profileupdate') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row mb-3">
                                                        <div class="mb-3">
                                                            <div class="form-group">
                                                                <label for="signinSrEmail">Select The Profile Image</label>
                                                                <div class="input-group" data-toggle="aizuploader"
                                                                    data-type="image" data-multiple="false">
                                                                    <div class="input-group-prepend">
                                                                        <div
                                                                            class="input-group-text bg-soft-secondary font-weight-medium">
                                                                            Browse</div>
                                                                    </div>
                                                                    <div class="form-control file-amount">Choose File</div>
                                                                    <input type="hidden" name="image"
                                                                        value="{{ old('image', $profile->avatar) }}"
                                                                        class="selected-files">
                                                                </div>
                                                                <div class="file-preview box sm"></div>
                                                            </div>
                                                            @error('image')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="full_name" class="form-label">First Name <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="first_name"
                                                                name="full_name" value="{{ $profile->name }}" required>
                                                            @error('full_name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="email" class="form-label">Email </label>
                                                            <input type="email" class="form-control" id="email"
                                                                name="email" value="{{ $profile->email }}">
                                                            @error('email')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="phone" class="form-label">Phone <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="phone"
                                                                maxlength="10"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                                name="phone" value="{{ $profile->phone }}">
                                                            @error('phone')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="phone_2" class="form-label">Mobile</label>
                                                            <input type="text" class="form-control" id="phone_2"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                                maxlength="10" name="phone_2"
                                                                value="{{ $profile->phone_2 }}">
                                                            @error('phone_2')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="user_pin" class="form-label">Pin (Min 6 characters)<span class="text-danger">*</span> </label>
                                                            <input type="text" class="form-control" id="user_pin"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6)"
                                                                maxlength="6"  name="user_pin"
                                                                value="{{ $profile->user_pin }}">
                                                            @error('user_pin')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">


                                                        <div class="col-md-6">
                                                            <label for="state" class="form-label">State</label>
                                                            <input type="text" class="form-control" id="state"
                                                                name="state" value="{{ $profile->state }}">
                                                            @error('state')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="city" class="form-label">City</label>
                                                            <input type="text" class="form-control" id="city"
                                                                name="city" value="{{ $profile->city }}">
                                                            @error('city')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">

                                                        <div class="col-md-12">
                                                            <label for="address" class="form-label">Address</label>

                                                            <textarea name="address" class="form-control" cols="5" rows="5">{{ $profile->address }}</textarea>
                                                            @error('address')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>



                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-dark"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
    @endsection
