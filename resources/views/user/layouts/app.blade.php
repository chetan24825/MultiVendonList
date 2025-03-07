<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.includes.style')
</head>

<body>
    @include('admin.includes.header')
    @include('user.includes.sidebar')
    @yield('content')
    @include('admin.includes.footer')
</body>
@include('admin.includes.script')

</html>
