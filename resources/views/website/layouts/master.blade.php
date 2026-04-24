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
        <a href="{{ url('/') }}?emp=1" class="logo d-flex align-items-center me-auto me-xl-0">
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
            <!-- @if(!session('employer_mode'))
                    <li class="mobile-content employer-btn"><a style="color:#fff; text-align:center;  margin-right:5px;" class="btn btn-primary me-1 empolyer-mobile"  href="{{ route('employer') }}">Employer Site</a></li>
            @else
                @auth
                 <li class="mobile-content employer-btn"><a  style="color:#fff; text-align:center; margin-left:5px; margin-right:5px;"  class="btn btn-primary ms-1 me-1" href="{{  route('dashboard') }}">Dashboard</a></li>
                @endauth
                @guest
                    <li class="mobile-content"><a style="color:#fff; text-align:center;  margin-right:5px;" class="btn btn-primary me-1"  href="{{ route('user.login') }}">Login</a></li>
                    <li class="mobile-content"><a  style="color:#fff; text-align:center" class="btn btn-primary btn-black text-decoration-none" href="{{ route('user.register') }}">Register</a></li>
                @endguest
            @endif -->
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        @if(!session('employer_mode'))
        <div class="mobile-content employer-home"><a style="color:#fff; text-align:center;" class="btn btn-primary employer-site" href="{{ route('employer') }}">Find Professionals</a></div>
        @else
        @auth
        <div class="mobile-content employer-btn"><a style="color:#fff; text-align:center; margin-left:5px; margin-right:5px;" class="btn btn-primary ms-1 me-1 employer-site" href="{{ Auth::user()->hasRole('trader') ? route('tradie.dashboard') : route('dashboard') }}">Dashboard</a></div>
        @endauth

        @endif
        <div class="btn-getstarted mobile-hide">
          @if(!session('employer_mode'))
          <a href="{{ route('employer') }}" class="btn btn-primary btn-right-margin">Find Professionals</a>
          @else
          @auth
          <a href="{{ Auth::user()->hasRole('trader') ? route('tradie.dashboard') : route('dashboard') }}" class="btn btn-primary btn-right-margin">Dashboard</a>
          @endauth
          <!--  @guest
                <a href="{{ route('user.login') }}" class="btn btn-primary btn-right-margin">Login</a>
                <a href="{{ route('user.register') }}" class="btn btn-primary btn-white">Register</a>
            @endguest -->

          @endif

        </div>
      </div>
    </div>
  </header>
  @yield('content')



  <section class="skill-sub-footer social-footer-icons">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4 col-lg-3 footer-logo">
          <a href="/"><img src="{{ $model['website_logo'] }}" /></a>
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
  <link href="{{ asset('fortawesome/css/all.min.css') }}" rel="stylesheet" />
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
<script>
$(function () {

    const $slider = $('.center_slider1');

    let cachedSlides = null;
    let playLock = false;

    /* ---------- CACHE REAL SLIDES ---------- */
    function getRealSlides(slick) {
        if (!cachedSlides) {
            cachedSlides = $(slick.$slides).not('.slick-cloned');
        }
        return cachedSlides;
    }

    /* ---------- PAUSE ALL (NO FLICKER RESET) ---------- */
    function pauseAll(slick) {
        getRealSlides(slick)
            .find('video.video-control.playing')
            .each(function () {

                this.pause();

                // Reset only non-center videos
                if (!$(this).closest('.slick-slide').hasClass('slick-center')) {
                    this.currentTime = 0;
                }

                this.classList.remove('playing');
            });
    }

    /* ---------- SAFE PLAY (FLICKER FREE) ---------- */
    function safePlay(video) {
        if (!video) return;

        if (!video.dataset.optimized) {
            video.muted = true;
            video.playsInline = true;
            video.preload = "metadata";
            video.dataset.optimized = "1";
        }

        const startPlay = () => {
            requestAnimationFrame(() => {
                const p = video.play();
                if (p) p.catch(() => setTimeout(startPlay, 200));
                video.classList.add('playing');
            });
        };

        if (video.readyState >= 2) {
            startPlay();
        } else {
            video.addEventListener('loadeddata', startPlay, { once: true });
        }
    }

    /* ---------- PRELOAD ONLY NEAR SLIDES ---------- */
    function preloadSlides(slick, index) {

        const slides = getRealSlides(slick);
        const len = slides.length;

        [index, (index + 1) % len, (index - 1 + len) % len].forEach(i => {

            const v = slides.eq(i).find('video.video-control').get(0);

            if (v && !v.dataset.loaded) {
                v.preload = "auto";
                v.load();
                v.dataset.loaded = "1";
            }
        });
    }

    /* ---------- PLAY CENTER VIDEO ---------- */
    function playCenterVideo(slick, currentSlide = 0) {

        if (playLock) return;
        playLock = true;

        pauseAll(slick);
        preloadSlides(slick, currentSlide);

        const video = getRealSlides(slick)
            .filter('.slick-center')
            .find('video.video-control')
            .get(0);

        safePlay(video);

        setTimeout(() => playLock = false, 120);
    }

    /* ---------- CLONE VIDEO FIX ---------- */
    function syncClones() {
        document.querySelectorAll('.slick-cloned video').forEach(v => {
            v.muted = true;
            v.playsInline = true;
        });
    }

    /* ---------- EVENTS ---------- */
    $slider.on('init', (e, slick) => {
        cachedSlides = null;
        syncClones();
        playCenterVideo(slick);
    });

    $slider.on('afterChange', (e, slick, current) => {
        playCenterVideo(slick, current);
    });

    $slider.on('mousedown touchstart swipe', function () {
        const slick = $slider.slick('getSlick');
        playCenterVideo(slick, slick.currentSlide);
    });

    /* ---------- SLICK INIT ---------- */
    $slider.slick({
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 5,
        infinite: true,
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 5000,
        pauseOnHover: false,
        pauseOnFocus: false,
        responsive: [
            { breakpoint: 1500, settings: { slidesToShow: 5 } },
            { breakpoint: 1025, settings: { slidesToShow: 3 } },
            { breakpoint: 575,  settings: { slidesToShow: 1, centerPadding: '35px' } }
        ]
    });

    /* ---------- RESIZE OPTIMIZED ---------- */
    let resizeTimer;

    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(() => {
            if ($slider.hasClass('slick-initialized')) {
                $slider.slick('setPosition');
            }
        }, 250);
    });

});
</script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const video = document.getElementById("banner-video");
      if (!video) return;

      const tryPlay = () => {
        video.play().catch(err => {
          console.warn("Autoplay blocked, retrying...", err);
          setTimeout(tryPlay, 200);
        });
      };

      video.muted = true;
      video.playsInline = true;

      tryPlay();
    });
  </script>

</body>

</html>