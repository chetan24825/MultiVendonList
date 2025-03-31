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
                                    <h4 class="card-title">List Of User Message Leads </h4>
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
                                            <a href="{{ route('admin.leads.message') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Url</th>
                                                    <th>User Name</th>
                                                    <th>Phone</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                    <th>Operation</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($leads as $key => $lead)
                                                    <tr>
                                                        <td>
                                                            {{ $key + 1 + ($leads->currentPage() - 1) * $leads->perPage() }}
                                                        </td>

                                                        <td>


                                                            @if ($lead->payment_status == 0)
                                                                Buy first.....
                                                            @else
                                                                <a target="_blank"
                                                                    href="{{ url('/' . $Url . '/' . $lead->url) }}">
                                                                    {{ $lead->advertiser->company_name }}
                                                                </a>
                                                            @endif


                                                        </td>

                                                        <td>
                                                            @if ($lead->payment_status == 0)
                                                                Buy first.....
                                                            @else
                                                                {{ $lead->name }}
                                                                <br>
                                                                {{ $lead->email }}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($lead->payment_status == 0)
                                                                Buy first.....
                                                            @else
                                                                {{ $lead->phone }}
                                                        </td>
                                                @endif
                                                <td>
                                                    @if ($lead->payment_status == 0)
                                                        Buy first.....
                                                    @else
                                                        <em data-bs-toggle="tooltip" style="cursor: pointer;"
                                                            title="{{ $lead->message }}">
                                                            {{ Str::limit($lead->message, 40, '...') }}
                                                        </em>
                                                    @endif
                                                </td>

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
                                                    @if ($lead->status == 3)
                                                        <span class="badge badge-success">
                                                            Completed
                                                        </span>
                                                    @endif

                                                    @if ($lead->status == 2)
                                                        <span class="badge badge-info">
                                                            Working
                                                        </span>
                                                    @endif
                                                </td>


                                                <td>

                                                    <span class="badge badge-success">
                                                        {{ \Carbon\Carbon::parse($lead->created_at)->format('d,M Y') }}
                                                    </span>

                                                </td>
                                                <td>

                                                    @if ($lead->payment_status == 0)
                                                        <button type="button" class="btn btn-success buy-btn"
                                                            data-id="{{ $lead->id }}">
                                                            <i class="fas fa-shopping-bag"></i> Buy Now
                                                        </button>
                                                    @else
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal{{ $lead->id }}">
                                                            <i class="fas fa-pencil-alt"></i> </button>

                                                        <button type="button" class="btn btn-danger delete-btn"
                                                            data-id="{{ $lead->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>

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
                                                                    <form
                                                                        action="{{ route('advertiser.leads.update.message') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $lead->id }}">
                                                                        <div class="modal-body">
                                                                            <div class="row">

                                                                                <div class="col-md-12 mb-3">
                                                                                    <label for="exampleFormControlInput1"
                                                                                        class="form-label">Status<span
                                                                                            class="text-danger">*</span></label>

                                                                                    <select name="status"
                                                                                        class="form-control">
                                                                                        <option value="1"
                                                                                            {{ old('status', $lead->status) == '1' ? 'selected' : '' }}>
                                                                                            Working
                                                                                        </option>
                                                                                        <option value="3"
                                                                                            {{ old('status', $lead->status) == '3' ? 'selected' : '' }}>
                                                                                            Completed
                                                                                        </option>
                                                                                    </select>

                                                                                    @error('status')
                                                                                        <span class="text-danger"
                                                                                            role="alert">
                                                                                            <strong>{{ ucwords($message) }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                </div>





                                                                                <div class="col-md-12">
                                                                                    <label for="status"
                                                                                        class="form-label">Message
                                                                                    </label>
                                                                                    <textarea name="message" id="description" class="form-control" cols="4" rows="4">{{ old('message', $lead->message) }}</textarea>
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
                                                    @endif
                                                </td>
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
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete the user. This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Perform the delete action
                            fetch(`{{ url('advertiser/leads/messages') }}/${userId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute(
                                        'content')
                                }
                            }).then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText);
                                }
                                return response.json();
                            }).then(data => {
                                Swal.fire('Deleted!', 'User has been deleted.',
                                    'success').then(() => {
                                    location.reload();
                                });
                            }).catch(error => {
                                Swal.fire('Oops...', 'Something went wrong!',
                                    'error');
                            });
                        }
                    });
                });
            });
        });
    </script>


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
                            fetch(`{{ url('advertiser/leads/messages/buy') }}`, {
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
    <link href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
@endpush


@push('scripts')
    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/js/pages/datatables-advanced.init.js') }}"></script>
@endpush
