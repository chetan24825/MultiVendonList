@extends('advertisers.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-header-bordered">
                        <h3 class="card-title">Profile</h3>
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

                                <div class="col-md-6 mt-2">
                                    <label for="exampleFormControlInput1" class="form-label">Full Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="exampleFormControlInput1"
                                        placeholder="" value="{{ old('name', auth()->user()->name) }}" required />
                                    @error('name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ ucwords($message) }}</strong>
                                        </span>
                                    @enderror
                                </div>



                                <div class="col-md-6 mt-2">
                                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="exampleFormControlInput2"
                                        placeholder="" value="{{ old('email', auth()->user()->email) }}" />
                                    @error('email')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ ucwords($message) }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="exampleFormControlInput1" class="form-label">Phone <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="phone" maxlength="10"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                        value="{{ old('phone', auth()->user()->phone) }}" id="exampleFormControlInput3"
                                        placeholder="" />
                                    @error('phone')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ ucwords($message) }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="exampleFormControlInput1" class="form-label">Phone 2</label>
                                    <input type="number" class="form-control" name="phone_2" maxlength="10"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                        value="{{ old('phone_2', auth()->user()->phone_2) }}" id="exampleFormControlInput3"
                                        placeholder="" />
                                    @error('phone_2')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ ucwords($message) }}</strong>
                                        </span>
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
                                                value="{{ old('avatar', auth()->user()->avatar) }}" class="selected-files">
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

                                <div>
                                    <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                                    @error('address')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ ucwords($message) }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="btn-group btn-group-lg mb-2 mt-4">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Define a reusable function to fetch agent details
            function fetchAgentDetails(agentCode) {
                let csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token for security

                // Clear any previous message
                $('#agent-code-error').text("");

                // Prepare data for the AJAX request
                let requestData = {
                    code: agentCode // Send the agent code to the server
                };

                // Perform the AJAX request
                $.ajax({
                    url: "/advertiser/agent/detail", // Replace with your actual endpoint
                    type: "POST",
                    data: requestData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Add CSRF token to request headers
                    },
                    success: function(response) {
                        if (response.success) {
                            const agent = response
                                .data; // Assuming `response.data` contains user details

                            // Display agent details in a success message
                            $('#agent-code-error')
                                .html(`<strong>Agent Name:</strong> ${agent.name || 'N/A'}`)
                                .removeClass('text-danger')
                                .addClass('text-success');
                        } else {
                            $('#agent-code-error')
                                .text("Failed to retrieve details: " + (response.message ||
                                    "Unknown error"))
                                .removeClass('text-success')
                                .addClass('text-danger');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#agent-code-error')
                            .text("An error occurred while retrieving agent details.")
                            .removeClass('text-success')
                            .addClass('text-danger');
                    }
                });
            }

            // Call the function on change event
            $(document).on("change", "#agent-code", function() {
                let agentCode = $(this).val(); // Get the value of the agent code
                if (agentCode) {
                    fetchAgentDetails(agentCode);
                }
            });

            // Call the function on page load if the agent code input has a value
            let initialAgentCode = $("#agent-code").val();
            if (initialAgentCode) {
                fetchAgentDetails(initialAgentCode);
            }
        });
    </script>
@endpush
