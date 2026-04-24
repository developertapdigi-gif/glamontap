@php
use App\Models\Setting;
$model = Setting::setting();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="{{ $model['favicon'] }}" rel="icon" type="image/x-icon">
  <title>About Us | {{$model['name_of_website']}}</title>
  <meta name="robots" content="noindex, nofollow, noarchive">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  <link href="{{ asset('css/slider.css') }}" rel="stylesheet">
  <link href="{{ asset('fortawesome/css/all.min.css') }}" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}">
  @yield('css')

</head>

<body class="index-page">
 
<div class="top-content">
        <div class="row skill-title text-center mb-4">
            <h1 class="mb-4">
                About Us
            </h1>
        </div>
    </div>
    <div class="container">
        <div class="mid-content skill-about-content no-side-padding">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-12">
                    <div class="contact-left-content about-mobile-background">
                     <div class="about-left-banner pe-0">
                        <img class="img-fluid desktop-image" src="../images/about-mobile-background.png" />
                        <img class="overlap-image img-fluid" src="../images/about-mobile-1.png" />
                     </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <h4>Welcome to Tradehook</h4>

                    <div class="about-detail">
                        <h5>Your gateway to quality tradespeople services and job opportunities!</h5>
                        <p>At Tradehook, we believe in the power of skilled tradespeople and the difference they make in our daily lives. From crafting beautiful homes to fixing essential utilities, tradies are the backbone of our communities. We are dedicated to connecting these talented professionals with the opportunities they deserve and providing clients with access to the best tradesmen for their needs</p>

                        <br>
                         <h5>Our Mission</h5>
                        <p>Our mission is simple yet profound: to create a seamless, reliable, and efficient platform where tradies can find meaningful work and companies can hire the best talent for their projects. We aim to bridge the gap between demand and supply in the trades industry, fostering a community of trust, excellence, and mutual benefit.</p>

                            <br>
                         <h5>Our Story</h5>
                        <p>Tradehook was born out of a passion for supporting skilled workers and recognizing their invaluable contributions. Our founder saw a need for a centralised platform that could not only help tradies showcase their skills but also streamline the job-finding process.</p>

                    </div>

                </div>
            </div>

          
                <div class="clients-ads">
                <div class="col-md-12 text-center">
                    <div class="sub-heading-logo">
                    Building trust around Australia…
                    </div>  
                </div>
                <div class="client-logo-section mb-5">
                <div class="row">
                    <div class=""> Collaborations coming soon..</div>
               
                </div>
            </div>
            </div>
        </div>
    </div>
   


 
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="{{ asset('js/slick.min.js') }}" type="text/javascript" charset="utf-8"></script>
@yield('script')
<div class="loader" style="display: none;"></div>
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
setTimeout(function() { $(".alert").alert('close'); },5000);
</script>
</body>
</html>

