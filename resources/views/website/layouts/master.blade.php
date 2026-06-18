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
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  <link href="{{ asset('css/slider.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}">
  @yield('css')

</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid">
      <div class="top-content  position-relative d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="{{ $model['website_logo'] }}" alt="">

        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            @if(session('employer_mode'))
            <li> <a class="{{ request()->is('employer') ? 'active' : '' }}" href="{{ url('/employer') }}">Home</a></li>
            @else
            <li><a class="{{(request()->is('/')) ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
            @endif
            <li><a href="{{  route('services') }}" class="{{Str::contains(url()->current(), 'services') ? 'active' : '' }}"><span>Services</span></a></li>
            <li><a href="{{  route('about') }}" class="{{Str::contains(url()->current(), 'about') ? 'active' : '' }}">About Us</a></li>
            <li><a href="{{  route('contact') }}" class="{{Str::contains(url()->current(), 'contact') ? 'active' : '' }}">Contact</a></li>
            @if(!session('employer_mode'))
            <li class="mobile-content employer-btn"><a style="color:#fff; text-align:center;  margin-right:5px;" class="btn btn-primary me-1 empolyer-mobile" href="{{ route('employer') }}">Find Professionals</a></li>
            @else
            @auth
            <li class="mobile-content employer-btn"><a style="color:#fff; text-align:center; margin-left:5px; margin-right:5px;" class="btn btn-primary ms-1 me-1" href="{{ Auth::user()->hasRole('trader') ? route('tradie.dashboard') : route('dashboard') }}">Dashboard</a></li>
            @endauth
            @endif
            @guest
            <li class="mobile-content"><a style="color:#fff; text-align:center;  margin-right:5px;" class="btn btn-primary me-1 btn-white" href="{{ route('user.login') }}">Login</a></li>
            {{-- <li class="mobile-content"><a  style="color:#fff; text-align:center" class="btn btn-primary btn-black text-decoration-none" href="{{ route('user.register') }}">Register</a></li> --}}
            @endguest

          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        {{-- <div class="mobile-content employer-home"><a style="color:#fff; text-align:center;" class="btn btn-primary employer-site" href="{{ route('employer') }}">Find Professionals</a>
      </div>

      @auth
      <div class="mobile-content employer-btn"><a style="color:#fff; text-align:center; margin-left:5px; margin-right:5px;" class="btn btn-primary ms-1 me-1 employer-site" href="{{ Auth::user()->hasRole('trader') ? route('tradie.dashboard') : route('dashboard') }}">Dashboard</a></div>
      @endauth
      @guest
      <div class="mobile-content employer-home"><a style="color:#fff; text-align:center;" class="btn btn-primary employer-site" href="{{ route('user.login') }}">Login</a></div>
      @endguest --}}


      <div class="btn-getstarted mobile-hide">

        <a href="{{ route('employer') }}" class="btn btn-primary btn-right-margin">Find Professionals</a>

        @auth
        <a href="{{ Auth::user()->hasRole('trader') ? route('tradie.dashboard') : route('dashboard') }}" class="btn btn-primary btn-white">Dashboard</a>
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

  <footer class="footer2">
    <div class="container">
      <div class="row gy-5">
        <div class="got-footer-brand col-lg-4 col-md-6">
          <a href="#" class="logo d-flex mb-3">
            <img src="{{ $model['website_logo'] }}" alt="">
          </a>
          <p>Glam On Tap is your trusted platform to discover talent, book services, and build your beauty career.</p>
          <div class="got-social">
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
          </div>
        </div>
        <!-- EXPLORE -->
        <div class="col-lg-2 col-md-6">
          <h6 class="footer-col-heading">Explore</h6>
          <ul class="footer-links">
            <li><img src="../images/arrow2.svg" width="12"> <a href="#">Home</a></li>
            <li><img src="../images/arrow2.svg" width="12"> <a href="#">Services</a></li>
            <li><img src="../images/arrow2.svg" width="12"> <a href="#">About Us</a></li>
            <li><img src="../images/arrow2.svg" width="12"> <a href="#">Contact</a></li>
          </ul>
        </div>

        <!-- FOR PROFESSIONALS -->
        <!-- <div class="col-lg-3 col-md-6">
          <h6 class="footer-col-heading">For Professionals</h6>
          <ul class="footer-links">
            <li><img src="../images/arrow2.svg" width="12"><a href="#">Find Professionals</a></li>
            <li><img src="../images/arrow2.svg" width="12"><a href="#">Join as a Professional</a></li>
            <li><img src="../images/arrow2.svg" width="12"><a href="#">Professional Login</a></li>
          </ul>
        </div> -->

        <!-- SUPPORT -->
        <div class="col-lg-3 col-md-6">
          <h6 class="footer-col-heading">Support</h6>
          <ul class="footer-links">
            <li><img src="../images/arrow2.svg" width="12"><a href="#">Terms &amp; Conditions</a></li>
            <li><img src="../images/arrow2.svg" width="12"><a href="#">Privacy Policy</a></li>
            <li><img src="../images/arrow2.svg" width="12"><a href="#">Help & Support</a></li>
          </ul>
        </div>

        <!-- GET IN TOUCH -->
        <div class="col-lg-3 col-md-6">
          <h6 class="footer-col-heading">Get In Touch</h6>

          <div class="contact-item">
            <div class="contact-icon-box">
              <i class="fa-solid fa-phone"></i>
            </div>
            <div>
              <div class="contact-title">+91-9686681076</div>
              <div class="contact-sub">Mon‑Sat: 10AM‑6PM Sun: 10AM‑4PM</div>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon-box">
              <i class="fa-solid fa-envelope"></i>
            </div>
            <div>
              <div class="contact-title">support@glamontap.com</div>
              <div class="contact-sub">We reply within 24 hours</div>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon-box">
              <i class="fa-solid fa-location-dot"></i>
            </div>
            <div>
              <div class="contact-title">Office G5, D-229, Sector 74, </div>
              <div class="contact-sub">Mohali, Punjab 140307</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </footer>
  <div class="container-fluid">
    <!-- Footer Bottom -->
    <div class="row footer-bottom align-items-center">
      <div class="col-12 text-center copyright">
        2024 Glam On Tap. All Rights Reserved.
      </div>
    </div>
  </div>
  <!-- <section class="skill-sub-footer social-footer-icons">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4 col-lg-3 footer-logo">
          <a href="/"><img src="{{ $model['website_logo'] }}" width="100"/></a>
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
      <p class="footer-text-left">© 2026 {{$model['name_of_website']}} | <a href="{{route('privacyPolicy')}}"> Privacy Policy</a></p>
      <p class="footer-text-right"><a href="{{route('termsCondition')}}">Community Guidelines</a></p>
    </div>
  </footer> -->

  <link href="{{ asset('fortawesome/css/all.min.css') }}" rel="stylesheet" />
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('js/slick.min.js') }}" type="text/javascript" charset="utf-8"></script>
  @yield('script')
  <div class="loader"></div>
  <script>
    function hideLoader() {
      const loader = document.querySelector(".loader");
      if (loader) {
        loader.classList.add("hidden");
        setTimeout(() => loader.style.display = "none", 500); // remove after fade
      }
    }

    // Hide loader as soon as DOM is ready
    document.addEventListener("DOMContentLoaded", hideLoader);

    // Safety: hide again on window load
    window.addEventListener("load", hideLoader);

    // Fallback: force hide after 1.5s (first load Safari fix)
    setTimeout(hideLoader, 1500);
  </script>
  <style>
    .loader {
      transition: opacity 0.2s ease;
      opacity: 0;
    }

    .loader.hidden {
      opacity: 0;
      pointer-events: none;
    }

    .loader.visible {
      opacity: 1;
    }
  </style>


</body>



</html>