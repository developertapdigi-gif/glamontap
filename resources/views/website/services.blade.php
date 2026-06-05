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
            <div class="row align-items-center">
                <div class="col-lg-6 col-xl-5 col-sm-12 col-md-12">
                    <h4 class="me-lg-5">Beauty Services at Your Doorstep</h4>

                    <div class="about-detail me-lg-5">
                        <p class="mb-3 main-content"> Skip the salon wait and enjoy professional beauty services in the comfort of your home. Book trusted experts for makeup, hair, skincare and more all tailored to you.</p>
                        
                        <div class = "service-box">
                        <div class="skill-tiles d-flex">
                            <i class="bi bi-list-check"></i>
                            <div>
                                <b class="black-tile-txt">Verified Experts</b>
                                <p>Trained & verified beauty professionals.</p>


                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-gear"></i>
                            <div>
                                <b class="black-tile-txt">Easy Booking</b>
                                <p>Book in minutes, anytime, anywhere..</p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex mb-0">
                            <i class="bi bi-person-check-fill"></i>
                            <div>
                                <b class="black-tile-txt">Safe & Hygienic</b>
                                <p>Hygiene-first services you can trust.
                                </p>

                            </div>
                        </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 col-xl-7 col-md-12 col-sm-12">

                    <div class="hire-trust">
                        <div class="about-left-banner service-right-sec pe-lg-0">
                            <!-- <img class="img-fluid" src="../images/about-mobile-background.webp" width="100%" />
                            <img id="scnd-banner-img" class="overlap-image scnd-banner-img img-fluid" src="../images/screen_1.webp" /> -->
                            <img class="img-fluid" src="../images/beauty-img.webp" width="100%" />
                        </div>
                    </div>



                </div>
            </div>



            <div class="row service-section-margin align-items-center">
                <div class="col-lg-6 col-xl-5 col-sm-12 col-md-12">
                    <div class="contact-left-content about-mobile-background">
                        <div class="about-left-banner pe-0">
                            <!-- <img class="img-fluid desktop-image" src="../images/about-mobile-background.webp" />
                            <img class="overlap-image frst-banner-img img-fluid" src="../images/about-mobile-1.webp" /> -->
                            <img class="img-fluid" src="../images/beauty-img2.webp" width="100%" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-7 col-md-12 col-sm-12">
                    <h4>Glam On Tap – Empowering Beauty Professionals</h4>
                    <div class="about-detail">
                        <h5>A platform designed for talented beauty experts.</h5>
                        <p class="mb-3">Join our platform and unlock endless opportunities. Showcase your talent, manage bookings, grow your client base and build a brand you love.</p>

                        <div class = "service-box">
                            <div class="skill-tiles d-flex">
                            <i class="bi bi-link-45deg"></i>
                            <div>
                                <b class="black-tile-txt">Showcase Your Talent</b>
                                <p>Create a stunning profile and highlight your skills, portfolio & experience.</p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-tools"></i>
                            <div>
                                <b class="black-tile-txt">Manage Everything</b>
                                <p>Handle bookings, schedule and clients, all in one place.
                                </p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-phone-fill"></i>
                            <div>
                                <b class="black-tile-txt">Get More Bookings</b>
                                <p>Receive service requests that match your expertise & availability.
                                </p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex mb-0">
                            
                             <img class="img-fluid" src="../images/network.svg" />
                            <div>
                                <b class="black-tile-txt">Grow Your Brand</b>
                                <p>Build your reputation and grow your business with confidence.
                                </p>

                            </div>
                        </div>
                        <!-- <div class="skill-tiles d-flex">
                             <img class="img-fluid" src="../images/career.svg" />
                            <div>
                                <b class="black-tile-txt">Grow Your Career on Your Terms</b>
                                <p>Whether you're a freelance artist, salon professional or beauty entrepreneur, Glam On Tap provides opportunities to increase your visibility, expand your client base and grow your income.
                                </p>

                            </div>
                        </div> -->
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