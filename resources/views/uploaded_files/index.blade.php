@extends('admin.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">



                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.uploaded-files.create') }}" class="btn btn-primary text-white">
                        <span>Upload New File</span>
                    </a>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="aiz-titlebar text-left mt-2 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h1 class="h3"></h1>
                                    @if (session()->get('success'))
                                        <span class="alert alert-success" style="width: 100%">
                                            {{ session()->get('success') }}
                                        </span>
                                    @endif
                                </div>


                            </div>
                        </div>
                        <div class="card">
                            <form id="sort_uploads" action="">
                                <div class="card-header row gutters-5" >
                                    <div class="col-md-3">
                                        <h5 class="mb-0 h6">All files</h5>
                                    </div>
                                    <div class="col-md-3 ml-auto mr-0">
                                        {{-- aiz-selectpicker --}}
                                        <select class="form-control form-control-xs " name="sort"
                                            onchange="sort_uploads()">
                                            <option value="newest" @if ($sort_by == 'newest') selected="" @endif>
                                                Sort by
                                                newest
                                            </option>
                                            <option value="oldest" @if ($sort_by == 'oldest') selected="" @endif>
                                                Sort by
                                                oldest
                                            </option>
                                            <option value="smallest" @if ($sort_by == 'smallest') selected="" @endif>
                                                Sort by
                                                smallest
                                            </option>
                                            <option value="largest" @if ($sort_by == 'largest') selected="" @endif>
                                                Sort by
                                                largest
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control form-control-xs" name="search"
                                            placeholder="Search your files" value="{{ $search }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-dark p-2">Search</button>
                                    </div>
                                </div>
                            </form>
                            <div class="card-body">
                                <div class="row gutters-5">
                                    @foreach ($all_uploads as $key => $file)
                                        @php
                                            if ($file->file_original_name == null) {
                                                $file_name = 'Unknown';
                                            } else {
                                                $file_name = $file->file_original_name;
                                            }
                                        @endphp
                                        <div class="col-auto w-140px w-lg-220px">
                                            <div class="aiz-file-box">
                                                <div class="dropdown-file">
                                                    <a class="dropdown-link" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="javascript:void(0)" class="dropdown-item"
                                                            onclick="detailsInfo(this)" data-id="{{ $file->id }}">
                                                            <i class="las la-info-circle mr-2"></i>
                                                            <span>Details Info</span>
                                                        </a>
                                                        <a href="{{ my_asset($file->file_name) }}" target="_blank"
                                                            download="{{ $file_name }}.{{ $file->extension }}"
                                                            class="dropdown-item">
                                                            <i class="la la-download mr-2"></i>
                                                            <span>Download</span>
                                                        </a>
                                                        <a href="javascript:void(0)" class="dropdown-item"
                                                            onclick="copyUrl(this)"
                                                            data-url="{{ my_asset($file->file_name) }}">
                                                            <i class="las la-clipboard mr-2"></i>
                                                            <span>Copy Link</span>
                                                        </a>
                                                        <a href="javascript:void(0)" class="dropdown-item confirm-alert"
                                                            data-href="{{ route('admin.uploaded-files.destroy1', $file->id) }}"
                                                            data-target="#delete-modal">
                                                            <i class="las la-trash mr-2"></i>
                                                            <span>Delete</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card card-file aiz-uploader-select c-default"
                                                    title="{{ $file_name }}.{{ $file->extension }}">
                                                    <div class="card-file-thumb">
                                                        @if ($file->type == 'image')
                                                            <img src="{{ my_asset($file->file_name) }}" class="img-fit">
                                                        @elseif($file->type == 'video')
                                                            <i class="las la-file-video"></i>
                                                        @else
                                                            <i class="las la-file"></i>
                                                        @endif
                                                    </div>
                                                    <div class="card-body">
                                                        <h6 class="d-flex">
                                                            <span class="text-truncate title">{{ $file_name }}</span>
                                                            <span class="ext">.{{ $file->extension }}</span>
                                                        </h6>
                                                        <p>{{ formatBytes($file->file_size) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="aiz-pagination mt-3">
                                    {{ $all_uploads->appends(request()->input())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div id="delete-modal" class="modal  fade">
                        <div class="modal-dialog modal-sm modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title h6">{{ 'Delete Confirmation' }}</h4>

                                    <button type="button" class="btn btn-sm btn-label-danger btn-icon"
                                        data-bs-dismiss="modal">
                                        <i class="mdi mdi-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <p class="mt-1">{{ 'Are you sure to delete this file?' }}</p>

                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <a href="" class="btn btn-success comfirm-link">{{ 'Delete' }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="info-modal" class="modal fade">
                        <div class="modal-dialog modal-dialog-right">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title h6">{{ 'File Info' }}</h5>
                                    {{-- <button type="button" class="close" data-dismiss="modal">
                                    </button> --}}

                                </div>
                                <div class="modal-body c-scrollbar-light position-relative" id="info-modal-content">
                                    <div class="c-preloader text-center absolute-center">
                                        <i class="las la-spinner la-spin la-3x opacity-70"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
