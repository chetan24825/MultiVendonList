@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    @if (session()->has('message') || session()->has('error') || session()->has('success'))
                        <div
                            class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                            {{ session('message') ?? (session('error') ?? session('success')) }}
                        </div>
                    @endif
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">

                                <h3 class="card-title">Create Pages</h3>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" action="{{ route('admin.custom-page') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="state_id" class="form-label">Select Page <span
                                                class="text-danger">*</span></label>
                                        <select name="parent_id" id="select2-1" class="form-control">
                                            <option value="0"{{ old('parent_id') == '0' ? 'selected' : '' }}>
                                                --Parent</option>
                                            @foreach ($custompages as $pages)
                                                <option
                                                    value="{{ $pages->id }}"{{ old('parent_id') == $pages->id ? 'selected' : '' }}>
                                                    {{ $pages->page_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="col-md-6">
                                        <label for="blockName" class="form-label">Page Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="page_name"
                                            value="{{ old('page_name') }}">
                                        @error('page_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="blockName" class="form-label">Status<span
                                                class="text-danger">*</span></label>
                                        <select name="status" class="form-control">
                                            <option value="1"{{ old('status') == 1 ? 'Selected' : '' }}>Publish
                                            </option>
                                            <option value="0"{{ old('status') == 0 ? 'Selected' : '' }}>Draft</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">

                                        <label for="blockName" class="form-label">Show In<span
                                                class="text-danger">*</span></label>
                                        <select name="Show_in" class="form-control">
                                            <option value="0"{{ old('Show_in') == 0 ? 'Selected' : '' }}>Footer
                                            </option>
                                            <option value="1"{{ old('Show_in') == 1 ? 'Selected' : '' }}>Header
                                            </option>
                                            <option value="2"{{ old('Show_in') == 2 ? 'Selected' : '' }}>Both
                                            </option>

                                        </select>
                                        @error('Show_in')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="blockName" class="form-label">Select The Banner Image</label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    Browse</div>
                                            </div>
                                            <div class="form-control file-amount">
                                                Choose File</div>
                                            <input type="hidden" name="banner" value="{{ old('banner') }}" class="selected-files">
                                        </div>
                                        <div class="file-preview box sm"></div>
                                        @error('banner')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="blockName" class="form-label">Priority<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="priority"
                                            value="{{ old('priority', 1000) }}">
                                        @error('priority')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-12">
                                        <label for="blockName" class="form-label">Page Description<span
                                                class="text-danger">*</span></label>

                                        <textarea id="basic-example" name="page_desc" class="form-control">{{ old('page_desc') }}</textarea>

                                        @error('page_desc')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="blockName" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title"
                                            value="{{ old('meta_title') }}">
                                        @error('meta_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="blockName" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keyword"
                                            value="{{ old('meta_keyword') }}">
                                        @error('meta_keyword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-12">
                                        <label for="blockName" class="form-label">Meta Description</label>
                                        <textarea class="form-control" name="meta_description" cols="4" rows="4">{{ old('meta_description') }}</textarea>
                                        @error('meta_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary text-white">Submit</button>
                                    </div>
                                </form>
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
    <link href="{{ asset('panel/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/tinymce/tinymce.min.js') }}"></script>

    <script>
        if ($("#basic-example").length > 0) {
            tinymce.init({
                selector: 'textarea#basic-example',
                height: 400,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
            });
        }
    </script>
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('panel/js/pages/form-select2.init.js') }}"></script>
    <script src="{{ asset('panel/libs/select2/js/select2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const blockId = this.getAttribute('data-id');

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
                                `{{ url('admin/block/delete') }}/${blockId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                });

                            if (!response.ok) throw new Error('Failed to delete');

                            await Swal.fire('Deleted!', 'block has been deleted.', 'success');
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
