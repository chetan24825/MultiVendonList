@extends('admin.layouts.app')
@section('content')
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
                                <h4 class="card-title text-white">Technology</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.technology') }}" method="post" class="row g-3">
                                    @csrf

                                    <!-- Withdrawal Amount -->
                                    <div class="col-md-4">
                                        <label for="technology" class="form-label">Technology Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="technology" id="technology" class="form-control"
                                            placeholder="Enter Technology Name" value="{{ old('technology') }}" required>
                                        @error('technology')
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
                                        <label for="photo" class="form-label">Image</label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image"
                                            data-multiple="false">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    Browse </div>
                                            </div>
                                            <div class="form-control file-amount">Choose File</div>
                                            <input type="hidden" name="photo"
                                                value="{{ old('photo', auth()->user()->profile_image) }}"
                                                class="selected-files custom-file-input">
                                        </div>
                                        <div class="file-preview box sm"></div>
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
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
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">List Of Technology </h3>
                            </div>

                            <div class="card-body">
                                <table id="datatable-row-callback"
                                    class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Technology Image</th>
                                            <th>Technology Name</th>
                                            <th>Technology Description</th>
                                            <th>Status</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($technologies as $key => $technology)
                                            <tr>
                                                <td>{{ ++$key ?? '' }}</td>

                                                <td>
                                                    <div>
                                                        @if ($technology->image)
                                                            <img src="{{ uploaded_asset($technology->image) }}"
                                                                width="50px"
                                                                class="img-fluid avatar-circle bg-light p-2 border-2 border-primary ml-20">
                                                        @else
                                                            <img src="{{ asset('panel/images/users/avatar-1.png') }}"
                                                                width="50px"
                                                                class="img-fluid avatar-circle bg-light p-2 border-2 border-primary ml-20">
                                                        @endif
                                                    </div>
                                                </td>

                                                <td>{{ $technology->name }}</td>

                                                <td>
                                                    <em data-bs-toggle="tooltip" style="cursor: pointer;"
                                                        title="{{ $technology->description }}">
                                                        {{ Str::limit($technology->description, 40, '...') }}
                                                    </em>
                                                </td>

                                                <td>
                                                    @if ($technology->status == 1)
                                                        <span class="badge badge-success">Publish</span>
                                                    @else
                                                        <span class="badge badge-danger">Draft</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary " data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal{{ $technology->id }}">
                                                        <i class="fas fa-pencil-alt text-white"></i> </button>


                                                    <!-- Edit Modal for each User -->
                                                    <div class="modal fade" id="editUserModal{{ $technology->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editUserModalLabel{{ $technology->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editUserModalLabel{{ $technology->id }}">Edit
                                                                        Technology
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form action="{{ route('admin.technology.update') }}"
                                                                    method="POST">
                                                                    @csrf

                                                                    <input type="hidden" name="id" value="{{ $technology->id }}">
                                                                    <div class="modal-body">
                                                                        <div class="row">

                                                                            <div class="col-md-12 mb-3">
                                                                                <label for="exampleFormControlInput1"
                                                                                    class="form-label">Status<span
                                                                                        class="text-danger">*</span></label>

                                                                                <select name="status"
                                                                                    class="form-control">
                                                                                    <option value="1"
                                                                                        {{ old('status', $technology->status) == '1' ? 'selected' : '' }}>
                                                                                        Active</option>
                                                                                    <option value="0"
                                                                                        {{ old('status', $technology->status) == '0' ? 'selected' : '' }}>
                                                                                        In-Active
                                                                                    </option>
                                                                                </select>

                                                                                @error('status')
                                                                                    <span class="text-danger" role="alert">
                                                                                        <strong>{{ ucwords($message) }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>


                                                                            <div class="col-md-6 mb-3">
                                                                                <label for="name{{ $technology->id }}"
                                                                                    class="form-label">Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="name{{ $technology->id }}"
                                                                                    name="name"
                                                                                    value="{{ $technology->name }}">
                                                                                @error('name')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="col-md-6 mb-3 ">
                                                                                <label for="cryptoaddress"
                                                                                    class="form-label">Image
                                                                                </label>
                                                                                <div class="input-group"
                                                                                    data-toggle="aizuploader"
                                                                                    data-type="image"
                                                                                    data-multiple="false">
                                                                                    <div class="input-group-prepend">
                                                                                        <div
                                                                                            class="input-group-text bg-soft-secondary font-weight-medium">
                                                                                            Browse</div>
                                                                                    </div>
                                                                                    <div class="form-control file-amount">
                                                                                        Choose File</div>
                                                                                    <input type="hidden" name="image"
                                                                                        value="{{ old('image', $technology->image) }}"
                                                                                        class="selected-files">
                                                                                </div>
                                                                                <div class="file-preview box sm"></div>
                                                                            </div>

                                                                            <div class="col-md-12 mb-3">
                                                                                <label
                                                                                    for="Description{{ $technology->id }}"
                                                                                    class="form-label">Description</label>
                                                                                <textarea name="description" class="form-control" id="" cols="30" rows="10">{{ old('description', $technology->description) }}</textarea>
                                                                                @error('description')
                                                                                    <div class="text-danger">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="col-md-6 mb-3">

                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-dark"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">Update</button>
                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <button class="btn btn-danger m-1 delete-btn" id="swal-10"
                                                        data-id="{{ $technology->id }}">Delete</button>
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
    <link href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
@endpush


@push('scripts')
    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/js/pages/datatables-advanced.init.js') }}"></script>
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const sliderId = this.getAttribute('data-id');

                    const result = await Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete . This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(
                                `{{ url('admin/technology/') }}/${sliderId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                });

                            if (!response.ok) throw new Error('Failed to delete');

                            await Swal.fire('Deleted!', 'Package has been deleted.', 'success');
                            location.reload();
                        } catch (error) {
                            Swal.fire('Oops...', 'Something went wrong!', 'error');
                        }
                    }
                });
            });
        });
    </script>
@endpush
