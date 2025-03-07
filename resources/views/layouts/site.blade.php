<!doctype html>
<html lang="en">

<head>
    @include('site.inc.style')
</head>

<body>

    @include('site.inc.header')
    {{ $slot }}
    @include('site.inc.footer')

</body>

</html>
