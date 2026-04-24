@extends('website.layouts.master')
@section('title')
Home
@endsection
@section('content')
<div class="top-content banner-outer banner-outer-2">
  <div class="row banner">
    <!-- <video preload="none" autoplay muted loop playsinline webkit-playsinline class="banner-video">
        <source src="{{ asset('images/homebanner.webm') }}" type="video/webm">
        <source src="{{ asset('images/homebanner.mp4') }}" type="video/mp4">
      </video> -->
    <video preload="auto" autoplay muted loop playsinline webkit-playsinline class="banner-video" id="hero-video">
            <source src="https://thecoverhouse.com/images/bannervd2.mp4" type="video/mp4">
          </video>

    <div class="col-xxl-9 col-xl-10 col-12 app-btn banner-text banner_text1">
      <h1>Your Home,Our Care <span class="more-job">Trusted Help At Your Doorstep</span></h1>
      <h3>Whether you're a plumber, electrician, cleaner, or caretaker — highlight your expertise and connect with people who need your services.</h3>
      <div class="d-flex download-btn social-ads justify-content-center">
        <a href="#">
          <div class="applestore social-media-banners d-flex me-3 me-xs-0 mb-xs-3">
            <i class="bi bi-apple white-icn"></i>
            <div>
              <p>Download on the</p>
              <b>Apple Store</b>
            </div>
          </div>

        </a>

        <a href="#">
          <div class="playstore social-media-banners d-flex">
            <i class="bi bi-google-play"></i>
            <div>
              <p>Get it on</p>
              <b>Google Play</b>
            </div>
          </div>

        </a>
      </div>



    </div>


  </div>
</div>


<section class="slider-section empower-tools tradies-site">
  <div class="trade-people-slider home-trader">
    <h2 class="mid-title">
      Supporting home-service providers to stand out and thrive in a competitive environment.
    </h2>
  </div>
  <div class="container-fluid text-center my-3 slider-home swiper">


    <section class="center_slider1 slider">
      <div>
        <!-- <video preload="none" muted playsinline webkit-playsinline class="video-control">
                <source src="{{ asset('videos/tradies5.webm') }}" type="video/webm">
                <source src="{{ asset('videos/tradies5.mp4')}}" type="video/mp4">
              </video> -->
        <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
          <source src="https://thecoverhouse.com/images/tradies5.mp4" type="video/mp4">
        </video>
        <p>Instant Service Connection</p>
      </div>
      <div>
        <!--  <video preload="none" muted playsinline webkit-playsinline class="video-control">
                <source src="{{ asset('videos/tradies3.webm') }}" type="video/webm">
                <source src="{{ asset('videos/tradies3.mp4')}}" type="video/mp4">
              </video> -->
        <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
          <source src="https://thecoverhouse.com/images/tradies3.mp4" type="video/mp4">
        </video>
        <p>Real-Time Job Notifications</p>
      </div>
      <div>
        <!--  <video preload="none" muted playsinline webkit-playsinline class="video-control">
                <source src="{{ asset('videos/tradies1.webm') }}" type="video/webm">
                <source src="{{ asset('videos/tradies1.mp4')}}" type="video/mp4">
              </video>  -->
        <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
          <source src="https://thecoverhouse.com/images/tradies.mp4" type="video/mp4">
        </video>
        <p>Swipe to Unlock Opportunities</p>
      </div>
      <div>
        <!-- <video preload="none" muted playsinline webkit-playsinline class="video-control">
                <source src="{{ asset('videos/tradies4.webm') }}" type="video/webm">
                <source src="{{ asset('videos/tradies4.mp4')}}" type="video/mp4">
              </video> -->
        <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
          <source src="https://thecoverhouse.com/images/tradies4.mp4" type="video/mp4">
        </video>
        <p>Showcase Your Skills</p>
      </div>
      <div>
        <!-- <video preload="none" muted playsinline webkit-playsinline class="video-control">
                <source src="{{ asset('videos/tradies2.webm') }}" type="video/webm">
                <source src="{{ asset('videos/tradies2.mp4')}}" type="video/mp4">
              </video>  -->
        <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
          <source src="https://thecoverhouse.com/images/tradies2.mp4" type="video/mp4">
        </video>
        <p class="work-week">Plan Your Week with Ease</p>
      </div>
      <div>
        <!-- <video preload="none" muted playsinline webkit-playsinline class="video-control">
                <source src="{{ asset('videos/tradies6.webm') }}" type="video/webm">
                <source src="{{ asset('videos/tradies6.mp4')}}" type="video/mp4">
              </video> -->
        <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
          <source src="https://thecoverhouse.com/images/tradies6.mp4" type="video/mp4">
        </video>
        <p>Connect, Collaborate & Grow</p>
      </div>
    </section>



    <div class="container text-center mt-3 tradies-site">
      <h2 class="mid-title dream-job">Your next household job begins today</h2>
      <form id="createform" class="regular-form search-form" action="{{ route('searchform') }}" method="get">
        <div class="row justify-content-center">
          <div class="col-xxl-8 col-xl-9 col-lg-10 col-12 search-outside">
            <div class="input-group job-search">
              <div class="search_iconbar">
                <i class="bi bi-search"></i>
                <input type="search" class="form-control search-jobs search-field" placeholder="Look up jobs near you" name="search_input">
              </div>
              <input type="search" class="form-control search-field location-select" placeholder="Location" name="search_location">
            </div>
            <input type="hidden" id="radio-one" name="search_type" value="1" />

            <button type="button " class="btn search-btn">Search</button>
          </div>
        </div>
      </form>
    </div>
    @if(count($jobs))
    <div class="container-fluid sliderdiv activeclass mb-5" id="jobs-home">
      <div class="marquee-container marquee-space swiper">
        <div class="marquee-track marquee-left swiper-wrapper job-card-1">

          @foreach($jobs as $_job)
          @php
          if($_job->image && (File::exists(public_path($_job->image)))){
          $thumbnail = asset($_job->image);
          }else{
          $thumbnail = asset('images/tradiies-job-default.webp');
          }
          @endphp

          <a class="job-outer swiper-slide" href="{{route('get.resultdetail', [$_job->id,1]) }}">
            <div class="scroll-card">

              <img src="{{$thumbnail}}" />
              <!-- <div class = "job_tag">
            <span>New</span>
          </div> -->
              <div class="job_card">
                <h3>{{$_job->SkillCategory?$_job->SkillCategory->name:'NA'}}</h3>
                <!-- <h5 class = "tradies">agency1</h5> -->
                <h4>${{$_job->minimum_price}} - ${{$_job->maximum_price}}</h4>
                <h5>{{$_job->location}}</h5>
                <!-- <h5>{{mb_strimwidth($_job->location,0,30,'...')}}</h5> -->
              </div>
            </div>
          </a>
          @endforeach


        </div>
      </div>
    </div>
    @endif


    <!--<section class="about-blue-footer about_skilled_trades mt-3">
        <div class="container">
        <div class="row about-blue-footer-right">
                <div class="col-xl-5 col-lg-4  col-md-0">
                  <div class="abt-img-box">
                  <img class="abt-mob-img" src="../images/psd-images/mobile1.png"/>
                  <img class="abt-arrow-img" src="../images/psd-images/roll-arrow.png"/>
                </div>
                    </div>
                    <div class="col-xl-7 col-lg-8 col-md-12 abt-blue-desc">
                    <h3>Linking trusted home-service experts with real-time job opportunities</h3>
                    <p>Celebrating diversity and inclusion in every home-service role</p>
                
                   
                        <div class="d-flex mt-lg-5 mt-4 about-download">
                            <a href="#">
                              <div class="applestore whitestore social-media-banners d-flex me-3 me-xs-0 mb-xs-3">
                                <i class="bi bi-apple blue-icn"></i>
                                <div>
                                  <p>Download on the</p>
                                  <b>Apple Store</b>
                                </div>
                              </div>
                  
                            </a>
                  
                            <a href="#">
                              <div class="googlestore social-media-banners d-flex">
                                <i class="bi bi-google-play white-icn"></i>
                                <div>
                                  <p>Get it on</p>
                                  <b>Google Play</b>
                                </div>
                              </div>
                  
                            </a>
                           
                            <a href="#"><img class="me-3 mb-2 social-media-banner" src="../images/googleplay-btn.svg"></a>

    </div>
                </div>
            </div>
        </div>

    </section> -->


    @endsection
    @section('script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  let mySwiper = null;
  let lastSlideIndex = 0;
  let lastWindowWidth = window.innerWidth;
  let lastOrientation = window.orientation || 0;
  let totalSlidesCache = null;

  /* ---------- CACHE DOM ---------- */
  const activeContainers = document.querySelectorAll('.activeclass');

  function countVisibleSlides() {
    if (totalSlidesCache !== null) return totalSlidesCache;

    let total = 0;
    activeContainers.forEach(container => {
      total += container.querySelectorAll('.swiper-slide').length;
    });

    totalSlidesCache = total;
    return total;
  }

  function isIOS() {
    return /iPad|iPhone|iPod/.test(navigator.userAgent);
  }

  /* ---------- SAFE ONE-TIME CLONING ---------- */
  function cloneSlidesOnce() {
    activeContainers.forEach(container => {
      const wrapper = container.querySelector('.swiper-wrapper');
      if (!wrapper || wrapper.dataset.cloned) return;

      [...wrapper.children].forEach(el => {
        wrapper.appendChild(el.cloneNode(true));
      });

      wrapper.dataset.cloned = "true";
    });
  }

  function initSwiper(initialIndex = 0) {
    const totalSlides = countVisibleSlides();
    if (!totalSlides) return;

    if (mySwiper) {
      try {
        lastSlideIndex = mySwiper.realIndex;
      } catch (e) {}
      mySwiper.destroy(true, true);
      mySwiper = null;
    }

    cloneSlidesOnce();

    mySwiper = new Swiper(".activeclass .swiper", {
      speed: 6000,
      initialSlide: initialIndex || lastSlideIndex,
      loop: true,
      loopedSlides: totalSlides,
      slidesPerView: "auto",
      allowTouchMove: false,
      simulateTouch: false,
      watchSlidesProgress: true,
      observer: true,
      observeParents: true,

      autoplay: {
        delay: 0,
        disableOnInteraction: false,
        pauseOnMouseEnter: false
      }
    });

    mySwiper.on('slideChange', () => {
      lastSlideIndex = mySwiper.realIndex;
    });
  }

  function ensureAutoplayRunning() {
    if (mySwiper && mySwiper.autoplay && !mySwiper.autoplay.running) {
      try {
        mySwiper.autoplay.start();
      } catch (e) {}
    }
  }

  /* ---------- INIT ---------- */
  document.addEventListener("DOMContentLoaded", () => {
    initSwiper(0);
  });

  /* ---------- SMART RESIZE (RAF OPTIMIZED) ---------- */
  let resizeScheduled = false;

  function checkAndReinit() {
    if (resizeScheduled) return;
    resizeScheduled = true;

    requestAnimationFrame(() => {
      const w = window.innerWidth;
      const o = window.orientation || 0;

      if (w !== lastWindowWidth || o !== lastOrientation) {
        initSwiper(lastSlideIndex);
        lastWindowWidth = w;
        lastOrientation = o;
      }

      resizeScheduled = false;
    });
  }

  window.addEventListener("resize", checkAndReinit);
  window.addEventListener("orientationchange", checkAndReinit);

  /* ---------- TAB VISIBILITY ---------- */
  document.addEventListener("visibilitychange", () => {
    if (document.visibilityState === "visible") {
      if (isIOS()) initSwiper(lastSlideIndex);
      else ensureAutoplayRunning();
    }
  });

  /* ---------- PAGE BACK CACHE FIX ---------- */
  window.addEventListener("pageshow", () => {
    setTimeout(() => ensureAutoplayRunning(), 150);
  });
</script>

    @endsection