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
            @if(!session('employer_mode'))
            <li class="mobile-content"><a style="color:#fff; text-align:center;  margin-right:5px;" class="btn btn-primary me-1" href="{{ route('employer') }}">Find Professionals</a></li>
            @else
            @auth
            <li class="mobile-content employer-btn"><a style="color:#fff; text-align:center; margin-right:5px;" class="btn btn-primary me-1" href="{{  route('dashboard') }}">Dashboard</a></li>
            @endauth
            @guest
            <li class="mobile-content employer-btn"><a style="color:#fff; text-align:center;  margin-right:5px;" class="btn btn-primary me-1" href="{{ route('user.login') }}">Login</a></li>
            <li class="mobile-content employer-btn"><a style="text-align:center" class="btn btn-primary text-decoration-none btn-white" href="{{ route('user.register') }}">Register</a></li>
            @endguest
            @endif

          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <div class="btn-getstarted mobile-hide">
          @auth
          <a href="{{ route('dashboard') }}" class="btn btn-primary btn-right-margin">Dashboard</a>
          @endauth
          @guest
          <a href="{{ route('user.login') }}" class="btn btn-primary btn-right-margin">Login</a>
          <a href="{{ route('user.register') }}" class="btn btn-primary btn-white">Register</a>
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
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="{{ asset('js/slick.min.js') }}" type="text/javascript" charset="utf-8"></script>
  @yield('script')
  <div class="loader" style="display: none;"></div>
<script>
$(function () {

  const $slider = $('.center_slider');
  let realSlides = null;

  /* ---------- CACHE REAL SLIDES ---------- */
  function getSlides(slick){
    if(!realSlides){
      realSlides = $(slick.$slides).not('.slick-cloned');
    }
    return realSlides;
  }

  /* ---------- PRELOAD CENTER + NEXT (iOS SAFE) ---------- */
  function preloadVideos(slick){
    const slides = getSlides(slick);
    const centerIndex = slides.index(slides.filter('.slick-center'));
    const nextIndex = (centerIndex + 1) % slides.length;

    [centerIndex, nextIndex].forEach(i=>{
      const video = slides.eq(i).find('video.video-control').get(0);
      if(video && video.readyState === 0){
        video.preload = "metadata"; // IMPORTANT for iOS
        try{ video.load(); }catch(e){}
      }
    });
  }

  /* ---------- SYNC CLONES ---------- */
  function syncCenterClone(slick){
    const $center = getSlides(slick)
      .filter('.slick-center')
      .find('video.video-control');

    if(!$center.length) return;

    const video = $center.get(0);
    const src = $center.find('source').attr('src');

    $(`.slick-cloned source[src="${src}"]`).each(function(){
      const cloneVideo = this.parentElement;
      cloneVideo.muted = true;
      cloneVideo.playsInline = true;

      try{
        if(cloneVideo.readyState === 0) cloneVideo.load();
        cloneVideo.currentTime = video.currentTime || 0;
      }catch(e){}
    });
  }

  /* ---------- PLAY CENTER (FULL iOS FIX) ---------- */
  function playCenterVideoOptimized(slick){

    const slides = getSlides(slick);

    /* pause all */
    slides.find('video.video-control').each(function(){
      this.pause();
    });

    const $centerSlide = slides.filter('.slick-center');
    const video = $centerSlide.find('video.video-control').get(0);

    if(!video) return;

    /* iOS autoplay requirements */
    video.muted = true;
    video.playsInline = true;
    video.setAttribute("playsinline","");
    video.setAttribute("webkit-playsinline","");

    /* FORCE LOAD when active (main fix) */
    if(video.readyState < 2){
      const source = video.querySelector('source');
      if(source){
        const src = source.getAttribute('src');
        video.src = src;
        try{ video.load(); }catch(e){}
      }
    }

    const playNow = ()=> video.play().catch(()=>{});

    if(video.readyState >= 2){
      playNow();
    }else{
      video.addEventListener("loadeddata", playNow, {once:true});
    }

    syncCenterClone(slick);

    $('.center_slider video').removeClass('active-border');
    $(video).addClass('active-border');
  }

  /* ---------- EVENTS ---------- */
  $slider.on('init', function(e,slick){
    realSlides = null;
    setTimeout(()=>{
      preloadVideos(slick);
      playCenterVideoOptimized(slick);
    },80); // iOS timing fix
  });

  $slider.on('afterChange', function(e,slick){
    preloadVideos(slick);
    playCenterVideoOptimized(slick);
  });

  $slider.on('mousedown touchstart swipe', function(){
    const slick = $slider.slick('getSlick');
    if(!slick.autoplaying) slick.slickPlay();
    playCenterVideoOptimized(slick);
  });

  /* ---------- SLICK ---------- */
  $slider.slick({
    centerMode:true,
    centerPadding:'0px',
    slidesToShow:1,
    infinite:true,
    dots:true,
    arrows:false,
    autoplay:true,
    autoplaySpeed:5000,
    pauseOnHover:false,
    pauseOnFocus:false,
    variableWidth:true,
    responsive:[
      { breakpoint:480, settings:{slidesToShow:1}}
    ]
  });

  /* ---------- RESIZE FIX ---------- */
  let resizeTimer;
  $(window).on('resize orientationchange',function(){
    clearTimeout(resizeTimer);
    resizeTimer=setTimeout(()=>{
      if($slider.hasClass('slick-initialized')){
        $slider.slick('setPosition');
      }
    },150);
  });

  /* ---------- TAB VISIBILITY ---------- */
  document.addEventListener('visibilitychange',function(){
    if(document.visibilityState==='visible'){
      const slick=$slider.slick('getSlick');
      playCenterVideoOptimized(slick);
    }
  });

  setTimeout(()=>$(".alert").alert('close'),5000);

});
</script>
</body>

</html>