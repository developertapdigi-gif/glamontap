@extends($layout)
@section('title')
About Us
@endsection
@section('content')


<div class="top-content banner-outer">
    <div class="row skill-title text-center">
        <h1 class="heading-size">
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
        <div class="row about-cont align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12">
                <div class="contact-left-content about-mobile-background">
                    <div class="about-left-banner pe-0">
                        <img class="img-fluid" src="../images/about-glam.webp" width="100%" />
                        <!-- <img class="img-fluid desktop-image" src="../images/about-mobile-background.webp" />
                        <img class="overlap-image img-fluid phone-img" src="../images/about-mobile-1.webp" /> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <h4 class ="heading-size">About Glam On Tap</h4>

                <div class="about-detail">
                    <h5 heading-size>Beauty, Wellness & Confidence Delivered to Your Doorstep</h5>
                    <p>At Glam On Tap, we believe self-care should be effortless, accessible and tailored to your lifestyle. Our mission is to bring premium beauty and wellness services directly to your home, allowing you to enjoy professional treatments without the inconvenience of salon visits.
                        Whether you're preparing for a special occasion, maintaining your beauty routine or simply taking time for yourself, Glam On Tap connects you with skilled and verified beauty professionals who deliver exceptional service in the comfort of your own space.
                    </p>

                    <br>
                    <h5 class ="heading-size">Our Story</h5>
                    <p>Glam On Tap was created with a simple vision: to redefine the beauty experience by combining convenience, professionalism and personalized care. We recognized that busy schedules, travel time and long salon waits often make self-care difficult to prioritize.
                        By bringing trusted beauty experts directly to clients, we make it easier than ever to access high-quality beauty services whenever and wherever they're needed.</p>

                    <br>
                    <h5 class ="heading-size">Our Mission</h5>
                    <p>To make professional beauty and wellness services accessible, convenient and reliable while empowering beauty professionals to grow and succeed.</p>

                    <br>
                    <h5 class ="heading-size">Our Vision</h5>
                    <p>To become the most trusted destination for at home beauty and wellness services, transforming the way people experience self-care and beauty.</p>

                </div>

            </div>
        </div>

    </div>
</div>
<div class="container-fluid">
    <div class="mid-content skill-about-content align-items-center">
        <div class="row about-cont align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <h4 class ="heading-size">What We Offer</h4>

                <div class="about-detail">
                    <h5 class ="heading-size">Our platform provides a wide range of at home beauty and wellness services, including:</h5>
                    <ul>
                        <li>
                            Professional Makeup Services
                        </li>
                        <li>
                            Hair Styling & Hair Treatments

                        </li>
                        <li>Facials & Skincare Treatments
                        </li>
                        <li>Facials & Skincare Treatments
                        </li>
                        <li>Waxing & Grooming Services
                        </li>
                        <li>Manicures & Pedicures
                        </li>
                        <li>Bridal & Event Beauty Packages</li>
                        <li>Spa & Wellness Treatments</li>
                    </ul>
                </div>
                <h6>Every service is designed to deliver salon-quality results while providing the comfort, privacy and flexibility of an at home experience.</h6>

            </div>
            <div class="col-lg-6 col-sm-12 col-md-12">
                <div class="text-center">
                    <div class="about-left-banner pe-0">
                        <!-- <img class="img-fluid" src="../images/psd-images/mobile1.webp" /> -->
                        <img class="img-fluid" src="../images/offer.webp" width="100%" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container-fluid">
    <div class="mid-content skill-about-content align-items-center choose_glam">
        <div class="row about-cont align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12">
                <div class="text-center">
                    <div class="about-left-banner pe-0">
                        <!-- <img class="img-fluid" src="../images/psd-images/mobile1.webp" /> -->
                        <img class="img-fluid" src="../images/choose-glam.webp" width="100%" />
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <h4 class ="heading-size">Why Choose Glam On Tap?</h4>

                <div class="about-detail">
                    <ul>
                        <li><b>
                                Verified Beauty Experts:</b> Experienced and trusted professionals dedicated to delivering exceptional beauty services.
                        </li>
                        <li><b>
                                Salon Quality at Home:</b> Enjoy premium beauty and wellness treatments in the comfort of your own space.

                        </li>
                        <li><b>
                                Convenient Booking:</b> Schedule appointments easily at a time that works best for you.
                        </li>
                        <li><b>
                                Safe & Hygienic Services:</b>High standards of cleanliness, professionalism and customer care.
                        </li>
                        <li><b>
                                Personalized Experience:</b>Beauty services tailored to your unique style, preferences and needs.
                        </li>
                        <li><b>
                                Reliable & Hassle-Free:</b>Skip travel and waiting times while receiving top-quality beauty care at your doorstep.
                        </li>
                    </ul>
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
                    <img class="abt-mob-img" src="../images/psd-images/mobile1.webp" />
                    <img class="abt-arrow-img" src="../images/psd-images/roll-arrow.png" />
                </div>
            </div>
            <div class="col-xl-7 col-lg-8 col-md-12 abt-blue-desc">
                <h3 class="heading-size">Beauty Expertise, Delivered to Your Doorstep</h3>
                <p>Connecting trusted beauty professionals with clients who value convenience, quality and personalized care.
                    Empowering beauty experts. Elevating self care experiences.</p>


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