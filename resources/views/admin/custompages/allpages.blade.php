@extends('admin.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-bordered justify-content-between">
                                    <h3 class="card-title">Custom Pages</h3>
                                    <a href="{{ route('admin.custom-page') }}" rel="noopener noreferrer"
                                        class="btn btn-dark">Add New</a>
                                </div>

                                <div class="card-body">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Page Name</th>
                                                <th>Parent Page</th>
                                                <th>Status</th>
                                                <th>Position</th>
                                                <th>Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($custompages as $index => $pages)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ $pages->page_name }}</td>

                                                    <td>
                                                        <strong class="badge badge-info m-l-10 hidden-sm-down">
                                                            {{ $pages->parent->page_name ?? 'Main Page' }}
                                                        </strong>
                                                    </td>

                                                    <td>
                                                        @if ($pages->status == 1)
                                                            <span class="badge bg-success">Publish</span>
                                                        @else
                                                            <span class="badge bg-warning">Draft</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($pages->Show_in == 1)
                                                            <span class="badge bg-info">Header</span>
                                                        @elseif($pages->Show_in == 2)
                                                            <span class="badge bg-info">Both</span>
                                                        @else
                                                            <span class="badge bg-info">Footer</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <a class="btn btn-primary edit-btn"
                                                            href="{{ route('admin.custom-page-edit',$pages->id) }}"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                        <button type="button" class="btn btn-danger delete-btn"
                                                            data-id="{{ $pages->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const pageId = this.getAttribute('data-id');

                    // Confirmation dialog
                    const result = await Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete the Page. This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                    });

                    if (result.isConfirmed) {
                        try {
                            // Make the delete request
                            const response = await fetch(`/admin/custom-pages/delete/${pageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]'
                                    ).getAttribute('content'),
                                },
                            });

                            // Check if the response is okay
                            if (!response.ok) {
                                const errorData = await response.json();
                                throw new Error(errorData.error || 'Failed to delete the Page');
                            }

                            // Success alert
                            await Swal.fire('Deleted!', 'Page has been deleted.', 'success');
                            location.reload();
                        } catch (error) {
                            // Show detailed error message
                            Swal.fire('Oops...', error.message, 'error');
                        }
                    }
                });
            });
        });
    </script>
@endpush
