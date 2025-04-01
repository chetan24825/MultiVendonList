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
                                    <h4 class="card-title">Payment History</h4>

                                </div>
                                <div class="card-body">
                                    <form action="" method="get">
                                        <div class="d-flex mb-3">
                                            <input type="text" class="form-control me-2"
                                                value="{{ old('search', request('search')) }}"
                                                placeholder="search by UserName, Name....." name="search">

                                            <button type="submit" class="btn btn-primary ms-2">Search</button>
                                        </div>
                                    </form>

                                    <table id="datatable-row-callback"
                                        class="table table-hover table-bordered table-striped dt-responsive nowrap "
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>About</th>
                                                <th>Transaction Id</th>
                                                <th>UTR ID</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($wallet_transaction as $key => $transaction)
                                                <tr>
                                                    <td>{{ $key + 1 + ($wallet_transaction->currentPage() - 1) * $wallet_transaction->perPage() }}
                                                    </td>
                                                    <td>
                                                        @if ($transaction->advertiser->type == 2)
                                                            <em data-bs-toggle="tooltip" style="cursor: pointer;"
                                                                title="{{ $transaction->advertiser->company_name }}">
                                                                {{ Str::limit($transaction->advertiser->company_name, 20, '...') }}
                                                            </em>
                                                        @else
                                                            {{ $transaction->advertiser->first_name }}
                                                            <br>
                                                            <em> {{ $transaction->advertiser->last_name }}</em>
                                                        @endif

                                                    </td>

                                                    <td>
                                                        {{ $transaction->transaction_id }}
                                                    </td>


                                                    <td>
                                                        <em data-bs-toggle="tooltip" style="cursor: pointer;"
                                                            title="{{ $transaction->utr_id }}">
                                                            {{ Str::limit($transaction->utr_id, 40, '...') }}
                                                        </em>
                                                    </td>



                                                    <td>{{ get_setting('symbol') }}{{ $transaction->amount }}</td>

                                                    <td>
                                                        @if ($transaction->advertiser->type == 2)
                                                            <span class="badge bg-info">Company</span>
                                                        @else
                                                            <span class="badge bg-info">Individual</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($transaction->status == 1)
                                                            <span class="badge bg-success">Success</span>
                                                        @elseif($transaction->status == 0)
                                                            <span class="badge bg-warning">Pending</span>
                                                        @else
                                                            <span class="badge bg-danger">Failed</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        {{ $transaction->created_at->diffForHumans() }}
                                                    </td>




                                                    <td>
                                                        @if ($transaction->status == 0)
                                                            <button class="badge badge-success approve"
                                                                data-id="{{ $transaction->id }}">Approved</button>
                                                            <button class="badge badge-danger  reject"
                                                                data-id="{{ $transaction->id }}">Rejected</button>
                                                        @else
                                                            <span class="badge badge-secondary">Done</span>
                                                        @endif


                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $wallet_transaction->links('pagination::bootstrap-5') }}
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
        $(document).ready(function() {
            $('.verify').on('click', async function() {
                let productId = $(this).data('id');

                let result = await Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to Verify . This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#eb220c',
                    cancelButtonColor: '#0069d9',
                    confirmButtonText: 'Yes, Verify Now!',
                });

                if (result.isConfirmed) {
                    try {
                        let response = await fetch(`{{ url('admin/payment/status') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: JSON.stringify({
                                id: productId,
                            })
                        });

                        if (!response.ok) {
                            let errorData = await response.json();
                            throw new Error(errorData.error || 'Failed to Reject');
                        }

                        await Swal.fire('Success!', 'The Request has been Verify.', 'success');
                        location.reload();
                    } catch (error) {
                        console.error(error);
                        let errorMessage = error.message || 'An unexpected error occurred';
                        Swal.fire('Oops...', errorMessage, 'error');
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.reject').on('click', async function() {
                let productId = $(this).data('id');

                let status = 2;

                let result = await Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to Reject . This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#eb220c',
                    cancelButtonColor: '#0069d9',
                    confirmButtonText: 'Yes, Reject Now!',
                });

                if (result.isConfirmed) {
                    try {
                        let response = await fetch(`{{ url('admin/payment/rejected') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: JSON.stringify({
                                id: productId,
                                status: status
                            })
                        });

                        if (!response.ok) {
                            let errorData = await response.json();
                            throw new Error(errorData.error || 'Failed to Reject');
                        }

                        await Swal.fire('Success!', 'The Request has been Rejected.', 'success');
                        location.reload();
                    } catch (error) {
                        console.error(error);
                        let errorMessage = error.message || 'An unexpected error occurred';
                        Swal.fire('Oops...', errorMessage, 'error');
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.approve').on('click', async function() {
                let productId = $(this).data('id');

                let status = 1;

                let result = await Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to Approved . This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4ccc7b',
                    cancelButtonColor: '#0069d9',
                    confirmButtonText: 'Yes, Approved Now!',
                });

                if (result.isConfirmed) {
                    try {
                        let response = await fetch(`{{ url('admin/payment/approved') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: JSON.stringify({
                                id: productId,
                                status: status
                            })
                        });

                        if (!response.ok) {
                            let errorData = await response.json();
                            throw new Error(errorData.error || 'Failed to Approved');
                        }

                        await Swal.fire('Success!', 'The Request has been Approved.', 'success');
                        location.reload();
                    } catch (error) {
                        console.error(error);
                        let errorMessage = error.message || 'An unexpected error occurred';
                        Swal.fire('Oops...', errorMessage, 'error');
                    }
                }
            });
        });
    </script>
@endpush
