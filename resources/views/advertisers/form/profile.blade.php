@extends('advertisers.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header card-header-bordered">
                                <h3 class="card-title">{{ Auth::user()->type == 1 ? 'Individual' : 'Company' }} Profile</h3>
                            </div>
                            <div class="card-body">

                                @if (session()->has('message') || session()->has('error') || session()->has('success'))
                                    <div
                                        class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                                        {{ session('message') ?? (session('error') ?? session('success')) }}
                                    </div>
                                @endif

                                <form class="custom-validation" action="{{ route('advertiser.profile') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        {{-- Check user type --}}
                                        @if (Auth::user()->type == 1)
                                            {{-- Individual Form Fields --}}
                                            <div class="col-md-6 mt-2">
                                                <label class="form-label">First Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="first_name"
                                                    value="{{ old('first_name', auth()->user()->first_name) }}" required />
                                                @error('first_name')
                                                    <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <label class="form-label">Last Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="last_name"
                                                    value="{{ old('last_name', auth()->user()->last_name) }}" required />
                                                @error('last_name')
                                                    <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                                @enderror
                                            </div>
                                        @elseif(Auth::user()->type == 2)
                                            {{-- Company Form Fields --}}
                                            <div class="col-md-6 mt-2">
                                                <label class="form-label">Company Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="company_name"
                                                    value="{{ old('company_name', auth()->user()->company_name) }}"
                                                    required />
                                                @error('company_name')
                                                    <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <label class="form-label">Phone 2</label>
                                                <input type="number" class="form-control" name="phone_2" maxlength="10"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                    value="{{ old('phone_2', auth()->user()->phone2) }}" />
                                                @error('phone_2')
                                                    <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                                @enderror
                                            </div>
                                        @endif

                                        {{-- Common Fields --}}
                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email', auth()->user()->email) }}" />
                                            @error('email')
                                                <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phone" maxlength="10"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                value="{{ old('phone', auth()->user()->phone) }}" required />
                                            @error('phone')
                                                <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Country</label>
                                            <input type="text" class="form-control" name="country"
                                                value="{{ old('country', auth()->user()->country) }}" />
                                            @error('country')
                                                <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">State</label>

                                            <select name="state" class="form-control" id="select2-1">
                                                <option value="">Select State</option>
                                                @foreach ($states->sortBy('name') as $state)
                                                    <option value="{{ $state->name }}"
                                                        @if (auth()->user()->state == $state->name) selected @endif>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('state')
                                                <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">City</label>
                                            <select name="city" class="form-control" id="city-select">
                                                <option value="{{ $cities->id ?? 'Others' }}">{{ $cities->name ?? 'Others' }}</option>
                                            </select>

                                            @error('city')
                                                <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <div class="form-group ">
                                                <label for="signinSrEmail">Select The Profile Image (300x300) </label>

                                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                    data-multiple="false">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            Browse
                                                        </div>
                                                    </div>
                                                    <div class="form-control file-amount">Choose File</div>
                                                    <input type="hidden" name="avatar"
                                                        value="{{ old('avatar', auth()->user()->avatar) }}"
                                                        class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">

                                                </div>

                                                @error('avatar')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ ucwords($message) }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>


                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Technologies</label>
                                            <select id="select2-3" name="technologies[]" multiple="multiple"
                                                class="form-control">
                                                @foreach ($technologies as $tech)
                                                    <option value="{{ $tech->id }}"
                                                        @if (in_array($tech->id, json_decode(auth()->user()->technologies, true) ?? [])) selected @endif>
                                                        {{ $tech->name }}
                                                    </option>
                                                @endforeach
                                            </select>




                                            @error('technologies')
                                                <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                            @enderror
                                        </div>




                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                                            @error('address')
                                                <span class="text-danger"><strong>{{ ucwords($message) }}</strong></span>
                                            @enderror
                                        </div>


                                        {{-- Submit Button --}}
                                        <div class="col-md-12 text-center mt-4">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>

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



                                <form class="custom-validation" action="{{ route('advertiser.password') }}"
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
                </div>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/select2/css/select2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('panel/js/pages/form-select2.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for the Technologies select box
            $('#select2-3').select2({
                placeholder: 'Select Technologies',
                allowClear: true
            });
        });
    </script>

    <script>
        $('#select2-1').change(function() {
            var state = $(this).val();
            $.ajax({
                url: '{{ route('advertiser.getCitiesByState') }}',
                method: 'GET',
                data: {
                    state: state
                },
                success: function(data) {
                    var citySelect = $('#city-select');
                    citySelect.empty();
                    citySelect.append('<option value="">Select District</option>');

                    $.each(data, function(index, city) {
                        citySelect.append('<option value="' + city.id + '">' + city.name +
                            '</option>');
                    });
                    citySelect.append('<option value="10">Others</option>');
                    $('#block-select').empty().append(
                        '<option value="">Select Block</option>' +
                        '<option value="10">Others</option>'
                    );
                },
                error: function(xhr, status, error) {
                    console.log("Error:", error);
                }
            });
        });
    </script>
@endpush
