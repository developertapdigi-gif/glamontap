@extends('frontend.website.layouts.master')

  <div class="top-content banner-outer">
    <div class="row mt-5  banner">
      <div class="col-md-6 col-sm-12">
        <h1>Connecting skilled trades of Australia to their community</h1>
        <h3>Share yours skills and get paid</h3>
        <div class="d-md-flex social-ads">
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
            <div class="googlestore social-media-banners d-flex">
              <i class="bi bi-google-play white-icn"></i>
              <div>
                <p>Get it on</p>
                <b>Google Play</b>
              </div>
            </div>

          </a>

          <!--<a href="#"><img class="me-3 mb-2 social-media-banner" src="{{ asset('images/googleplay-btn.svg') }}"></a>-->

        </div>
        <div class="col-md-5">

        </div>
      </div>

    </div>
  </div>
  <section class="empower-tools container">
    <h2 class="mid-title">
      Empowering the community with the tools to thrive in todays competition
    </h2>
    <div class="empower-images  justify-content-center desktop-content1 row">
      <div class="col-lg-3"><img src="{{ asset('images/psd-images/screen_1.png') }}" />
        <p>Get connected to people</p>
      </div>
      <div class="col-lg-3"><img src="{{ asset('images/psd-images/screen_1.png') }}" />
        <p>Showcase your Craft</p>
      </div>
      <div class="col-lg-3"><img src="{{ asset('images/psd-images/screen_1.png') }}" />
        <p>Find jobs effortlessly and receive real time notifications</p>
      </div>
      <div class="col-lg-3"><img src="{{ asset('images/psd-images/screen_1.png') }}" />
        <p>Get connected to people</p>
      </div>
    </div>


    <div id="carouselExampleControls" class="carousel slide mobile-content1" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="100000000">
          <div>
            <img class="d-block" src="{{ asset('images/psd-images/screen_1.png') }}"  />
            <p>Find jobs effortlessly and receive real time notifications</p>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="100000000">
          <div>
            <img class="d-block" src="{{ asset('images/psd-images/screen_1.png') }}" />
            <p>Find jobs effortlessly and receive real time notifications</p>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="100000000">
          <div>
            <img class="d-block" src="{{ asset('images/psd-images/screen_1.png') }}"/>
            <p>Find jobs effortlessly and receive real time notifications</p>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="100000000">
          <div>
            <img class="d-block" src="{{ asset('images/psd-images/screen_1.png') }}"/>
            <p>Get connected to people</p>
          </div>
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-compact-left" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-compact-right" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>

    </div>

  </section>

 <section class="slider-section"> 
    <h2 class="mid-title">
      Explore the Platform To Connect With Skilled Tradesmen
    </h2>
    <p style="font-size: 20px; color:#636364;text-align: center; margin-bottom: 65px;">Discover a Hub to Connect with
      Right Fit Tradesmen for Your Projects</p>
    <div class="container-fluid text-center my-3">


        <!-----------------new slider--------->
        <section class="center_slider slider">
          <div>
            <img src="{{ asset('images/slider-img-1.png') }}">
          </div>
          <div>
            <img src="{{ asset('images/slider-img-2.png') }}">
          </div>
          <div>
            <img src="{{ asset('images/slider-img-3.png') }}">
          </div>

        </section>

      </div>
    </div>

  </section>
