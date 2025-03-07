<!doctype html>
<html lang="en">

<head>
    <title>@yield('meta_title', get_setting('meta_title'))</title>
    <meta name="description" content="@yield('meta_description', get_setting('meta_description'))" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords'))" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <link href="{{ asset('site/assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('site/style.css') }}" rel="stylesheet">
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    @livewireStyles
    @yield('site-styles')
</head>

<body>
    @include('site.inc.header')
    {{ $slot }}
    @include('site.inc.footer')
</body>

</html>
