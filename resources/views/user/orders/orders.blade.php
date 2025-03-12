@extends('user.layouts.app')

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

                                <div class="card-header bg-primary">
                                    <h4 class="card-title text-white">Create Leads</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.order') }}" method="post" class="row g-3">
                                        @csrf

                                        <!-- Withdrawal Amount -->





                                        <div class="col-md-4">
                                            <label for="title" class="form-label">Title Name<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                placeholder="Enter Title Name" value="{{ old('title') }}" required>
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-md-4">
                                            <label for="status" class="form-label">Status<span
                                                    class="text-danger">*</span></label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                                    Publish</option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                    Draft
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Profile Photo -->
                                        <div class="col-md-4">
                                            <label for="browse" class="form-label">Browse</label>
                                            <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                data-multiple="false">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        Browse </div>
                                                </div>
                                                <div class="form-control file-amount">Choose File</div>
                                                <input type="hidden" name="browse" value="{{ old('browse') }}"
                                                    class="selected-files custom-file-input">
                                            </div>
                                            <div class="file-preview box sm"></div>
                                            @error('browse')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="start_range" class="form-label">Start Range<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" min="0" name="start_range" id="start_range"
                                                class="form-control" placeholder="Enter Start Range"
                                                value="{{ old('start_range') }}" required>
                                            @error('start_range')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="end_range" class="form-label">End Range<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" min="0" name="end_range" id="end_range"
                                                class="form-control" placeholder="Enter End Range"
                                                value="{{ old('end_range') }}" required>
                                            @error('end_range')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="status" class="form-label">Description
                                            </label>
                                            <textarea name="description" id="description" class="form-control" cols="4" rows="4">{{ old('description') }}</textarea>
                                        </div>


                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary text-white">
                                                Submit
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">List Of Orders </h4>
                                </div>
                                <div class="card-body">


                                    <table id="datatable-row-callback"
                                        class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Lead Title</th>
                                                <th>Description</th>
                                                <th>Range</th>
                                                <th>Status</th>
                                                <th>Staging</th>
                                                <th>Created At</th>
                                                <th>Operation</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($leads as $key => $lead)
                                                <tr>
                                                    <td>{{ ++$key ?? '' }}</td>

                                                    <td>{{ $lead->title }} </td>

                                                    <td>{{ Str::limit($lead->description, 30, '...') }}</td>
                                                    <td>
                                                        {{ $lead->start_range }} - {{ $lead->end_range }}
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
                                                                    <form action="{{ route('user.order.update') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $lead->id }}">
                                                                        <div class="modal-body">
                                                                            <div class="row">

                                                                                <div class="col-md-6 mb-3">
                                                                                    <label for="exampleFormControlInput1"
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
                                                                                        <div class="input-group-prepend">
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
                                                                                    <div class="file-preview box sm"></div>
                                                                                    @error('browse')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <label for="title"
                                                                                        class="form-label">Title Name<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text" name="title"
                                                                                        id="title"
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
                                                                                        class="form-label">Start Range<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="number" min="0"
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
                                                                                        class="form-label">End Range<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="number" min="0"
                                                                                        name="end_range" id="end_range"
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
                                                    </td>


                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
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
