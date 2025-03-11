@extends('user.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Wallet Section -->
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

                                <div class="card-header bg-primary">
                                    <h4 class="card-title text-white">Withdrawal</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Wallet Balance -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Earning Wallet Balance:</h5>
                                        <h3 class="text-success">
                                            <strong>{{ get_setting('symbol') }}{{ auth()->user()->commission_balance }}</strong>
                                        </h3>
                                    </div>
                                    <hr>


                                    <!-- <hr> -->
                                    @if (!in_array(now()->dayOfWeek, [6, 3, 0]))
                                        <form action="{{ route('user.withdraw') }}" method="post" class="row g-3"
                                            novalidate>
                                            @csrf

                                            <!-- Withdrawal Amount -->
                                            <div class="col-md-6">
                                                <label for="withdrawAmount" class="form-label">Amount</label>
                                                <input type="number" name="amount" id="withdrawAmount"
                                                    class="form-control" placeholder="Enter amount" min="50"
                                                    max="{{ auth()->user()->commission_balance }}"
                                                    value="{{ old('amount') }}" required>
                                                @error('amount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary text-white">Request
                                                    Withdrawal</button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="alert alert-warning">Withdrawals are not allowed on Wednesday, Saturdays and
                                            Sundays.</div>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Transaction History -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary ">
                                    <h4 class="card-title text-white">Withdrawal History</h4>
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
                                            <a href="{{ route('user.withdraw') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </form>
                                    <div class="table-responsive">
                                        <table id="datatable-row-callback" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>

                                                    <th>Arrival Money </th>
                                                    <th>Withdraw Money</th>
                                                    <th>Withdraw Tax</th>

                                                    <th>Created Date</th>
                                                    <th>Status</th>
                                                    <th>Finish Date</th>
                                                    <th>Message</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($withdrawal as $key => $withdraw)
                                                    <tr>
                                                        <td>{{ $key + 1 + ($withdrawal->currentPage() - 1) * $withdrawal->perPage() }}
                                                        </td>

                                                        <td>

                                                            <b>
                                                                {{ get_setting('symbol') }}{{ $withdraw->withdrawal_amount }}
                                                            </b>
                                                        </td>


                                                        <td>
                                                            @if ($withdraw->pay_amount)
                                                                <span class="">
                                                                    {{ get_setting('symbol') }}{{ $withdraw->pay_amount }}
                                                                </span>
                                                            @elseif ($withdraw->status == 2)
                                                                <span class="badge badge-danger">
                                                                    Reject
                                                                </span>
                                                            @elseif ($withdraw->status == 0)
                                                                <span class="badge badge-warning">
                                                                    Pending
                                                                </span>
                                                            @endif

                                                        </td>

                                                        <td>

                                                            @if ($withdraw->charge_amount)
                                                                <span class="text-danger">
                                                                    {{ get_setting('symbol') }}{{ $withdraw->charge_amount }}
                                                                </span>
                                                            @elseif ($withdraw->status == 2)
                                                                <span class="badge badge-danger">
                                                                    Reject
                                                                </span>
                                                            @elseif ($withdraw->status == 0)
                                                                <span class="badge badge-warning">
                                                                    Pending
                                                                </span>
                                                            @endif

                                                        </td>

                                                        <td>
                                                            <span>
                                                                {{ $withdraw->created_at->format('m-D-Y, h:i A') }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            @if ($withdraw->status == 1)
                                                                <span class="text-success">Completed</span>
                                                            @elseif ($withdraw->status == 0)
                                                                <span class="text-warning">Pending</span>
                                                            @elseif ($withdraw->status == 2)
                                                                <span class="text-danger">Reject</span>
                                                            @else
                                                                <span class="text-secondary">Unknown</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span>
                                                                {{ $withdraw->updated_at->format('m-D-Y, h:i A') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <em data-bs-toggle="tooltip" style="cursor: pointer;"
                                                                title="{{ $withdraw->remarks }}">
                                                                {{ Str::limit($withdraw->remarks, 20, '...') }}
                                                            </em>
                                                        </td>

                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- Pagination -->
                                    <div class="mt-3">
                                        {{ $withdrawal->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Transaction History -->
                </div>
            </div>
        </div>
    </div>
@endsection
