@extends($layout)
@section('title')
Services
@endsection
@section('content')
<div class="top-content banner-outer">
    <div class="row skill-title text-center">
        <h1 class="heading-size">
            Create your profile and start today!
        </h1>

        <ul class="skill-breadcrumbs d-flex justify-content-center">
            <li><a href="{{(session('employer_mode')?'/employer':'/')}}">Home</a> <i class="bi bi-arrow-right"></i></li>
            <li>Service</li>
        </ul>
    </div>
</div>
<div class="container mid-content">
    <div class="row align-items-center">
        <div class="col-lg-6 col-sm-12 col-md-12">
            <h4 class="me-lg-5 heading-size">Beauty Services <br> <span class="color-text">Designed For You!</span></h4>

            <div class="about-detail me-lg-3">
                <p class="mb-3 main-content"> Skip the salon wait and enjoy professional beauty services in the comfort of your home. Book trusted experts for makeup, hair, skincare and more all tailored to you.</p>

                <!-- <div class="service-box">
                        <div class="skill-tiles d-flex">
                            <i class="bi bi-list-check"></i>
                            <div>
                                <b class="black-tile-txt heading-size">Verified Experts</b>
                                <p>Trained & verified beauty professionals.</p>


                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-gear"></i>
                            <div>
                                <b class="black-tile-txt heading-size">Easy Booking</b>
                                <p>Book in minutes, anytime, anywhere..</p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex mb-0">
                            <i class="bi bi-person-check-fill"></i>
                            <div>
                                <b class="black-tile-txt heading-size">Safe & Hygienic</b>
                                <p>Hygiene-first services you can trust.
                                </p>

                            </div>
                        </div>
                    </div> -->
                <div class="hero-features">
                    <div class="hero-feature">
                        <div class="hero-feature-icon purple">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div>
                            <div class="hero-feature-title">Verified Experts</div>
                            <div class="hero-feature-desc">Trusted & skilled professionals</div>
                        </div>
                    </div>
                    <div class="hero-feature">
                        <div class="hero-feature-icon pink">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="hero-feature-title">Easy Booking</div>
                            <div class="hero-feature-desc">Book in minutes, anytime, anywhere</div>
                        </div>
                    </div>
                    <div class="hero-feature">
                        <div class="hero-feature-icon orange">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <div>
                            <div class="hero-feature-title">Safe & Hygienic</div>
                            <div class="hero-feature-desc">Hygiene-first services you can rely on</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">

            <div class="hire-trust">
                <div class="about-left-banner service-right-sec pe-lg-0">
                    <!-- <img class="img-fluid" src="../images/about-mobile-background.webp" width="100%" />
                            <img id="scnd-banner-img" class="overlap-image scnd-banner-img img-fluid" src="../images/screen_1.webp" /> -->
                    <img class="img-fluid" src="../images/beauty-img.webp" width="100%" />
                </div>
            </div>



        </div>
    </div>
</div>

<div class="mid-content container">
        <div class="text-center mb-4">
      <h2 class="fw-bold mb-3 font-heading heading-size">Explore Our Services</h2>
      <p class="text-muted">Find the perfect service that suits your beauty needs.</p>
    </div>
    <div class="card-grid beauty-category">
        @foreach ($skills as $skill)
        <div class="card">
            <a href="{{ route('skills.details', ['skillId' => $skill->id]) }} class=" text-decoration-none">
                {{-- <a href="{{ route('skills.details', ['skillId' => $skill->id]) }}" class="text-decoration-none"></a> --}}
            <div class="category-card shadow-sm h-100">
                <div class="cat-icon ci-green">
                    <img src="{{ asset($skill->image) }}" alt="{{ $skill->name }}" class="img-fluid">
                </div>
                <h5 class="font-heading">{{ $skill->name }}</h5>
            </div>
            </a>

        </div>
        @endforeach
    </div>
</div>
<div class="service-secnd-section container-fluid">
    <div class="mid-content skill-about-content doorstep-service">



        <div class="row align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12">
                <div class="contact-left-content about-mobile-background">
                    <div class="about-left-banner pe-0">
                        <!-- <img class="img-fluid desktop-image" src="../images/about-mobile-background.webp" />
                            <img class="overlap-image frst-banner-img img-fluid" src="../images/about-mobile-1.webp" /> -->
                        <img class="img-fluid" src="../images/beauty-img2.webp" width="100%" />
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
                <h4 class="heading-size">Glam On Tap – Empowering Beauty Professionals</h4>
                <div class="about-detail">
                    <h5 class="heading-size">A platform designed for talented beauty experts.</h5>
                    <p class="mb-3">Join our platform and unlock endless opportunities. Showcase your talent, manage bookings, grow your client base and build a brand you love.</p>

                    <!-- <div class="service-box">
                        <div class="skill-tiles d-flex">
                            <i class="bi bi-link-45deg"></i>
                            <div>
                                <b class="black-tile-txt heading-size">Showcase Your Talent</b>
                                <p>Create a stunning profile and highlight your skills, portfolio & experience.</p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-tools"></i>
                            <div>
                                <b class="black-tile-txt heading-size">Manage Everything</b>
                                <p>Handle bookings, schedule and clients, all in one place.
                                </p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-phone-fill"></i>
                            <div>
                                <b class="black-tile-txt heading-size">Get More Bookings</b>
                                <p>Receive service requests that match your expertise & availability.
                                </p>

                            </div>
                        </div>

                        <div class="skill-tiles d-flex mb-0">

                            <img class="img-fluid" src="../images/network.svg" />
                            <div>
                                <b class="black-tile-txt heading-size">Grow Your Brand</b>
                                <p>Build your reputation and grow your business with confidence.
                                </p>

                            </div>
                        </div>
                    </div> -->
                    <div class="row g-4 beauty-service-features">
                        <div class="col-md-6 d-flex gap-3">
                            <div class="pro-feature-icon"><i class="fa-regular fa-user"></i></div>
                            <div>
                                <h4 class="fw-semibold text-main mb-1" style="font-size: 16px;">Showcase Your Talent</h4>
                                <p class="text-muted-custom mb-0" style="font-size: 14px; line-height: 1.4;">Create a stunning profile and highlight your skills, portfolio & experience.</p>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex gap-3">
                            <div class="pro-feature-icon"><i class="fa-solid fa-gear"></i></div>
                            <div>
                                <h4 class="fw-semibold text-main mb-1" style="font-size: 16px;">Manage Everything</h4>
                                <p class="text-muted-custom mb-0" style="font-size: 14px; line-height: 1.4;">Handle bookings, schedule and clients, all in one place.</p>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex gap-3">
                            <div class="pro-feature-icon"><i class="fa-regular fa-calendar-check"></i></div>
                            <div>
                                <h4 class="fw-semibold text-main mb-1" style="font-size: 16px;">Get More Bookings</h4>
                                <p class="text-muted-custom mb-0" style="font-size: 14px; line-height: 1.4;">Receive service requests that match your expertise & availability.</p>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex gap-3">
                            <div class="pro-feature-icon"><i class="fa-regular fa-chart-bar"></i></div>
                            <div>
                                <h4 class="fw-semibold text-main mb-1" style="font-size: 16px;">Grow Your Brand</h4>
                                <p class="text-muted-custom mb-0" style="font-size: 14px; line-height: 1.4;">Build your reputation and grow your business with confidence.</p>
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
        $('#monthly').click(function() {
            $('#monthly').removeClass('white-btn').addClass('blue-button');
            $('#yearly').removeClass('blue-button').addClass('white-btn');
            $('.package-bottom-detail #yearly_price').addClass('d-none');
            $('.package-bottom-detail #monthly_price').removeClass('d-none');
        });
        $('#yearly').click(function() {
            $('#yearly').removeClass('white-btn').addClass('blue-button');
            $('#monthly').removeClass('blue-button').addClass('white-btn');
            const elements = document.querySelectorAll('#yearly_price');
            const elements1 = document.querySelectorAll('#monthly_price');
            elements.forEach(element => {
                element.classList.remove('d-none'); // Remove the old class
                elements1.forEach(element1 => {
                    element1.classList.add('d-none'); // Add the new class
                });
            });
        });
    });
</script>
@endsection