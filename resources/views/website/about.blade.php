@extends($layout)
@section('title')
About Us
@endsection
@section('content')


<div class="top-content banner-outer">
        <div class="row skill-title text-center">
            <h1>
                About Us
            </h1>
            

            <ul class="skill-breadcrumbs d-flex justify-content-center">
                <li><a href="{{(session('employer_mode')?'/employer':'/')}}">Home</a> <i class="bi bi-arrow-right"></i></li>
                <li>About Us</li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <div class="mid-content skill-about-content">
            <div class="row about-cont">
                <div class="col-lg-6 col-sm-12 col-md-12">
                    <div class="contact-left-content about-mobile-background">
                     <div class="about-left-banner pe-0">
                        <img class="img-fluid desktop-image" src="../images/about-mobile-background.webp" />
                        <img class="overlap-image img-fluid phone-img" src="../images/about-mobile-1.webp" />
                     </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <h4>Welcome to CoverHouse</h4>

                    <div class="about-detail">
                        <h5>Your gateway to trusted home-service professionals and meaningful job opportunities!</h5>
                        <p>At CoverHouse, we believe in the value of skilled home-service professionals and the difference 
                            they make in everyday life. From fixing essential utilities to maintaining clean, safe, and functional 
                            homes, these experts are the backbone of our communities. Our mission is to connect talented professionals 
                            with opportunities that match their skills while giving clients easy access to reliable, verified helpers.</p>

                        <br>
                         <h5>Our Mission</h5>
                        <p>Our mission is simple: to create a seamless, trustworthy, and efficient platform where home-service professionals 
                            can find meaningful work and clients can hire the best talent for their needs. We strive to bridge the gap between 
                            demand and supply in the home-service industry, fostering a community built on trust and quality.</p>

                            <br>
                         <h5>Our Story</h5>
                        <p>CoverHouse was founded out of a passion for supporting skilled home-service professionals and recognizing their invaluable 
                            contributions. Our founder noticed the need for a centralised platform where helpers could showcase their skills, gain 
                            recognition, and easily connect with clients, while clients could access reliable, verified professionals quickly and efficiently.</p>

                    </div>

                </div>
            </div>

        </div>
    </div>
        <div class="container-fluid">
        <div class="mid-content skill-about-content">
            <div class="row about-cont align-items-center">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <h4>Why Choose CoverHouse</h4>

                    <div class="about-detail">
                        <ul>
                            <li><b>
                                Verified Professionals:</b> Every helper is background-checked and skilled.
                            </li>
                                <li><b>
                                Easy Access:</b> Find the right service for your home quickly and efficiently.
                            </li>
                                <li><b>
                                Grow Your Career:</b> Professionals can showcase work, receive ratings, and connect with more clients.
                            </li>
                                <li><b>
                                Mobile-Friendly:</b> Manage jobs, schedules, and communication anytime, anywhere.
                            </li>

                        </ul>
                    </div>

                </div>
                <div class="col-lg-6 col-sm-12 col-md-12">
                    <div class="about-mobile-background text-center">
                     <div class="about-left-banner pe-0">
                        <img class="img-fluid desktop-image" src="../images/psd-images/mobile1.webp" />
                     </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
   

  
    <section class="about-blue-footer about_skilled_trades mt-3">
        <div class="container">
        <div class="row about-blue-footer-right">
                <div class="col-xl-5 col-lg-4  col-md-0">
                  <div class="abt-img-box">
                  <img class="abt-mob-img" src="../images/psd-images/mobile1.webp"/>
                  <img class="abt-arrow-img" src="../images/psd-images/roll-arrow.png"/>
                </div>
                    </div>
                    <div class="col-xl-7 col-lg-8 col-md-12 abt-blue-desc">
                    <h3>Connecting top household talent with real jobs that are ready right now.</h3>
                    <p>We’re powering a more diverse, inclusive future for all.</p>
                
                   
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
                           
                            <!--<a href="#"><img class="me-3 mb-2 social-media-banner" src="../images/googleplay-btn.svg"></a>-->
                  
                          </div>
                </div>
            </div>
        </div>

    </section>

@endsection
