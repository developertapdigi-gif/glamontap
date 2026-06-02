@extends('website.layouts.master')
@section('title')
Home
@endsection
@section('content')

<!-- HERO -->
<section class="hero-section-premium bg-moving-gradient overflow-hidden">

  <div class="container position-relative z-3">
    <div class="row align-items-center">
      <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1200">
        <h1 class="display-5 fw-bold mb-4 font-heading" style="color: var(--bs-primary);">Empowering the World of <span class="font-serif italic text-accent" style="color: var(--accent) !important;">Beauty & Style</span></h1>
        <p class="lead text-dark mb-5 fs-5 opacity-75">Discover elite career opportunities in salons, spas, and fashion. <br>Join the community of top-tier beauty professionals today.</p>

        <div class="glass-search-container p-3 p-md-4" data-aos="fade-up" data-aos-delay="400">
          <form action="{{ route('searchform') }}" class="row align-items-center">
            <div class="col-lg-3">
              <div class="search-input-group">
                <i class="fas fa-search text-muted"></i>
                <input type="text" id="heroSearchInput" name="search_input" class="form-control" placeholder="Job title">
              </div>
            </div>
            <div class="col-lg-3 border-start-md">
              <div class="search-input-group">
                <i class="fas fa-map-marker-alt text-muted"></i>
                <input type="search" class="form-control search-field location-select" placeholder="Location" name="search_location">
                {{-- <select id="heroLocationInput" class="form-select">
                  <option selected>All Cities</option>
                  <option>New York</option>
                  <option>London</option>
                  <option>Paris</option>
                  <option>Milan</option>
                </select> --}}
              </div>
            </div>
            <div class="col-lg-3 border-start-md pe-0">
              <div class="search-input-group">
                <i class="fas fa-briefcase text-muted"></i>
                <select class="form-select" name="search_category">
                  <option selected>All Categories</option>
                  @foreach ($skills as $skill)
                  <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                  @endforeach

                </select>
              </div>
            </div>
            <input type="hidden" id="radio-one" name="search_type" value="1" />
            <div class="col-lg-3">
              <button type="submit" id="heroSearchBtn" class="btn btn-primary rounded-pill shadow-sm pulse-primary shine-effect">
                Find Jobs
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="hero-visual-wrapper" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200">
          <div class="main-hero-img-container position-relative">
            <img src="images/beauty_hero.png" alt="Luxury Salon" class="img-fluid main-hero-img">
            <!-- Play Button -->
            <div class="hero-video-play-btn" data-bs-toggle="modal" data-bs-target="#videoModal">
              <i class="fas fa-play"></i>
            </div>
            <div class="floating-badge-hero pos-tr animate-float"><i class="fas fa-star text-warning"></i> 4.9/5 Rating</div>
            <div class="floating-badge-hero pos-bl animate-float-delayed"><i class="fas fa-check-circle text-success"></i> Verified Salons</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Modal -->
<div class="modal fade" id="videoModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <button type="button"
        class="btn-close position-absolute top-0 end-0"
        data-bs-dismiss="modal"
        aria-label="Close"
        style="z-index:9999;">
      </button>

      <div class="modal-body p-0">
        <iframe src="https://player.vimeo.com/video/1197605509?autoplay=1"
          width="100%"
          height="500"
          frameborder="0"
          allow="autoplay; fullscreen; picture-in-picture"
          allowfullscreen>
        </iframe>
      </div>

    </div>
  </div>
</div>

<!-- CSS: Section 7 - CONTENT SECTIONS (Category Cards) | Classes: .category-card, .cat-icon, .ci-purple, .ci-red, .ci-orange, .ci-green, .ci-blue -->
<section class="section-space">
  <div class="container">
    <div class="text-center mb-4" data-aos="fade-up">
      <h2 class="fw-bold mb-3 font-heading">Browse Beauty Specialties</h2>
      <p class="text-muted">Explore high-demand roles across all sectors of the industry.</p>
    </div>
    <div class="row g-4 beauty-category">
      @foreach ($skills as $skill)
      <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="100">
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

      {{-- <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="200">
        <a href="job-list.html?q=Makeup" class="text-decoration-none">
          <div class="category-card shadow-sm h-100">
            <div class="cat-icon ci-green"><i class="fas fa-paint-brush"></i></div>
            <h6 class="font-heading">Makeup Artists</h6>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="300">
        <a href="job-list.html?q=Nails" class="text-decoration-none">
          <div class="category-card shadow-sm h-100">
            <div class="cat-icon ci-green"><i class="fas fa-hand-sparkles"></i></div>
            <h6 class="font-heading">Nail Technicians</h6>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="400">
        <a href="job-list.html?q=Esthetician" class="text-decoration-none">
          <div class="category-card shadow-sm h-100">
            <div class="cat-icon ci-green icon-size">
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="31" height="31" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                <g>
                  <path d="M46.5 22.5v4.693c0 .422-.029.842-.057 1.262 1.719-.22 3.057-1.677 3.057-3.455 0-1.379-1.121-2.5-2.5-2.5zM45.762 35.464l-3.638-4.103c-2.335 1.984-3.854 4.63-4.376 7.575l5.374 1.099zM48.712 38.356l-2.224-2.15-2.36 4.087 2.974.851z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                  <path d="M41.798 30.334c.209-.166.58-.193.755.004l2.062 2.325c.576-1.776.885-3.609.885-5.469v-4.7a19.437 19.437 0 0 1-12.14-4.669L32 16.658l-1.36 1.166a19.437 19.437 0 0 1-12.14 4.669v4.7a17.734 17.734 0 0 0 6.689 13.917c1.925 1.541 4.344 2.39 6.811 2.39s4.886-.849 6.811-2.39c.296-.236.589-.491.879-.756l-2.611-.534a.501.501 0 0 1-.395-.56 13.791 13.791 0 0 1 5.114-8.926zm-19.075-3.918a.5.5 0 0 1 .554-.832 4.897 4.897 0 0 0 5.445 0 .499.499 0 1 1 .554.832 5.9 5.9 0 0 1-6.553 0zm9.554 8.168a.5.5 0 1 1-.554.832l-3-2a.499.499 0 0 1 0-.832l.504-.336A5.096 5.096 0 0 0 31.5 28a.5.5 0 0 1 1 0 6.094 6.094 0 0 1-2.6 4.999zm2.446-8.168a.5.5 0 0 1 .554-.832 4.89 4.89 0 0 0 5.445 0 .5.5 0 1 1 .554.832 5.897 5.897 0 0 1-6.553 0z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                  <path d="M34.011 17.064A18.43 18.43 0 0 0 46 21.5h1c.429 0 .836.088 1.217.231A5.47 5.47 0 0 0 48.5 20c0-.494-.031-.981-.074-1.464-.805.194-1.622.304-2.437.304-1.663 0-3.313-.4-4.817-1.186l-.403-.211a.5.5 0 0 1 .463-.887l.403.211a9.38 9.38 0 0 0 6.662.778C47.268 10.695 42.033 5.204 35.3 3.832a11.968 11.968 0 0 0 5.923 6.72.5.5 0 1 1-.446.895 12.965 12.965 0 0 1-6.589-7.785A16.604 16.604 0 0 0 32 3.5c-.639 0-1.266.045-1.886.116a17.108 17.108 0 0 0 4.24 7.03.5.5 0 0 1-.708.708 18.11 18.11 0 0 1-4.531-7.585c-1.22.216-2.399.553-3.511 1.022a42.542 42.542 0 0 0 6.752 10.855zM56.25 46.299c.349.199.753.254 1.138.149a1.49 1.49 0 0 0 .911-.698 1.504 1.504 0 0 0-.549-2.05l-8.228-4.75-1.5 2.599zM17 21.5h1c4.395 0 8.652-1.575 11.99-4.436l1.313-1.125a43.866 43.866 0 0 1-1.976-2.541l-.527.702a8.541 8.541 0 0 1-6.8 3.4.5.5 0 0 1 0-1 7.535 7.535 0 0 0 6-3l.6-.8a.503.503 0 0 1 .146-.131 43.153 43.153 0 0 1-1.401-2.188l-.572.567A5.33 5.33 0 0 1 23 12.5a.5.5 0 0 1 0-1 4.336 4.336 0 0 0 3.07-1.263l.752-.745a43.89 43.89 0 0 1-2.12-4.268C19.259 7.924 15.5 13.524 15.5 20c0 .592.097 1.171.284 1.73.38-.142.787-.23 1.216-.23zM17.546 28.454a18.85 18.85 0 0 1-.046-1.261V22.5H17a2.503 2.503 0 0 0-2.5 2.5c0 1.774 1.332 3.229 3.046 3.454zM52.753 51.704l-5.748-1.438a9.903 9.903 0 0 1-7.432-8.492c-.046.038-.092.08-.138.117C37.334 43.573 34.693 44.5 32 44.5s-5.334-.927-7.436-2.608c-.033-.026-.064-.055-.096-.082-.324 4.061-3.066 7.491-7.029 8.68l-6.591 1.977A8.85 8.85 0 0 0 4.514 60.5H59.5v-.154a8.894 8.894 0 0 0-6.747-8.642zM44 55.5h-3.528c-2.849 0-5.7.674-8.248 1.947a.505.505 0 0 1-.448 0 18.531 18.531 0 0 0-8.249-1.947H21a.5.5 0 0 1 0-1h2.528c2.92 0 5.844.671 8.472 1.942a19.558 19.558 0 0 1 8.472-1.942H44a.5.5 0 0 1 0 1z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                  <circle cx="55" cy="31" r="2.124" fill="#000000" opacity="1" data-original="#000000" class=""></circle>
                  <circle cx="14" cy="41" r="2.124" fill="#000000" opacity="1" data-original="#000000" class=""></circle>
                </g>
              </svg>
            </div>
            <h6 class="font-heading">Esthetician</h6>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="100">
        <a href="job-list.html?q=Manager" class="text-decoration-none">
          <div class="category-card shadow-sm h-100">
            <div class="cat-icon ci-green"><i class="fas fa-user-tie"></i></div>
            <h6 class="font-heading">Salon Managers</h6>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="200">
        <a href="job-list.html?q=Spa" class="text-decoration-none">
          <div class="category-card shadow-sm h-100">
            <div class="cat-icon ci-green"><i class="fas fa-spa"></i></div>
            <h6 class="font-heading">Spa Therapists</h6>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="300">
        <a href="job-list.html?q=Lash" class="text-decoration-none">
          <div class="category-card shadow-sm h-100">
            <div class="cat-icon ci-green"><i class="fas fa-eye"></i></div>
            <h6 class="font-heading">Lash Technicians</h6>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="400">
        <a href="job-list.html?q=Massage" class="text-decoration-none">
          <div class="category-card shadow-sm h-100">
            <div class="cat-icon ci-green"><i class="fas fa-hot-tub"></i></div>
            <h6 class="font-heading">Massage Therapists</h6>
          </div>
        </a>
      </div> --}}
    </div>
  </div>
</section>

<!-- CSS: Section 7 - CONTENT SECTIONS (Feature Cards) | Classes: .feature-card, .f-icon, .fi-rose, .fi-purple-deep, .text-gradient-purple, .got-bg-light-bg -->
<section class="got-bg-light-bg">
  <div class="container got-py-5">
    <div class="row got-align-items-center got-g-5">
      <div class="col-lg-6">
        <div class="row got-g-4">
          <div class="col-sm-6" data-aos="fade-up">
            <div class="feature-card">
              <div class="f-icon fi-purple-deep got-text-primary"><i class="fas fa-search"></i></div>
              <h6 class="font-heading">Premium Salon Jobs</h6>
              <p class="got-text-muted got-small">Customized strategies tailored for your career growth in the beauty industry.</p>
            </div>
          </div>
          <div class="col-sm-6" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-card got-shadow-sm">
              <div class="f-icon fi-rose"><i class="fas fa-star"></i>
              </div>
              <h6 class="font-heading">Top Stylist Careers</h6>
              <p class="got-text-muted got-text-muted got-text-muted got-small got-mb-0">Access exclusive career opportunities from luxury salon chains.</p>
            </div>
          </div>
          <div class="col-sm-6" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-card got-shadow-sm">
              <div class="f-icon fi-purple-deep"><i
                  class="fas fa-map-marker-alt"></i></div>
              <h6 class="font-heading">Global Locations</h6>
              <p class="got-text-muted got-text-muted got-text-muted got-small got-mb-0">Find your perfect place in top beauty capitals around the world.</p>
            </div>
          </div>
          <div class="col-sm-6" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-card got-shadow-sm">
              <div class="f-icon fi-rose"><i
                  class="fas fa-shield-alt"></i></div>
              <h6 class="font-heading">Verified Employers</h6>
              <p class="got-text-muted got-text-muted got-text-muted got-small got-mb-0">We vet every establishment to ensure a safe and professional workspace.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
        <h2 class="display-5 got-fw-bold got-mb-4 font-heading">Find Your Next <span class="text-gradient-purple">Elite Chapter</span></h2>
        <p class="got-text-muted got-text-muted got-text-muted got-mb-4 fs-5">We connect the world's most talented beauty professionals with prestigious salons, luxury spas, and high-fashion houses.</p>
        <ul class="list-unstyled got-mb-5">
          <li class="got-mb-3 d-flex got-align-items-center got-gap-3"><i class="fas fa-check-circle got-text-primary"></i> <span>Direct access to luxury establishment recruiters</span></li>
          <li class="got-mb-3 d-flex got-align-items-center got-gap-3"><i class="fas fa-check-circle got-text-primary"></i> <span>Portfolio showcase for top-tier stylists</span></li>
          <li class="got-mb-3 d-flex got-align-items-center got-gap-3"><i class="fas fa-check-circle got-text-primary"></i> <span>Industry-leading career resources and tips</span></li>
        </ul>
        <a href="{{ route('skills.details') }}" class="btn got-btn got-btn-primary btn-primary got-rounded-pill got-py-3 got-fw-bold shine-effect">Explore All Jobs</a>
      </div>
    </div>
  </div>
</section>
<!-- CSS: Section 15 - BOOTSTRAP OVERRIDE (CTA Banner) | Classes: .cta-banner-card, .cta-deco-icon -->
<section class="section-space">
  <div class="container">
    <div class="cta-banner-card" data-aos="fade-up">
      <div class="row align-items-center g-5 position-relative z-2">
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
          <h2 class="display-5 got-fw-bold got-mb-4 font-heading got-text-white">Hire the Top 1% of <span class="got-text-white">Beauty Talent</span></h2>
          <p class="got-mb-5 opacity-90 fs-5">Post your job today and reach thousands of verified experts in hair, makeup, spa, and wellness.</p>
          <div class="d-flex got-gap-3">
            <a href="{{ route('user.register') }} " class="btn got-btn btn-white got-rounded-pill px-5 got-py-3 got-fw-bold got-text-primary bg-white shine-effect">Post a Job</a>
            <a href="about.html" class="btn got-btn got-btn-outline-primary btn-outline-light got-rounded-pill px-5 got-py-3 got-fw-bold">Learn More</a>
          </div>
        </div>
        <div class="col-lg-6 text-center" data-aos="fade-left" data-aos-delay="400">
          <img src="images/cta.png" alt="Hire Talent" class="img-fluid rounded-3 shadow-lg animate-float">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- CSS: Section 15 - BOOTSTRAP OVERRIDE (Talent Badge) | Classes: .talent-floating-badge, .text-gradient-purple, .bg-light-bg -->
<section class="bg-light-bg">
  <div class="container got-py-5">
    <div class="row align-items-center">
      <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-right">
        <div class="position-relative got-p-4">
          <img src="images/talent.png" alt="Showcase Talent" class="img-fluid rounded-3 shadow-lg animate-float">
          <div class="talent-floating-badge">
            <div class="d-flex align-items-center gap-2">
              <i class="fa-regular fa-user"></i>
              <span class="got-fw-bold small">Creative Profiles</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 order-1 order-lg-2 ps-lg-5" data-aos="fade-left">
        <h2 class="display-5 got-fw-bold got-mb-4 font-heading">Showcase Your <span class="text-gradient-purple">Artistic Flair</span></h2>
        <p class="got-text-muted got-text-muted got-text-muted got-mb-4 fs-5">Create a professional profile that highlights your unique style, certifications, and portfolio. Let the best salons find you.</p>
        <div class="row g-4 got-mb-5">
          <div class="col-sm-6">
            <h4 class="got-fw-bold got-text-primary got-mb-2 font-heading">85%</h4>
            <p class="got-text-muted got-text-muted small got-mb-0">Higher chance of being hired with a full portfolio.</p>
          </div>
          <div class="col-sm-6">
            <h4 class="got-fw-bold got-text-primary got-mb-2 font-heading">500+</h4>
            <p class="got-text-muted got-text-muted small got-mb-0">New profiles created every single day.</p>
          </div>
        </div>
        <a href="{{ route('user.register') }}" class="btn got-btn got-btn-primary btn-primary got-rounded-pill got-py-3 got-fw-bold shine-effect">Create Your Profile</a>
      </div>
    </div>
  </div>
</section>
<!-- CSS: Section 15 - BOOTSTRAP OVERRIDE (Step Cards) | Classes: .step-card-primary, .step-card-light, .f-icon.icon-lg, .shine-effect -->
<section class="section-space">
  <div class="container text-center">
    <h3 class="got-fw-bold got-text-dark got-mb-4 font-heading" data-aos="fade-up">Getting Started is Easy</h3>
    <div class="row justify-content-center g-4 mb-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="step-card-light shine-effect">
          <div class="f-icon icon-lg got-text-primary mx-auto got-mb-4 apply"><i class="fas fa-user-plus "></i></div>
          <h5 class="got-mb-3 font-heading">Create Profile</h5>
          <p class="small opacity-80 mb-0">Build your professional beauty portfolio in minutes.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="step-card-light shine-effect">
          <div class="f-icon icon-lg got-text-primary mx-auto got-mb-4 apply"><i class="fas fa-search "></i></div>
          <h5 class="got-mb-3 font-heading got-text-dark">Find Your Match</h5>
          <p class="small got-text-muted mb-0">Search through elite salons and filter by your specialty.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="step-card-light shine-effect">
          <div class="f-icon icon-lg got-text-primary mx-auto got-mb-4 apply"><i class="fas fa-magic "></i></div>
          <h5 class="got-mb-3 font-heading got-text-dark">Get Hired</h5>
          <p class="small got-text-muted mb-0">Connect directly with owners and start your new chapter.</p>
        </div>
      </div>
    </div>
    <a href="{{ route('skills.details') }}" class="btn mt-2 got-btn btn-outline-primary job-btn got-rounded-pill px-5 got-py-3 got-fw-bold" data-aos="fade-up">Browse Jobs &rarr;</a>
  </div>
</section>



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
        </div>
      </div>
    </div>
  </div>

</section>


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Check if AOS library is loaded
    if (typeof AOS !== 'undefined') {
      AOS.init({
        duration: 800, // How long the animation lasts (in ms)
        once: true, // Animation happens only once while scrolling down
        offset: 80, // Start animation 80px before the element enters the screen
        easing: 'ease-out-cubic'
      });
    }
  });
</script>


@endsection