<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- <title>@yield('meta_title', get_setting('meta_title'))</title>
    <meta name="description" content="@yield('meta_description', get_setting('meta_description'))" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords'))" />
    <meta name="author" content="{{ config('app.name') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />


    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta property="og:title" content="@yield('meta_title', get_setting('meta_title'))" />
    <meta property="og:description" content="@yield('meta_keywords', get_setting('meta_keywords'))" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="600" />
    @if (get_setting('web_logo'))
        <meta property="og:image" content="{{ uploaded_asset(get_setting('web_logo')) }}" />
    @endif
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta name="twitter:title" content="@yield('meta_title', get_setting('meta_title'))" />
    <meta name="twitter:description" content="@yield('meta_description', get_setting('meta_description'))" />
    @if (get_setting('web_logo'))
        <meta name="twitter:image" content="{{ uploaded_asset(get_setting('web_logo')) }}" />
    @endif

    @if (get_setting('favicon'))
        <link rel="icon" type="image/x-icon" href="{{ uploaded_asset(get_setting('favicon')) }}">
    @endif --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/js/app.js'])
    @inertiaHead
    @routes

    <link href="{{ asset('site/style.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link rel= "stylesheet"
        href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

</head>

<body>
    @inertia

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    @stack('site-scripts')

</body>




</html>
