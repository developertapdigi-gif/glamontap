<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow" />
    <link href="{{ asset('images/favicon.png') }}" rel="icon" type="image/x-icon">
    <title>@yield('title') | {{config('app.name')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <META NAME="robots" CONTENT="noindex,nofollow">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link href="{{ asset('fortawesome/css/all.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
        @include('frontend.layouts.leftmenu')
    </nav>
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light">
            @include('frontend.layouts.topmenu')
        </nav>
        @include('flash-message')
        @yield('content')
        <div class="footer"> All Rights Reserved by Skill House @ 2024</div>
    </div>
</div>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
@yield('script')
<style type="text/css">
    .alert{z-index: 99; top: 60px;right:18px; min-width:30%; position: fixed;animation: slideflash 0.5s forwards;     }
    @keyframes slideflash { 100% { top: 30px; }     }
    .error {width: 100%;color: red;margin-top: 5px;    }
    @media screen and (max-width: 668px)
    {
        .alert{ left: 10px;right: 10px; }
    }
</style>
<script type="text/javascript">
    /* auto close flash message*/
    $(document).ready(function(){
      setTimeout(function() { $(".alert").alert('close'); }, 3000);
    });
</script>
</body>
</html>
