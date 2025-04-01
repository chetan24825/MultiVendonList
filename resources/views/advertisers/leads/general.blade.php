@extends('advertisers.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                @if (session('success'))
                                    <div class="alert alert-primary">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('warning'))
                                    <div class="alert alert-warning">
                                        {{ session('warning') }}
                                    </div>
                                @endif


                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">List Of User Leads </h4>
                                </div>
                                <div class="card-body">
                                    <form action="" method="get">
                                        <div class="d-flex mb-3">
                                            <input type="text" class="form-control me-2"
                                                value="{{ old('search', request('search')) }}" placeholder="search by name"
                                                name="search">

                                            <button type="submit" class="btn btn-primary ms-2">Search</button>
                                        </div>
                                    </form>

                                    <form action="" method="get">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="date" id="start_date" name="start_date"
                                                    value="{{ request('start_date') }}" class="form-control me-2"
                                                    placeholder="Start Date" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" id="end_date" name="end_date"
                                                    value="{{ request('end_date') }}" class="form-control me-2"
                                                    placeholder="End Date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 m-3">
                                            <button id="filter" class="btn btn-primary">Filter</button>
                                            <a href="{{ route('admin.leads') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User Detail</th>
                                                    <th>Lead Title</th>
                                                    <th>Description</th>
                                                    <th>Range</th>
                                                    <th>Status</th>
                                                    <th>Staging</th>
                                                    <th>Created At</th>
                                                    {{-- <th>Operation</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($leads as $key => $lead)
                                                    <tr>

                                                        <td>
                                                            {{ $key + 1 + ($leads->currentPage() - 1) * $leads->perPage() }}
                                                        </td>


                                                        @if (general_lead_status($lead->id))
                                                            <td>{{ $lead->user->name }}
                                                                <br>
                                                                {{ $lead->user->email }}
                                                            </td>
                                                            <td>{{ $lead->title }} </td>

                                                            <td>{{ Str::limit($lead->description, 30, '...') }}</td>
                                                            <td>
                                                                {{ $lead->start_range }} - {{ $lead->end_range }}
                                                            </td>
                                                        @else
                                                            <td>Buy.... </td>
                                                            <td>Buy.... </td>

                                                            <td>Buy....</td>
                                                            <td>
                                                                Buy....
                                                            </td>
                                                        @endif



                                                        <td>
                                                            @if ($lead->status == 0)
                                                                <span class="badge badge-warning">
                                                                    Draft
                                                                </span>
                                                            @endif
                                                            @if ($lead->status == 1)
                                                                <span class="badge badge-success">
                                                                    Published
                                                                </span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($lead->status_workflow == 0)
                                                                <span class="badge badge-warning">
                                                                    Pending
                                                                </span>
                                                            @endif
                                                            @if ($lead->status_workflow == 1)
                                                                <span class="badge badge-info">
                                                                    Working
                                                                </span>
                                                            @endif

                                                            @if ($lead->status_workflow == 2)
                                                                <span class="badge badge-danger">
                                                                    Rejected
                                                                </span>
                                                            @endif
                                                            @if ($lead->status_workflow == 3)
                                                                <span class="badge badge-success">
                                                                    Completed
                                                                </span>
                                                            @endif


                                                        </td>

                                                        <td>

                                                            <span class="badge badge-success">
                                                                {{ \Carbon\Carbon::parse($lead->created_at)->format('d,M Y') }}
                                                            </span>

                                                        </td>

                                                        <td>
                                                            @if (!general_lead_status($lead->id))
                                                                <button type="button" class="btn btn-success buy-btn"
                                                                    data-id="{{ $lead->id }}">
                                                                    <i class="fas fa-shopping-bag"></i> Buy Now
                                                                </button>
                                                            @endif
                                                        </td>

                                                        {{-- <td>

                                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#editUserModal{{ $lead->id }}">
                                                                <i class="fas fa-pencil-alt"></i> </button>

                                                            <div class="modal fade" id="editUserModal{{ $lead->id }}"
                                                                tabindex="-1"
                                                                aria-labelledby="editUserModalLabel{{ $lead->id }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="editUserModalLabel{{ $lead->id }}">
                                                                                Edit Status
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <form action="{{ route('admin.leads.update') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="id"
                                                                                value="{{ $lead->id }}">
                                                                            <div class="modal-body">
                                                                                <div class="row">

                                                                                    <div class="col-md-12 mb-3">
                                                                                        <label
                                                                                            for="exampleFormControlInput1"
                                                                                            class="form-label">Status
                                                                                            WorkFlow<span
                                                                                                class="text-danger">*</span></label>

                                                                                        <select name="status_workflow"
                                                                                            class="form-control">
                                                                                            <option value="1"
                                                                                                {{ old('status_workflow', $lead->status_workflow) == '1' ? 'selected' : '' }}>
                                                                                                Working</option>
                                                                                            <option value="0"
                                                                                                {{ old('status_workflow', $lead->status_workflow) == '0' ? 'selected' : '' }}>
                                                                                                Pending
                                                                                            </option>

                                                                                            <option value="2"
                                                                                                {{ old('status_workflow', $lead->status_workflow) == '2' ? 'selected' : '' }}>
                                                                                                Rejected
                                                                                            </option>

                                                                                            <option value="3"
                                                                                                {{ old('status_workflow', $lead->status_workflow) == '3' ? 'selected' : '' }}>
                                                                                                Completed
                                                                                            </option>
                                                                                        </select>

                                                                                        @error('status_workflow')
                                                                                            <span class="text-danger"
                                                                                                role="alert">
                                                                                                <strong>{{ ucwords($message) }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-md-6 mb-3">
                                                                                        <label
                                                                                            for="exampleFormControlInput1"
                                                                                            class="form-label">Status<span
                                                                                                class="text-danger">*</span></label>

                                                                                        <select name="status"
                                                                                            class="form-control">
                                                                                            <option value="1"
                                                                                                {{ old('status', $lead->status) == '1' ? 'selected' : '' }}>
                                                                                                Publish</option>
                                                                                            <option value="0"
                                                                                                {{ old('status', $lead->status) == '0' ? 'selected' : '' }}>
                                                                                                Draft
                                                                                            </option>
                                                                                        </select>

                                                                                        @error('status')
                                                                                            <span class="text-danger"
                                                                                                role="alert">
                                                                                                <strong>{{ ucwords($message) }}</strong>
                                                                                            </span>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <!-- Profile Photo -->
                                                                                    <div class="col-md-6">
                                                                                        <label for="browse"
                                                                                            class="form-label">Browse</label>
                                                                                        <div class="input-group"
                                                                                            data-toggle="aizuploader"
                                                                                            data-type="image"
                                                                                            data-multiple="false">
                                                                                            <div
                                                                                                class="input-group-prepend">
                                                                                                <div
                                                                                                    class="input-group-text bg-soft-secondary font-weight-medium">
                                                                                                    Browse </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-control file-amount">
                                                                                                Choose File</div>
                                                                                            <input type="hidden"
                                                                                                name="browse"
                                                                                                value="{{ old('browse', $lead->browse) }}"
                                                                                                class="selected-files custom-file-input">
                                                                                        </div>
                                                                                        <div class="file-preview box sm">
                                                                                        </div>
                                                                                        @error('browse')
                                                                                            <div class="invalid-feedback">
                                                                                                {{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-md-6">
                                                                                        <label for="title"
                                                                                            class="form-label">Title
                                                                                            Name<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input type="text"
                                                                                            name="title" id="title"
                                                                                            class="form-control"
                                                                                            placeholder="Enter Title Name"
                                                                                            value="{{ old('title', $lead->title) }}"
                                                                                            required>
                                                                                        @error('title')
                                                                                            <span
                                                                                                class="text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>


                                                                                    <div class="col-md-6">
                                                                                        <label for="start_range"
                                                                                            class="form-label">Start
                                                                                            Range<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input type="number"
                                                                                            min="0"
                                                                                            name="start_range"
                                                                                            id="start_range"
                                                                                            class="form-control"
                                                                                            placeholder="Enter Start Range"
                                                                                            value="{{ old('start_range', $lead->start_range) }}"
                                                                                            required>
                                                                                        @error('start_range')
                                                                                            <span
                                                                                                class="text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-md-6">
                                                                                        <label for="end_range"
                                                                                            class="form-label">End
                                                                                            Range<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input type="number"
                                                                                            min="0"
                                                                                            name="end_range"
                                                                                            id="end_range"
                                                                                            class="form-control"
                                                                                            placeholder="Enter End Range"
                                                                                            value="{{ old('end_range', $lead->end_range) }}"
                                                                                            required>
                                                                                        @error('end_range')
                                                                                            <span
                                                                                                class="text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div class="col-md-12">
                                                                                        <label for="status"
                                                                                            class="form-label">Description
                                                                                        </label>
                                                                                        <textarea name="description" id="description" class="form-control" cols="4" rows="4">{{ old('description', $lead->description) }}</textarea>
                                                                                    </div>





                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-dark"
                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-success">Update</button>
                                                                                </div>
                                                                            </div>

                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td> --}}


                                                    </tr>
                                                @endforeach



                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-end">
                                    {{ $leads->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.buy-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const leadId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to buy the lead. This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3ac279',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, Buy Now!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`{{ url('advertiser/leads/general/buy') }}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    },
                                    body: JSON.stringify({
                                        lead_id: leadId
                                    })
                                })
                                .then(response => response.json().then(data => ({
                                    status: response.status,
                                    body: data
                                })))
                                .then(({
                                    status,
                                    body
                                }) => {
                                    if (status === 200) {
                                        Swal.fire('Success!', 'Lead has been bought.',
                                                'success')
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire('Error!', body.message ||
                                            'Something went wrong!', 'error');
                                    }
                                })
                                .catch(error => {
                                    Swal.fire('Oops...', error.message ||
                                        'An unexpected error occurred!', 'error');
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush

@push('styles')
    <link href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
@endpush


@push('scripts')
    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/js/pages/datatables-advanced.init.js') }}"></script>
@endpush
