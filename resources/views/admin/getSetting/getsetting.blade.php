@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @if (session()->has('message') || session()->has('error') || session()->has('success'))
                    <div
                        class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                        {{ session('message') ?? (session('error') ?? session('success')) }}
                    </div>
                @endif

                <form action="{{ route('admin.settings') }}" method="POST" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">


                            <div class="card">
                                <div class="card-header card-header-bordered">
                                    <h3 class="card-title">Basic Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-3">
                                        <div>
                                            <label for="exampleFormControlInput1" class="form-label">Company Name</label>
                                            <input type="email"
                                                value="{{ old('company_name', get_setting('company_name')) }}"
                                                name="company_name" class="form-control" id="exampleFormControlInput1"
                                                placeholder="" />
                                            @error('company_name')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="exampleFormControlInput1" class="form-label">Company Email</label>
                                            <input type="email"
                                                value="{{ old('company_email', get_setting('company_email')) }}"
                                                name="company_email" class="form-control" id="exampleFormControlInput1"
                                                placeholder="" />
                                            @error('company_email')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="exampleFormControlInput1" class="form-label">Company Phone</label>
                                            <input type="text" class="form-control" name="company_phone"
                                                id="exampleFormControlInput1" placeholder=""
                                                value="{{ old('company_phone', get_setting('company_phone')) }}" />
                                            @error('company_phone')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="exampleFormControlTextarea1" class="form-label">Company
                                                Address</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" name="company_address" rows="3">{{ old('company_address', get_setting('company_address')) }}</textarea>
                                            @error('company_address')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                    </div>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-header card-header-bordered">
                                    <h3 class="card-title">Social Links</h3>
                                </div>
                                <div class="card-body">


                                    <div class="d-grid gap-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Facebook</span>
                                            <input type="text"
                                                class="form-control @error('facebook_link') is-invalid @enderror"
                                                value="{{ old('facebook_link', get_setting('facebook_link')) }}"
                                                name="facebook_link" placeholder="https://example.me">

                                        </div>
                                        @error('facebook_link')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror

                                        <div class="input-group">
                                            <span class="input-group-text">Instagram</span>
                                            <input type="text"
                                                class="form-control @error('instagram_link') is-invalid @enderror"
                                                value="{{ old('instagram_link', get_setting('instagram_link')) }}"
                                                name="instagram_link" placeholder="https://example.me">

                                        </div>
                                        @error('instagram_link')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror

                                        <div class="input-group">
                                            <span class="input-group-text">Twitter X</span>
                                            <input type="text"
                                                class="form-control @error('twitter_link') is-invalid @enderror"
                                                value="{{ old('twitter_link', get_setting('twitter_link')) }}"
                                                name="twitter_link" placeholder="https://example.me">

                                        </div>
                                        @error('twitter_link')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror



                                        <div class="input-group">
                                            <span class="input-group-text">Linkedin</span>
                                            <input type="text"
                                                class="form-control @error('linkedin_link') is-invalid @enderror"
                                                value="{{ old('linkedin_link', get_setting('linkedin_link')) }}"
                                                name="linkedin_link" placeholder="https://example.me">

                                        </div>

                                        @error('linkedin_link')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror

                                        <div class="input-group">
                                            <span class="input-group-text">YouTube</span>
                                            <input type="text"
                                                class="form-control @error('youtube_link') is-invalid @enderror"
                                                value="{{ old('youtube_link', get_setting('youtube_link')) }}"
                                                name="youtube_link" placeholder="https://example.me">

                                        </div>
                                        @error('youtube_link')
                                            <em class="text-danger">{{ $message }}</em>
                                        @enderror





                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header card-header-bordered">
                                    <h3 class="card-title">Other Detail</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-3">
                                        <div class="form-group">
                                            <label for="signinSrEmail">Select The Logo Image </label>
                                            <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                data-multiple="false">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        Browse
                                                    </div>
                                                </div>
                                                <div class="form-control file-amount">Choose File</div>
                                                <input type="hidden" name="web_logo"
                                                    value="{{ old('web_logo', get_setting('web_logo')) }}"
                                                    class="selected-files">
                                            </div>
                                            <div class="file-preview box sm">
                                            </div>
                                            @error('web_logo')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="signinSrEmail">Select The Favicon Icon </label>

                                            <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                data-multiple="false">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        Browse
                                                    </div>
                                                </div>
                                                <div class="form-control file-amount">Choose File</div>
                                                <input type="hidden" name="favicon"
                                                    value="{{ old('favicon', get_setting('favicon')) }}"
                                                    class="selected-files">
                                            </div>
                                            <div class="file-preview box sm">

                                            </div>
                                            @error('favicon')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="exampleFormControlTextarea1" class="form-label">Copy Right
                                            </label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" name="copy_right" rows="3">{{ old('copy_right', get_setting('copy_right')) }}</textarea>
                                            @error('copy_right')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-6">

                            <div class="card">
                                <div class="card-header card-header-bordered">
                                    <h3 class="card-title">Seo Section</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-3">
                                        <div>
                                            <div class="form-group">
                                                <label for="signinSrEmail">First Banner Image</label>

                                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                    data-multiple="false">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            Browse
                                                        </div>
                                                    </div>
                                                    <div class="form-control file-amount">Choose File</div>
                                                    <input type="hidden" name="banner_image"
                                                        value="{{ old('banner_image', get_setting('banner_image')) }}"
                                                        class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">

                                                </div>

                                                @error('banner_image')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ ucwords($message) }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div>
                                            <div class="form-group">
                                                <label for="signinSrEmail">Second Banner Image</label>

                                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                    data-multiple="false">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            Browse
                                                        </div>
                                                    </div>
                                                    <div class="form-control file-amount">Choose File</div>
                                                    <input type="hidden" name="banner_image_2"
                                                        value="{{ old('banner_image_2', get_setting('banner_image_2')) }}"
                                                        class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">

                                                </div>

                                                @error('banner_image_2')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ ucwords($message) }}</strong>
                                                    </span>
                                                @enderror

                                            </div>

                                        </div>

                                        <div>
                                            <div class="form-group">
                                                <label for="signinSrEmail">Third Banner Image</label>

                                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                    data-multiple="false">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            Browse
                                                        </div>
                                                    </div>
                                                    <div class="form-control file-amount">Choose File</div>
                                                    <input type="hidden" name="banner_image_3"
                                                        value="{{ old('banner_image_3', get_setting('banner_image_3')) }}"
                                                        class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">

                                                </div>

                                                @error('banner_image_3')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ ucwords($message) }}</strong>
                                                    </span>
                                                @enderror

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header card-header-bordered">
                                    <h3 class="card-title">Seo Section</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-3">
                                        <div>
                                            <label for="exampleFormControlInput1" class="form-label">Meta Title</label>
                                            <input type="text"
                                                value="{{ old('meta_title', get_setting('meta_title')) }}"
                                                name="meta_title" class="form-control" id="exampleFormControlInput1"
                                                placeholder="" />
                                            @error('meta_title')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="exampleFormControlInput1" class="form-label">Meta KeyWords</label>
                                            <input type="text" class="form-control" name="meta_keywords"
                                                id="exampleFormControlInput1" placeholder=""
                                                value="{{ old('meta_keywords', get_setting('meta_keywords')) }}" />
                                            @error('meta_keywords')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div>
                                            <label for="exampleFormControlTextarea1" class="form-label">Meta
                                                Description</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" name="meta_description" rows="3">{{ old('meta_description', get_setting('meta_description')) }}</textarea>
                                            @error('meta_description')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="d-flex btn-group btn-group-lg mb-2 mt-2">
                        <button type="submit" class="btn btn-primary text-white">Update</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
