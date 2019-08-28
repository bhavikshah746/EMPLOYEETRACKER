<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @section('title')
        @show
    </title>
    @include('admin.includes.head')
</head>

<body>
<div class="wrap">
    @yield('content')
    @include('admin.includes.footer_script')
    @yield('footer')
    @include('admin.partials.notifications')
</div>
</body>
</html>
