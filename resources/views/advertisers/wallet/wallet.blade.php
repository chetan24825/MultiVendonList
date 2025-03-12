@extends('advertisers.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">


                    <form class="row g-3" action="#" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">


                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h2 class="card-title text-white">Wallet Topup</h2>
                                    </div>

                                    <div class="card-body">


                                        <div class="row ">

                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                    @if (get_setting('uploadscanner'))
                                                        <div>
                                                            <img src="{{ uploaded_asset(get_setting('uploadscanner')) }}"
                                                                class="img-thumbnail">
                                                        </div>
                                                    @endif


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Total Balance</p>
                                                        <h5 class="mb-0">
                                                            {{ get_setting('symbol') }}{{ Auth::user()->balance }}</h5>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                    <div>
                                                        <p class="text-muted text-truncate mb-2">Earning Wallet
                                                        </p>
                                                        <h5 class="mb-0">
                                                            {{ get_setting('symbol') }}{{ Auth::user()->commission_balance }}
                                                        </h5>
                                                    </div>

                                                </div>
                                            </div>



                                            <div class="col-md-12">
                                                <br>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="amount" class="form-label mt-12">Amount <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" required id="amount"
                                                    name="amount" value="{{ old('amount') }}" />
                                                @error('amount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success mt-4">Add </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>





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
                                    <h4 class="card-title">Wallet History</h4>

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
                                            <a href="{{ route('advertiser.wallet') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </form>
                                    <table id="datatable-row-callback"
                                        class="table table-hover table-bordered table-striped mt-5 dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Transaction Id</th>
                                                <th>Amount</th>
                                                <th>Verification</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($wallet_transaction as $key => $transaction)
                                                <tr>
                                                    <td>{{ $key + 1 + ($wallet_transaction->currentPage() - 1) * $wallet_transaction->perPage() }}
                                                    </td>
                                                    <td>
                                                        {{ $transaction->transaction_id }}
                                                    </td>

                                                    <td>{{ get_setting('symbol') }}{{ $transaction->amount }}</td>



                                                    <td>
                                                        @if ($transaction->verification_request_user == 0)
                                                            <span class="badge bg-success">Verified</span>
                                                        @elseif ($transaction->verification_request_user == 1)
                                                            <span class="badge bg-info">Processing..</span>
                                                        @endif
                                                    </td>

                                                    <td>

                                                        {{ $transaction->created_at->format('d-M-Y, h:i A') }}
                                                    </td>
                                                    <td>
                                                        @if ($transaction->status == 1)
                                                            <span class="badge bg-success">Success</span>
                                                        @elseif ($transaction->status == 0)
                                                            <span class="badge bg-warning">Pending</span>
                                                        @else
                                                            <span class="badge bg-danger">Failed</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($transaction->verification == 0)
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-info"> <i
                                                                        class=" fas fa-ellipsis-h"></i></button>
                                                                <button type="button"
                                                                    class="btn btn-info dropdown-toggle dropdown-toggle-split"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item verify"
                                                                        href="javascript:void(0)"
                                                                        data-id="{{ $transaction->id }}">Verified
                                                                        Request</a>
                                                                </div>

                                                            </div>
                                                        @else
                                                            <span class="badge bg-secondary">Verified</span>
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
@endpush
