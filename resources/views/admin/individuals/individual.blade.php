@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

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


                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">List Of Individual </h3>
                            </div>

                            <div class="card-body">
                                <table id="datatable-row-callback"
                                    class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Phone</th>
                                            <th>Technology </th>
                                            <th>Status</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($companies as $company)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $company->first_name }} {{ $company->last_name }}
                                                    <br>
                                                    {{ $company->email }}
                                                </td>

                                                <td>{{ $company->phone }}</td>

                                                <td>
                                                    @if ($company->technologies)
                                                        {{ technology_name($company->technologies) }}
                                                    @else
                                                        <span class="badge badge-danger">No Technology</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    <button id="status-button-{{ $company->id }}"
                                                        class="btn btn-sm btn-success"
                                                        onclick="toggleStoreStatus({{ $company->id }})">
                                                        Active
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.view', $company->id) }}" target="_blank"
                                                        class="btn btn-sm btn-primary">
                                                        View Now
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
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
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>




    <script>
        function toggleStoreStatus(storeId) {
            // Send an AJAX request to the backend to toggle the status
            fetch(`/admin/companies/${storeId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        store_id: storeId
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update the button appearance based on the new status
                        const button = document.getElementById(`status-button-${storeId}`);
                        if (data.new_status == 1) {
                            button.classList.remove('btn-danger');
                            button.classList.add('btn-success');
                            button.textContent = 'Active';
                        } else {
                            button.classList.remove('btn-success');
                            button.classList.add('btn-danger');
                            button.textContent = 'Inactive';
                        }
                    } else {
                        alert('Failed to update store status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating status.');
                });
        }
    </script>
@endpush
