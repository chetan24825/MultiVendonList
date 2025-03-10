@extends('admin.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!--<div class="row">-->
                    <!--    <div class="col-12">-->
                    <!--        <div class="page-title-box d-flex align-items-center justify-content-between">-->
                    <!--            <h4 class="mb-sm-0">Home</h4>-->
                    <!--            <div class="page-title-right">-->
                    <!--                <ol class="breadcrumb m-0">-->
                    <!--                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>-->
                    <!--                    <li class="breadcrumb-item active">Users</li>-->
                    <!--                </ol>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->

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

                                <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Users Table</h4>
                                <a href="#" class="btn btn-light">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                                <div class="card-body">
                                    <table id="datatable-row-callback"
                                        class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $index => $user)
                                                <tr>
                                                    <td>
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>
                                                        @if ($user->status == 1)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>

                                                    <td>{{ $user->created_at->format('d M, Y') }}</td>

                                                    <td>
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal{{ $user->id }}">
                                                            <i class="fas fa-pencil-alt"></i> </button>




                                                        <button type="button" class="btn btn-danger delete-btn"
                                                            data-id="{{ $user->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                        <a href="{{ route('admin.user.view', $user->id) }}" target="blank"
                                                            class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal for each User -->
                                                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                                    aria-labelledby="editUserModalLabel{{ $user->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editUserModalLabel{{ $user->id }}">Edit User
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('admin.users.update', $user->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row">

                                                                        <div class="col-md-12 mb-3">
                                                                            <label for="exampleFormControlInput1"
                                                                                class="form-label">Status<span
                                                                                    class="text-danger">*</span></label>

                                                                            <select name="status" class="form-control">
                                                                                <option value="1"
                                                                                    {{ old('status', $user->status) == '1' ? 'selected' : '' }}>
                                                                                    Active</option>
                                                                                <option value="0"
                                                                                    {{ old('status', $user->status) == '0' ? 'selected' : '' }}>
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
                                                                            <label for="name{{ $user->id }}"
                                                                                class="form-label">Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="name{{ $user->id }}" name="name"
                                                                                value="{{ $user->name }}">
                                                                            @error('name')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="email{{ $user->id }}"
                                                                                class="form-label">Email</label>
                                                                            <input type="email" class="form-control"
                                                                                id="email{{ $user->id }}"
                                                                                name="email" value="{{ $user->email }}">
                                                                            @error('email')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="phone{{ $user->id }}"
                                                                                class="form-label">Phone</label>
                                                                            <input type="text" class="form-control"
                                                                                id="phone{{ $user->id }}"
                                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                                                maxlength="10"
                                                                                name="phone" value="{{ $user->phone }}">
                                                                            @error('phone')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center mt-4">
                                        {{-- {{ $users->links('pagination::bootstrap-5') }} --}}
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
                            fetch(`{{ url('admin/user-delete') }}/${userId}`, {
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
