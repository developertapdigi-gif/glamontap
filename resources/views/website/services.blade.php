@extends($layout)
@section('title')
Services
@endsection
@section('content')
<div class="top-content banner-outer">
        <div class="row skill-title text-center">
            <h1>
            Showcase your skills, get matched with clients, and expand your home-service opportunities.  
            </h1>
            <h3>  Create your profile and start today!</h3>

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
                    <h4 class="me-lg-5">Hire Trusted Home-Help in Minutes</h4>

                    <div class="about-detail me-lg-5">
                        <p class="mb-3"> Finding skilled home-service professionals shouldn’t be complicated. CoverHouse makes it simple by connecting you with verified helpers, managing your jobs, and streamlining communication—all in one place.</p>
                        
                        <div class = "service-box">
                        <div class="skill-tiles d-flex">
                            <i class="bi bi-list-check"></i>
                            <div>
                                <b class="black-tile-txt">Discover the Perfect Helper</b>
                                <p>Search from a wide range of professionals—plumbers, electricians, cleaners, caretakers, pest controllers, and more—ready to take on your tasks.</p>


                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-gear"></i>
                            <div>
                                <b class="black-tile-txt">Quick and Easy Hiring</b>
                                <p>Post your job in seconds and receive applications directly from qualified, verified professionals. No delays, no hassle.</p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-person-check-fill"></i>
                            <div>
                                <b class="black-tile-txt">Manage Your Jobs Seamlessly</b>
                                <p>Track, schedule, and monitor your home-service requests across multiple locations with our web portal or mobile app. Stay in control while helpers do the work.
                                </p>

                            </div>
                        </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 col-xl-7 col-md-12 col-sm-12">

                    <div class="about-mobile-background hire-trust">
                        <div class="about-left-banner service-right-sec pe-lg-0">
                            <img class="img-fluid desktop-image" src="../images/about-mobile-background.webp" width="100%" />
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
                    <h4>CoverHouse – Your All-in-One Home-Service Platform</h4>
                    <div class="about-detail">
                        <h5>A platform for skilled home-service professionals</h5>
                        <p class="mb-3">CoverHouse is your go-to platform for plumbers, electricians, cleaners, caretakers, pest control experts, 
                            and more. We empower home-service professionals by providing a space to showcase your skills, connect with clients, and 
                            grow your career. No matter your expertise, CoverHouse equips you with the right tools to expand your professional 
                            opportunities and build a trusted reputation.</p>

                        <div class = "service-box">
                            <div class="skill-tiles d-flex">
                            <i class="bi bi-link-45deg"></i>
                            <div>
                                <b class="black-tile-txt">Showcase Your Skills</b>
                                <p>Upload high-quality images of your work to attract clients, demonstrate your expertise, and build your credibility with reviews and ratings.</p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-tools"></i>
                            <div>
                                <b class="black-tile-txt">Get Matched Instantly</b>
                                <p>Receive job opportunities tailored to your skills, location, and availability.
                                </p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-phone-fill"></i>
                            <div>
                                <b class="black-tile-txt">Stay Connected on the Go</b>
                                <p>Our mobile-friendly app ensures you can access opportunities, communicate with clients, and manage your work anytime, anywhere.
                                </p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-phone-fill"></i>
                            <div>
                                <b class="black-tile-txt">Grow Your Network</b>
                                <p>Connect with verified clients, expand your professional circle, and build a strong network in the home-service industry.
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