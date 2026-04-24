@php
use App\Models\Setting;
$model = Setting::setting();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ $model['favicon'] }}" rel="icon" type="image/x-icon">
    <title>@yield('title') | {{$model['name_of_website']}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <META NAME="robots" CONTENT="noindex,nofollow">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-rating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link href="{{ asset('fortawesome/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('css')
</head>
<body class="index-page">
<div class="loader" style="display: none;"></div>
<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
        @include('tradie.layouts.leftmenu')
    </nav>
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light">
            @include('tradie.layouts.topmenu')
        </nav>
        @include('flash-message')
        @yield('content')
        <div class="footer"> All Rights Reserved by {{$model['name_of_website']}} @ 2024</div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-rating.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
@yield('script')
<script>
$(document).ready(function(){
    setTimeout(function() { $(".alert").alert('close'); }, 5000);
});
</script>
</body>
</html>
