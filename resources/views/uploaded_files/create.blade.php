@extends('admin.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">

                        <div class="d-flex justify-content-end m-3">
                            <a href="{{ route('admin.uploaded-files.index') }}" class="btn btn-primary text-white">
                                <i class="las la-angle-left"></i>
                                <span>Back to uploaded files</span>
                            </a>
                        </div>
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0 ">Drag & Drop Your Files</h3>
                                </div>
                                <div class="card-body">
                                    <div id="aiz-upload-files" class="h-420px" style="min-height: 65vh">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
