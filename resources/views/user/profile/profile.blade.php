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

                        <div class="col-xl-8">
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

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header card-header-bordered">
                                    <h3 class="card-title">
                                        {{ Auth::user()->password == null ? 'Set Password' : 'Change Password' }}
                                    </h3>
                                </div>
                                <div class="card-body">



                                    <form class="custom-validation" action="{{ route('user.password') }}"
                                        method="POST">
                                        @csrf
                                        <div class="row">
                                            {{-- Common Fields --}}
                                            <div class="col-md-12 mt-2">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password"
                                                    value="" />
                                                @error('password')
                                                    <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                                @enderror
                                            </div>


                                            {{-- Submit Button --}}
                                            <div class="col-md-12 text-center mt-4">
                                                <button type="submit"
                                                    class="btn btn-success">{{ Auth::user()->password == null ? 'Set Password' : 'Change Password' }}</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
    @endsection
