@extends($layout)
@section('title')
Services
@endsection
@section('content')
<div class="top-content banner-outer">
        <div class="row skill-title text-center">
            <h1>
             Create your profile and start today!
            </h1>

            <ul class="skill-breadcrumbs d-flex justify-content-center">
                <li><a href="{{(session('employer_mode')?'/employer':'/')}}">Home</a> <i class="bi bi-arrow-right"></i></li>
                <li>Service</li>
            </ul>
        </div>
    </div>

    <div class="service-secnd-section container-fluid">
        <div class="mid-content skill-about-content">
            <div class="row ">
                <div class="col-lg-6 col-xl-5 col-sm-12 col-md-12">
                    <h4 class="me-lg-5">Beauty Services at Your Doorstep</h4>

                    <div class="about-detail me-lg-5">
                        <p class="mb-3"> Skip the salon visit and enjoy professional beauty treatments at home. Book trusted beauty experts for makeup, hair, skincare, nail care, spa services and more whenever it suits you.</p>
                        
                        <div class = "service-box">
                        <div class="skill-tiles d-flex">
                            <i class="bi bi-list-check"></i>
                            <div>
                                <b class="black-tile-txt">Discover Your Perfect Beauty Expert</b>
                                <p>Choose from a wide range of services including makeup, hairstyling, facials, manicures, pedicures, waxing, bridal packages, spa therapies and more all delivered by experienced professionals.</p>


                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-gear"></i>
                            <div>
                                <b class="black-tile-txt">Quick & Hassle Free Booking</b>
                                <p>Book your preferred service in just a few clicks. Select your treatment, choose a convenient time slot and let our beauty experts come to you.</p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-person-check-fill"></i>
                            <div>
                                <b class="black-tile-txt">Trusted Professionals, Exceptional Results</b>
                                <p>Every beauty professional on our platform is carefully vetted to ensure quality, hygiene and customer satisfaction. Enjoy reliable service and a premium experience every time.
                                </p>

                            </div>
                        </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 col-xl-7 col-md-12 col-sm-12">

                    <div class="hire-trust">
                        <div class="about-left-banner service-right-sec pe-lg-0">
                            <img class="img-fluid" src="../images/about-mobile-background.webp" width="100%" />
                            <img id="scnd-banner-img" class="overlap-image scnd-banner-img img-fluid" src="../images/screen_1.webp" />
                        </div>
                    </div>



                </div>
            </div>



            <div class="row service-section-margin ">
                <div class="col-lg-6 col-xl-5 col-sm-12 col-md-12">
                    <div class="contact-left-content about-mobile-background">
                        <div class="about-left-banner pe-0">
                            <img class="img-fluid desktop-image" src="../images/about-mobile-background.webp" />
                            <img class="overlap-image frst-banner-img img-fluid" src="../images/about-mobile-1.webp" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-7 col-md-12 col-sm-12">
                    <h4>Glam On Tap – Empowering Beauty Professionals</h4>
                    <div class="about-detail">
                        <h5>A platform designed for talented beauty experts.</h5>
                        <p class="mb-3">Glam On Tap helps makeup artists, hairstylists, nail technicians, beauticians, spa therapists and skincare professionals connect with clients who value quality beauty services. Whether you're building your personal brand or expanding your clientele, our platform gives you the tools to grow your beauty business with confidence.</p>

                        <div class = "service-box">
                            <div class="skill-tiles d-flex">
                            <i class="bi bi-link-45deg"></i>
                            <div>
                                <b class="black-tile-txt">Showcase Your Talent</b>
                                <p>Create a stunning profile, upload your portfolio, display your best work and collect client reviews that build trust and attract more bookings.</p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-tools"></i>
                            <div>
                                <b class="black-tile-txt">Get Bookings That Match Your Expertise</b>
                                <p>Receive service requests based on your specialties, location and availability, helping you connect with the right clients at the right time.
                                </p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-phone-fill"></i>
                            <div>
                                <b class="black-tile-txt">Manage Your Business Effortlessly</b>
                                <p>Track appointments, manage schedules, communicate with clients and stay organized through our easy to use platform.
                                </p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-phone-fill"></i>
                            <div>
                                <b class="black-tile-txt">Build Your Personal Brand</b>
                                <p>Strengthen your reputation with verified reviews, repeat customers and a professional online presence that helps you stand out in the beauty industry.
                                </p>

                            </div>
                        </div>
                        <div class="skill-tiles d-flex">
                            <i class="bi bi-phone-fill"></i>
                            <div>
                                <b class="black-tile-txt">Grow Your Career on Your Terms</b>
                                <p>Whether you're a freelance artist, salon professional or beauty entrepreneur, Glam On Tap provides opportunities to increase your visibility, expand your client base and grow your income.
                                </p>

                            </div>
                        </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

       

        
    </div>
        </div>



 

@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $('#monthly').click(function(){
        $('#monthly').removeClass('white-btn').addClass('blue-button');
        $('#yearly').removeClass('blue-button').addClass('white-btn');
        $('.package-bottom-detail #yearly_price').addClass('d-none');
        $('.package-bottom-detail #monthly_price').removeClass('d-none');
    });
    $('#yearly').click(function(){
        $('#yearly').removeClass('white-btn').addClass('blue-button');
        $('#monthly').removeClass('blue-button').addClass('white-btn');
        const elements = document.querySelectorAll('#yearly_price');
        const elements1 = document.querySelectorAll('#monthly_price');
        elements.forEach(element => {
                element.classList.remove('d-none');  // Remove the old class
                elements1.forEach(element1 =>{
                    element1.classList.add('d-none');     // Add the new class
                });
            });
    });
});
</script>
@endsection