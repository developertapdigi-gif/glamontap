@php
use App\Models\Setting;
$model = Setting::setting();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex, nofollow" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="{{ $model['favicon'] }}" rel="icon" type="image/x-icon">
  <title>@yield('title') | {{$model['name_of_website']}}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}" rel="stylesheet">
  <link href="{{ asset('css/slider.css') }}" rel="stylesheet">
  <link href="{{ asset('fortawesome/css/all.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}">
  @yield('css')

</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid">
      <div class="top-content  position-relative d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}"  id="logo-link" class="logo d-flex align-items-center me-auto me-xl-0">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="{{ $model['website_logo'] }}" alt="">

        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            @if(session('employer_mode'))
            <li><a class="{{Str::contains(url()->current(), 'employer') ? 'active' : '' }}" href="{{ url('/employer') }}">Home</a></li>
            @else
            <li><a class="{{(request()->is('/')) ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
            @endif
            <li><a href="{{  route('services') }}" class="{{Str::contains(url()->current(), 'services') ? 'active' : '' }}"><span>Services</span></a></li>
            <li><a href="{{  route('about') }}" class="{{Str::contains(url()->current(), 'about') ? 'active' : '' }}">About Us</a></li>
            <li><a href="{{  route('contact') }}" class="{{Str::contains(url()->current(), 'contact') ? 'active' : '' }}">Contact</a></li>
            <li class="mobile-content employer-btn"><a style="color:#fff; text-align:center;  margin-right:5px;" class="btn btn-primary me-1" href="{{ route('skills.details') }}">View Jobs</a></li>
            @if(!session('employer_mode'))
            <li class="mobile-content"><a style="color:#fff; text-align:center;  margin-right:5px;" class="btn btn-primary me-1" href="{{ route('employer') }}">Find Professionals</a></li>
            @else
            @auth
            <li class="mobile-content employer-btn"><a style="color:#fff; text-align:center; margin-right:5px;" class="btn btn-primary me-1" href="{{  route('dashboard') }}">Dashboard</a></li>
            @endauth
            @guest
            <li class="mobile-content employer-btn"><a style="color:#fff; text-align:center;  margin-right:5px;" class="btn btn-primary me-1" href="{{ route('user.login') }}">Login</a></li>
            {{-- <li class="mobile-content employer-btn"><a style="text-align:center" class="btn btn-primary text-decoration-none btn-white" href="{{ route('user.register') }}">Register</a></li> --}}
            @endguest
            @endif
           

          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <div class="btn-getstarted mobile-hide">
          {{-- <a href="{{ route('home') }}?emp=1" class="btn btn-primary btn-right-margin">View Jobs</a>
           --}}
          <a href="{{ route('skills.details') }}" class="btn btn-primary btn-right-margin">View Jobs</a>
          
          @auth
          <a href="{{ route('dashboard') }}" class="btn btn-primary btn-white">Dashboard</a>
          @endauth
          @guest
          <a href="{{ route('user.login') }}" class="btn btn-primary btn-white">Login</a>
          {{-- <a href="{{ route('user.register') }}" class="btn btn-primary btn-white">Register</a> --}}
          @endguest
        </div>
      </div>
    </div>
  </header>
  @yield('content')



  <section class="skill-sub-footer social-footer-icons">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4 col-lg-3 footer-logo">
          <a href="/"><img src="{{ $model['website_logo'] }}" width = "100" /></a>
        </div>
        <div class="col-md-5 col-lg-7 text-center">
          Need Support? - <b>{{$model['support_email']}}</b>
        </div>
        <div class="col-md-3 col-lg-2 skill-sub-footer-icons">
          <p class="facebook-icn">
            <a href="{{$model['fb_link']}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
          </p>
          <p class="twitter-icn">
            <a href="{{$model['instagram_link']}}" target="_blank"><i class="bi bi-instagram"></i></a>
          </p>
          <p class="linkdin-icn">
            <a href="{{$model['linkedIn_link']}}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
          </p>


        </div>
      </div>
    </div>
  </section>
  <footer class="skill-website-footer">
    <div class="container">
      <p class="footer-text-left">© 2024 {{$model['name_of_website']}} | <a href="{{route('privacyPolicy')}}"> Privacy Policy</a></p>
      <p class="footer-text-right"><a href="{{route('termsCondition')}}">Community Guidelines</a></p>
    </div>
  </footer>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="{{ asset('js/slick.min.js') }}" type="text/javascript" charset="utf-8"></script>
  @yield('script')
  <div class="loader" style="display: none;"></div>
  <script>
$(document).ready(function () {

    $('#logo-link').click(function (e) {
        e.preventDefault();

        $.get("{{ route('clear.employer.mode') }}", function () {
            window.location.href = "{{ url('/') }}";
        });

    });

});
</script>

</body>

</html>