@php
use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Skill House</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  @yield('css')

</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid">
      <div class="top-content  position-relative d-flex align-items-center justify-content-between">
        <a href="" class="logo d-flex align-items-center me-auto me-xl-0">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="{{ asset('images/logo.png') }}" alt="">

        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="index.html#hero" class="active">Home</a></li>
            <li><a href="index.html#about">About Us</a></li>
            <li class="dropdown"><a href="#"><span>Services</span></a></li>
            <li><a href="index.html#contact">Contact</a></li>
            @php
            if(Auth::id()){
            @endphp
             <li class="mobile-content"><a href="{{  route('dashboard') }}">Dashboard</a></li>
            @php
            }else{
            @endphp
            <li class="mobile-content"><a href="{{ route('login') }}">Login</a></li>
            <li class="mobile-content"><a href="{{ route('register') }}">Register</a></li>
            @php
            }
            @endphp

          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <div class="btn-getstarted mobile-hide">
            @php
            if(Auth::id()){
            @endphp
                <a href="{{ route('dashboard') }}"></ahref> <button type="button" class="btn btn-primary btn-right-margin">Dashboard</button></a>
            @php
            }else{
            @endphp
            <a href="{{ route('login') }}"></ahref> <button type="button" class="btn btn-primary btn-right-margin">Login</button></a>
            <a href="{{ route('register') }}"><button type="button" class="btn btn-primary btn-white">Register</button></a>
            @php
            }
            @endphp
         </div>
      </div>
    </div>
  </header>
  @yield('content')


  <section class="blue-footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-9 col-md-8 ">
          <h3>Hire with confidence and track your jobs</h3>
          <p>Explore platform to connect with tradesmen far or near you and manage your jobs easily.</p>
        </div>
        <div class="col-xl-3 col-md-4">
         <a href="#"> <button class="skill-primary-btn white-btn strt-now">Start Now <p class="blue-circle"><img
                src="{{ asset('images/icons/start-now.png') }}" /></p></button></a>

        </div>
      </div>
    </div>

  </section>
  <section class="skill-sub-footer ">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-3">
          <img src="{{ asset('images/logo.png') }}" />
        </div>
        <div class="col-md-6">
          <p>Customer Care - <b>789 756 9546 </b> | Need Support? - <b>support@skillhouse.com</b>
          </p>
        </div>
        <div class="col-md-3 skill-sub-footer-icons">
          <p class="blue-circle facebook-icn">
           <a href="#"><i class="bi bi-only-facebook"></i></a>
          </p>
          <p class="twitter-icn">
            <a href="#"><i class="bi bi-only-twitter"></i></a>
          </p>
          <p class="linkdin-icn">
            <a href="#"><i class="bi bi-only-linkdin"></i></a>
          </p>


        </div>
      </div>
    </div>
  </section>
  <footer class="skill-website-footer">
    <div class="container">
      <p class="footer-text-left">© 2024 SkillHouse. All Right Reserved.</p>
      <p class="footer-text-right">Community Guidelines</p>
    </div>
  </footer>




</body>
<script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
<!-- Main JS File -->
<script src="{{ asset('js/main.js') }}"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="{{ asset('js/slick.min.js') }}" type="text/javascript" charset="utf-8"></script>

<script>
$(document).on('ready', function() {
   $(".center_slider").slick({
        dots: true,
        infinite: true,
        centerMode: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        variableWidth: true
      });
    });


</script>

</html>
