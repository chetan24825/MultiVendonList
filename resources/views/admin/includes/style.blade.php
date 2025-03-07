<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('meta_title', get_setting('meta_title'))</title>
<meta name="description" content="@yield('meta_description', get_setting('meta_description'))" />
<meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords'))" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="app-url" content="{{ url(current_guard() == 'web' ? 'user' : current_guard()) }}">
<meta name="web-url" content="{{ url('/') }}">
<meta name="file-base-url" content="{{ getFileBaseURL() }}">
<script src="{{ asset('panel/js/pages/layout.js') }}"></script>
<link href="{{ asset('panel/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<link  href="{{ asset('panel/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<link href="{{ asset('panel/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('aizfiles/vendor.css') }}" rel="stylesheet">
<script src="{{ asset('aizfiles/vendors.js') }}"></script>
<link href="{{ asset('aizfiles/aiz-core.css') }}" rel="stylesheet">
@stack('styles')
<script>
    var AIZ = AIZ || {};
    AIZ.local = {
        nothing_found: 'Nothing found',
        choose_file: 'Choose file',
        file_selected: 'File selected',
        files_selected: 'Files selected',
        add_more_files: 'Add more files',
        adding_more_files: 'Adding more files',
        drop_files_here_paste_or: 'Drop files here, paste or',
        browse: 'Browse',
        upload_complete: 'Upload complete',
        upload_paused: 'Upload paused',
        resume_upload: 'Resume upload',
        pause_upload: 'Pause upload',
        retry_upload: 'Retry upload',
        cancel_upload: 'Cancel upload',
        uploading: 'Uploading',
        processing: 'Processing',
        complete: 'Complete',
        file: 'File',
        files: 'Files',
    }
</script>

