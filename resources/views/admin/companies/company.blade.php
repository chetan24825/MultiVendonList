@extends('admin.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif


                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h4 class="card-title">Summery Details of Company</h4>

                                </div>
                                <div class="card-body">

                                    <div class="col-md-4">
                                        <div class="d-flex  justify-content-between align-content-end shadow-lg p-3 mb-5">
                                            <div>
                                                <p class="text-muted text-truncate mb-2">Total Companies </p>
                                                <h5 class="mb-0">
                                                    {{ $count }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h4 class="card-title">List Of Company</h4>

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
                                            <a href="{{ route('admin.companies') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </form>

                                    <div class="card-body">
                                        <table id="datatable-row-callback"
                                            class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Company Name</th>
                                                    <th>Phone</th>
                                                    <th>From</th>
                                                    <th>Technology </th>
                                                    <th>Status</th>
                                                    <th>Operation</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($companies as $key => $company)
                                                    <tr>
                                                        <td>{{ $key + 1 + ($companies->currentPage() - 1) * $companies->perPage() }}
                                                        </td>
                                                        <td>

                                                            <em data-bs-toggle="tooltip" style="cursor: pointer;"
                                                                title="{{ $company->company_name }}">
                                                                {{ Str::limit($company->company_name, 40, '...') }}
                                                            </em>

                                                            <br>
                                                            {{ $company->email }}
                                                        </td>

                                                        <td>{{ $company->phone }}</td>
                                                        <td>
                                                            <span class="badge badge-warning">
                                                                {{ $company->data_from }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            @if ($company->technologies)
                                                                {{ technology_name($company->technologies) }}
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
                                                            <a href="{{ route('admin.view', $company->id) }}"
                                                                target="_blank" class="btn btn-sm btn-primary">
                                                                View Now
                                                            </a>
                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {{ $companies->links('pagination::bootstrap-5') }}
                                    </div>
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
