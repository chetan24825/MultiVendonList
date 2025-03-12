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
                                <h4 class="card-title text-white">Import Companies</h4>
                            </div>
                            <div class="card-body">






                                <form action="{{ route('admin.companies.import') }}" method="POST" class="row g-3"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!-- Withdrawal Amount -->
                                    <div class="col-md-12">
                                        <label for="import" class="form-label">Import Companies<span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="import" id="import" class="form-control"
                                            value="{{ old('import') }}" required>
                                        @error('import')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary text-white">
                                            Submit
                                        </button>
                                    </div>
                                </form>

                            </div>

                            <div class="card-body">
                                <img class="img-fluid pad" src="{{ asset('images/plumberUpload.PNG') }}"
                                    alt="Upload Format Image">
                            </div>
                        </div>
                    </div>



                </div>





            </div>
        </div>
    </div>
    {{-- <div class="content-wrapper">


        <section class="content">
            <form action="{{ route('admin.companies.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Import {{ get_setting('site_name') }}</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Import {{ get_setting('site_name') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="import">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    @error('import')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="submit" value="Save Changes" class="btn btn-success float-right">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <img class="img-fluid pad" src="{{ asset('images/plumberUpload.PNG') }}" alt="Upload Format Image">
            </div>
        </section>
    </div> --}}
@endsection
