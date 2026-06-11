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
                <h4 class="heading-size">About <span class="color-text">Glam</span> On Tap</h4>

                <div class="about-detail">
                    <h5 heading-size>Beauty, Wellness & Confidence Delivered to Your Doorstep</h5>
                    <p>At Glam On Tap, we believe self-care should be effortless, accessible and tailored to your lifestyle. Our mission is to bring premium beauty and wellness services directly to your home, allowing you to enjoy professional treatments without the inconvenience of salon visits.
                        Whether you're preparing for a special occasion, maintaining your beauty routine or simply taking time for yourself, Glam On Tap connects you with skilled and verified beauty professionals who deliver exceptional service in the comfort of your own space.
                    </p>
                    <div class="about-list">
                        <div class="about-item">
                            <div class="about-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2" />
                                    <polyline points="2 17 12 22 22 17" />
                                    <polyline points="2 12 12 17 22 12" />
                                </svg></div>
                            <div class="about-text">
                                <h5>Our Mission</h5>
                                <p>To make professional beauty and wellness services accessible and reliable while
                                    empowering beauty professionals to grow and succeed.</p>
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg></div>
                            <div class="about-text">
                                <h5>Our Vision</h5>
                                <p>To be the most trusted destination for at-home beauty and wellness services, transforming
                                    the way people experience self-care and beauty.</p>
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-icon"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="m4.463 17.938 9.852 10.044c.449.458 1.047.71 1.685.71s1.236-.252 1.685-.71l9.852-10.044c3.3-3.364 3.28-8.818-.044-12.158a8.258 8.258 0 0 0-5.89-2.447h-.032a8.424 8.424 0 0 0-5.566 2.116 8.29 8.29 0 0 0-5.575-2.141 8.302 8.302 0 0 0-5.967 2.518c-3.276 3.339-3.276 8.774 0 12.112zm5.967-12.63c1.714 0 3.327.681 4.54 1.919l.316.32c.189.192.445.3.713.3H16a1 1 0 0 0 .713-.298l.25-.255a6.458 6.458 0 0 1 4.615-1.961h.026c1.69 0 3.277.66 4.471 1.857 2.556 2.569 2.571 6.761.034 9.348l-9.852 10.044c-.18.182-.334.182-.514 0L5.891 16.538c-2.519-2.567-2.519-6.744 0-9.311a6.317 6.317 0 0 1 4.539-1.92z" fill="#3c0a74" opacity="1" data-original="#000000" class=""></path>
                                        <path d="M13.782 19.4a1 1 0 0 0 1.414 0l7.011-7.011a1 1 0 1 0-1.414-1.414l-6.304 6.304-3.282-3.282a1 1 0 1 0-1.414 1.414z" fill="#3c0a74" opacity="1" data-original="#000000" class=""></path>
                                    </g>
                                </svg></div>
                            <div class="about-text">
                                <h5>Our Promise</h5>
                                <p>Quality, convenience and care you can trust, every time.</p>
                            </div>
                        </div>
                    </div>
                    <!-- <h5 class ="heading-size">Our Story</h5>
                    <p>Glam On Tap was created with a simple vision: to redefine the beauty experience by combining convenience, professionalism and personalized care. We recognized that busy schedules, travel time and long salon waits often make self-care difficult to prioritize.
                        By bringing trusted beauty experts directly to clients, we make it easier than ever to access high-quality beauty services whenever and wherever they're needed.</p>

                    <br>
                    <h5 class ="heading-size">Our Mission</h5>
                    <p>To make professional beauty and wellness services accessible, convenient and reliable while empowering beauty professionals to grow and succeed.</p>

                    <br>
                    <h5 class ="heading-size">Our Vision</h5>
                    <p>To become the most trusted destination for at home beauty and wellness services, transforming the way people experience self-care and beauty.</p> -->

                </div>

            </div>
        </div>

    </div>
</div>
<div class="container-fluid">
    <div class="mid-content skill-about-content align-items-center">
        <div class="row about-cont align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <h4 class="heading-size">Beauty That Comes To <span class="color-text">You</span></h4>
                <p class="hero-v2-desc">Professional beauty experts delivering salon-quality services<br>in the comfort, privacy and convenience of your home.</p>
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M53.177 10.824A23.109 23.109 0 0 0 36.713 4c-.105 0-.21 0-.316.002a2.526 2.526 0 0 0-2.459 2.111L31.164 22.78l-6.286 9.87L5.087 53.367a3.923 3.923 0 0 0 5.546 5.548l20.72-19.794 9.866-6.284 16.668-2.775a2.525 2.525 0 0 0 2.111-2.459 23.116 23.116 0 0 0-6.821-16.778zM9.252 57.467a1.923 1.923 0 0 1-2.72-2.719l19.155-20.05 3.615 3.615zm21.62-20.412-1.964-1.963-1.964-1.964 5.347-8.394 4.555 4.554v.001l2.42 2.42zm26.687-8.967-16.36 2.724-1.95-1.95 6.716-3.456a1 1 0 0 0-.916-1.778l-7.285 3.75-1.142-1.143 3.75-7.285a1 1 0 1 0-1.778-.915l-3.457 6.716-1.948-1.949 2.722-16.36a.527.527 0 0 1 .513-.44C36.52 6 36.616 6 36.712 6a21.298 21.298 0 0 1 21.286 21.576.526.526 0 0 1-.44.512z" fill="#3c0a74" opacity="1" data-original="#000000" class=""></path></g></svg>
                            </div>
                            <div class="hero-service-text">
                                <h5>Makeup</h5>
                                <p>Bridal • Party • Event</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 478.096 478.096" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M460.033 328.89a109.33 109.33 0 0 0 10.095-42.033 7.968 7.968 0 0 0-7.968-7.968c-14.021 0-27.982-15.811-41.495-46.994-12.185-28.12-21.839-63.895-30.458-98.367C376.211 77.547 324.209 0 262.953 0c-24.48 0-44.865 4.349-60.59 12.926a64.545 64.545 0 0 0-12.277 8.544c-7.597-4.363-21.237-9.637-37.136-4.159-29.415 10.138-51.338 52.068-65.158 124.625a9.704 9.704 0 0 0-.1.656 423.46 423.46 0 0 1-10.184 54.396c-9.608 37.226-22.537 63.133-37.392 74.92-7.281 5.777-14.868 8.081-23.194 7.041a7.968 7.968 0 0 0-8.828 9.332 143.54 143.54 0 0 0 15.313 40.428c11.92 21.224 28.066 36.616 47.344 45.343l-2.598 1.295a7.959 7.959 0 0 0-3.431 3.311l-47.81 87.651a7.968 7.968 0 0 0 6.992 11.788H454.19a7.968 7.968 0 0 0 6.995-11.784l-47.81-87.651a7.964 7.964 0 0 0-3.431-3.311c27.848-10.364 42.486-30.143 50.089-46.461zm-19.265 133.269H37.327l40.186-73.674 120.42-60.21a57.82 57.82 0 0 0 6.988 4.801 104.909 104.909 0 0 0-13.446 31.533 7.97 7.97 0 0 0 15.463 3.861 88.01 88.01 0 0 1 12.908-28.985 73.245 73.245 0 0 0 19.202 3.149 73.243 73.243 0 0 0 19.202-3.147 88.01 88.01 0 0 1 12.908 28.985 7.968 7.968 0 0 0 15.462-3.86 104.923 104.923 0 0 0-13.446-31.533 57.742 57.742 0 0 0 6.988-4.801l120.42 60.21zM254.984 286.857h-31.873c-39.588-.044-71.67-32.126-71.714-71.714v-18.42c34.434-14.789 52.082-54.981 59.378-76.855 20.802 22.97 70.969 73.251 115.923 78.832v16.443c-.044 39.588-32.125 71.67-71.714 71.714zm-31.873 15.937h31.873a87.832 87.832 0 0 0 15.937-1.456v13.895c-13.265 11.203-31.7 11.466-31.848 11.466-.199 0-18.633-.263-31.898-11.466v-13.895a87.91 87.91 0 0 0 15.936 1.456zm165.491 61.884-101.745-50.872v-17.012a88.132 88.132 0 0 0 49.778-49.778h13.968c13.196-.015 23.89-10.709 23.905-23.905v-15.937c-.015-13.196-10.709-23.89-23.905-23.905h-15.937c-20.8 0-48.199-14.419-79.234-41.694a416.566 416.566 0 0 1-42.092-43.036 7.968 7.968 0 0 0-13.945 3.313c-.149.666-15.305 66.314-57.341 81.417h-14.563c-13.196.015-23.89 10.709-23.905 23.905v15.937c.015 13.196 10.709 23.89 23.905 23.905h13.968a88.132 88.132 0 0 0 49.778 49.778v17.012L90.613 364.119c-22.191-5.405-40.041-19.791-53.084-42.806a133.981 133.981 0 0 1-11.321-26.511 47.34 47.34 0 0 0 23.816-10.409c41.052-32.576 52.637-132.032 53.482-139.791 7.092-37.114 16.307-65.778 27.391-85.196 8.267-14.483 17.376-23.558 27.073-26.97 15.151-5.331 27.539 5.022 28.021 5.433a7.968 7.968 0 0 0 11.877-1.577c.134-.204 14.971-20.357 65.084-20.357 22.727 0 47.4 14.358 69.473 40.429 19.604 23.155 35.425 53.445 42.32 81.027 17.787 71.149 39.925 146.741 78.905 156.398a96.316 96.316 0 0 1-8.068 28.369c-10.883 23.366-30.047 37.662-56.98 42.52zm-45.967-149.535v-15.937h7.968a7.977 7.977 0 0 1 7.968 7.968v15.937a7.977 7.977 0 0 1-7.968 7.968h-9.424a87.813 87.813 0 0 0 1.456-15.936zM136.917 231.08h-9.424a7.977 7.977 0 0 1-7.968-7.968v-15.937a7.977 7.977 0 0 1 7.968-7.968h7.968v15.937a87.74 87.74 0 0 0 1.456 15.936z" fill="#3c0a74" opacity="1" data-original="#000000"></path><circle cx="199.206" cy="207.175" r="7.968" fill="#3c0a74" opacity="1" data-original="#000000"></circle><circle cx="278.889" cy="207.175" r="7.968" fill="#3c0a74" opacity="1" data-original="#000000"></circle><path d="m251.42 231.921-12.373 6.186-12.373-6.186a7.968 7.968 0 0 0-7.239 14.197l.111.056 15.937 7.968a7.968 7.968 0 0 0 7.128 0l15.937-7.968a7.968 7.968 0 1 0-7.017-14.309l-.111.056zM13.417 119.116c17.968 5.986 18.446 23.625 18.456 24.313a7.968 7.968 0 1 0 15.937.071v-.021c.015-.872.556-18.397 18.456-24.363a7.97 7.97 0 0 0 0-15.12C48.298 98.01 47.821 80.371 47.81 79.683a7.968 7.968 0 1 0-15.937-.071v.021c-.015.872-.556 18.397-18.456 24.363a7.97 7.97 0 0 0 0 15.12zm26.424-15.661a40.994 40.994 0 0 0 7.512 8.101 40.994 40.994 0 0 0-7.512 8.101 40.994 40.994 0 0 0-7.512-8.101 41.05 41.05 0 0 0 7.512-8.101zM464.679 119.932c-17.968-5.986-18.446-23.625-18.456-24.313a7.968 7.968 0 1 0-15.937-.071v.021c-.015.872-.556 18.397-18.456 24.363a7.97 7.97 0 0 0 0 15.12c17.968 5.986 18.446 23.625 18.456 24.313a7.968 7.968 0 1 0 15.937.071v-.021c.015-.872.556-18.397 18.456-24.363a7.97 7.97 0 0 0 0-15.12zm-26.425 15.661a40.994 40.994 0 0 0-7.512-8.101 40.994 40.994 0 0 0 7.512-8.101 40.994 40.994 0 0 0 7.512 8.101 41.054 41.054 0 0 0-7.512 8.101z" fill="#3c0a74" opacity="1" data-original="#000000"></path></g></svg>
                            </div>
                            <div class="hero-service-text">
                                <h5>Hair Styling</h5>
                                <p>Cut • Style • Treat</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M64 68.277a5.863 5.863 0 0 0 3.82-1.589 1.5 1.5 0 1 0-1.957-2.274 2.459 2.459 0 0 1-3.726 0 1.5 1.5 0 1 0-1.957 2.274A5.863 5.863 0 0 0 64 68.277zM71.444 73.627h-.017a10.115 10.115 0 0 1-3.5.1c-.29-.041-.574-.1-.91-.161a4.1 4.1 0 0 0-1.455-.069 3.581 3.581 0 0 0-1.415.58.307.307 0 0 1-.3 0 3.582 3.582 0 0 0-1.414-.58 4.1 4.1 0 0 0-1.456.069c-.336.065-.62.12-.91.161a10.115 10.115 0 0 1-3.5-.1h-.018a1.076 1.076 0 0 0-.632 2.045 10.3 10.3 0 0 0 4.369.836c.372-.011.748-.043 1.07-.068a1.32 1.32 0 0 1 .908.29 3.23 3.23 0 0 0 1.618.469h.224a3.23 3.23 0 0 0 1.618-.469 1.321 1.321 0 0 1 .909-.29c.321.025.7.057 1.069.068a10.3 10.3 0 0 0 4.369-.836 1.076 1.076 0 0 0-.633-2.045zM64.96 79.039a2.04 2.04 0 0 1-1.92 0 1.5 1.5 0 1 0-1.3 2.7 5.062 5.062 0 0 0 4.526 0 1.5 1.5 0 0 0-1.3-2.7zM72.746 45.956l.049-.009a47.773 47.773 0 0 1 7.655-.506 33.419 33.419 0 0 1 3.963.119 19.058 19.058 0 0 1 3.827.709l.044.014a.691.691 0 0 0 .547-1.261 16.947 16.947 0 0 0-4.042-1.539 34.816 34.816 0 0 0-4.182-.826 18.278 18.278 0 0 0-4.293-.056 13.6 13.6 0 0 0-4.295 1.111 1.188 1.188 0 0 0 .727 2.244zM85.688 54.389a2.484 2.484 0 0 0-2-1.177 4.736 4.736 0 0 0-2.11.395l-.434.188-.321.148c-.222.091-.439.188-.669.266-.445.184-.908.334-1.368.479a13.2 13.2 0 0 1-2.759.562 6.092 6.092 0 0 1-2.5-.233l-.139-.047a1.073 1.073 0 0 0-1.031 1.839 6 6 0 0 0 3.708 1.291 11.043 11.043 0 0 0 3.615-.521 13.338 13.338 0 0 0 1.668-.657c.27-.128.533-.281.8-.428l.392-.237c.124-.079.184-.13.28-.2a5.376 5.376 0 0 1 .98-.517 1.791 1.791 0 0 1 .988-.153l.186.025a.7.7 0 0 0 .423-.076.7.7 0 0 0 .291-.947zM55.97 55.646a1.073 1.073 0 0 0-1.359-.675l-.137.046a6.092 6.092 0 0 1-2.5.233 13.2 13.2 0 0 1-2.759-.562c-.46-.145-.923-.3-1.368-.479-.23-.078-.447-.175-.669-.266l-.321-.148-.434-.188a4.736 4.736 0 0 0-2.11-.395 2.484 2.484 0 0 0-2 1.177.705.705 0 0 0 .717 1.029l.186-.025a1.791 1.791 0 0 1 .988.153 5.376 5.376 0 0 1 .98.517c.1.067.156.118.28.2l.392.237c.264.147.527.3.8.428a13.338 13.338 0 0 0 1.668.657 11.043 11.043 0 0 0 3.615.521 6 6 0 0 0 3.709-1.294 1.077 1.077 0 0 0 .322-1.166zM43.588 45.56a33.4 33.4 0 0 1 3.962-.119 47.773 47.773 0 0 1 7.655.506l.05.01a1.189 1.189 0 0 0 .726-2.245 13.6 13.6 0 0 0-4.3-1.111 18.278 18.278 0 0 0-4.293.056 34.816 34.816 0 0 0-4.182.826 16.947 16.947 0 0 0-4.042 1.539.691.691 0 0 0 .547 1.26l.044-.013a19.055 19.055 0 0 1 3.833-.709z" fill="#3c0a74" opacity="1" data-original="#000000"></path><path d="M112.769 125.094a29.385 29.385 0 0 0-7.29-10.895c-3-2.778-8.434-4.695-13.471-6.364a42.205 42.205 0 0 1 2.7-8.49 6.089 6.089 0 0 1 1.886-2.425c2.652-2.081 3.988-4.473 3.945-9.374-.013-1.594-2.046-13.567-6.409-14.374a3.644 3.644 0 0 0-2.192.264c-.086-.243-.165-.474-.247-.71 4.628-.876 9-5.787 9.747-10.261a9.615 9.615 0 0 0-1.907-8.108c2.012-9.7 2.922-23.1-.965-30.178C90.817 10.081 77.574 1.32 64 1.314s-26.817 8.767-34.563 22.865c-3.887 7.075-2.977 20.482-.965 30.178a9.615 9.615 0 0 0-1.907 8.108c.742 4.474 5.119 9.385 9.747 10.261l-.247.71a3.627 3.627 0 0 0-2.19-.264c-4.365.807-6.4 12.78-6.411 14.374-.043 4.9 1.293 7.294 3.947 9.375a6.081 6.081 0 0 1 1.889 2.424 41.973 41.973 0 0 1 2.7 8.485c-5.023 1.658-10.454 3.566-13.473 6.369a29.371 29.371 0 0 0-7.289 10.895 1.5 1.5 0 0 0 2.777 1.133 26.5 26.5 0 0 1 6.552-9.828c2.343-2.175 6.969-3.907 11.233-5.341-1.041 3.4-4.323 11.047-5.631 13.994a1.5 1.5 0 0 0 2.742 1.217c.218-.492 5.346-12.066 6.085-15.546.92-4.342-3.4-13.7-4.079-15.136a16.531 16.531 0 0 1 .2-10.868l.844-2.265c1.135-3.042 2.42-6.49 3.363-9.24a.808.808 0 0 1 .28-.4.927.927 0 0 1 .879-.071.73.73 0 0 1 .418.684 8.014 8.014 0 0 1-.019 1.076 103.3 103.3 0 0 1-1.641 11.186c-.559 2.507 1.51 5.039 3.511 7.487.639.78 1.241 1.518 1.691 2.178 4.876 7.178 3.058 11.244 1.855 13.933l-.232.526c-1.041 2.4-3.651 14.189-3.945 15.526a1.5 1.5 0 1 0 2.93.644c1.13-5.133 3.066-13.36 3.767-14.977l.218-.493a15.7 15.7 0 0 0 1.583-5.757c4.219-3.551 4.876-8.391 5.118-12a33.177 33.177 0 0 0 7.211 2.305 5.052 5.052 0 0 0 1.036.139 5.936 5.936 0 0 0 1.165-.155 32.822 32.822 0 0 0 7.124-2.28c.243 3.606.9 8.452 5.121 12a15.7 15.7 0 0 0 1.582 5.743l.218.493c.7 1.617 2.636 9.843 3.767 14.977a1.5 1.5 0 1 0 2.93-.644c-.294-1.337-2.9-13.125-3.945-15.526l-.232-.526c-1.2-2.689-3.021-6.755 1.855-13.933.45-.66 1.052-1.4 1.691-2.178 2-2.448 4.07-4.98 3.511-7.488A103.227 103.227 0 0 1 87.124 74.5a7.415 7.415 0 0 1-.01-1.165.675.675 0 0 1 .409-.594.927.927 0 0 1 .879.071.793.793 0 0 1 .279.4c.948 2.751 2.229 6.2 3.364 9.242l.844 2.265a16.531 16.531 0 0 1 .2 10.868c-.681 1.436-5 10.794-4.079 15.136.739 3.48 5.867 15.054 6.085 15.546a1.5 1.5 0 0 0 2.742-1.217c-1.307-2.945-4.585-10.579-5.628-13.986 4.4 1.48 8.887 3.167 11.228 5.334a26.478 26.478 0 0 1 6.551 9.827 1.5 1.5 0 0 0 1.39.933 1.484 1.484 0 0 0 .565-.111 1.5 1.5 0 0 0 .826-1.955zM33.144 81.405l-.844 2.271a19.489 19.489 0 0 0-1.135 8.37 10.44 10.44 0 0 1-.7-4.475c.022-2.729 2.493-10.95 3.958-11.45a.671.671 0 0 1 .608.193 932.352 932.352 0 0 1-1.887 5.091zm65.332-19.43c-.524 3.158-3.8 6.922-6.982 7.735a55.367 55.367 0 0 0 1.4-7.093 1.67 1.67 0 0 1 1.711-1.04 1.5 1.5 0 1 0 .289-2.986 4.667 4.667 0 0 0-1.6.125q.147-2 .181-4.092a5.433 5.433 0 0 1 3.731 1.628 6.668 6.668 0 0 1 1.27 5.723zM32.065 25.624C39.176 12.684 51.711 4.319 64 4.314s24.825 8.37 31.936 21.31c3.13 5.7 2.747 17.182.924 26.784a9.617 9.617 0 0 0-3.5-.788c-.96-13.103-2.81-23.32-13.542-26.767a3.486 3.486 0 0 1-1.641-1.1c-4.622-5.64-11.684-8.556-17.992-7.431-5.537.989-9.755 4.914-11.879 11.052-2.461 7.115-5.19 9.142-7.6 10.929-3.017 2.241-5.635 4.219-6.105 13.317a9.6 9.6 0 0 0-3.461.784c-1.819-9.599-2.206-21.082.925-26.78zm-2.541 36.351a6.668 6.668 0 0 1 1.266-5.723 5.466 5.466 0 0 1 3.81-1.633c.025 1.4.083 2.776.182 4.119a4.688 4.688 0 0 0-1.683-.147 1.5 1.5 0 1 0 .289 2.986c.291-.027 1.162-.1 1.819 1.235a55.037 55.037 0 0 0 1.386 6.92c-3.213-.76-6.539-4.567-7.069-7.757zM52.8 91.565c-.162 2.766-.381 6.343-2.55 9.242a21.737 21.737 0 0 0-3.334-7.14c-.522-.77-1.166-1.558-1.848-2.392-1.329-1.625-3.148-3.849-2.906-4.934.172-.768.413-2.065.662-3.558a23.686 23.686 0 0 0 2.016 2.237 41.346 41.346 0 0 0 7.98 6.229c-.005.109-.013.204-.02.316zm30.13-.29c-.682.834-1.326 1.622-1.848 2.392a21.732 21.732 0 0 0-3.332 7.133c-2.166-2.9-2.39-6.469-2.553-9.231-.006-.112-.014-.208-.02-.317a41.533 41.533 0 0 0 7.982-6.236 23.705 23.705 0 0 0 2.015-2.24c.249 1.494.491 2.792.663 3.56.242 1.09-1.577 3.314-2.906 4.939zM86.3 70a3.682 3.682 0 0 0-2.173 3.023s-.041 1.009 0 1.663c.064 1.041.214 2.391.4 3.813a23.007 23.007 0 0 1-3.461 4.364c-4 3.877-8.771 7.68-16.509 9.238a2.873 2.873 0 0 1-1.124 0c-7.738-1.558-12.507-5.361-16.509-9.238a23.023 23.023 0 0 1-3.456-4.363c.189-1.422.338-2.77.4-3.812a10.741 10.741 0 0 0 .013-1.522l-.013-.141A3.682 3.682 0 0 0 41.7 70a3.946 3.946 0 0 0-1.994-.323 59.582 59.582 0 0 1-2.121-16.543v-.036C37.854 44.624 39.7 42.8 42.5 40.714c2.618-1.945 5.878-4.366 8.643-12.357 2.246-6.492 6.444-8.52 9.57-9.078 5.257-.943 11.2 1.565 15.145 6.38a6.486 6.486 0 0 0 3.044 2.05c8.465 2.72 10.537 10.7 11.565 25.5v.053l.008.043.022.3a59.239 59.239 0 0 1-2.12 16.094A3.928 3.928 0 0 0 86.3 70zm6.667 6.312a.662.662 0 0 1 .595-.2c1.478.5 3.949 8.724 3.971 11.453a10.448 10.448 0 0 1-.7 4.464 19.5 19.5 0 0 0-1.133-8.353l-.845-2.271c-.61-1.638-1.264-3.393-1.885-5.091z" fill="#3c0a74" opacity="1" data-original="#000000"></path><path d="M41.925 64.741a9.662 9.662 0 0 0-1.069-.2 1 1 0 1 0-.259 1.982 8.067 8.067 0 0 1 .851.161.983.983 0 0 0 .239.029 1 1 0 0 0 .238-1.971zM49.613 74.781a1 1 0 0 0-.949 1.049c.008.157.013.315.012.478 0 .135 0 .271-.009.4a1 1 0 0 0 .953 1.045h.047a1 1 0 0 0 1-.954c.008-.165.011-.33.011-.492 0-.194 0-.388-.014-.583a1 1 0 0 0-1.051-.943zM45.788 66.59a1 1 0 1 0-1.2 1.6q.351.262.682.563a1 1 0 1 0 1.342-1.484 10.56 10.56 0 0 0-.824-.679zM47.856 72.386A1 1 0 0 0 49.7 71.6a11.257 11.257 0 0 0-.501-1.031.988.988 0 0 0-1.341-.34 1.015 1.015 0 0 0-.383 1.354c.137.262.266.531.381.803zM49.166 79.63a1 1 0 0 0-1.341.451 7.573 7.573 0 0 1-.427.749 1 1 0 1 0 1.678 1.088 9.39 9.39 0 0 0 .54-.948 1 1 0 0 0-.45-1.34zM82.3 66.59q-.425.318-.827.68a1 1 0 0 0 1.342 1.484q.332-.3.683-.563a1 1 0 1 0-1.2-1.6zM87.227 64.54a9.645 9.645 0 0 0-1.068.2 1 1 0 0 0 .237 1.971.983.983 0 0 0 .239-.029 8.085 8.085 0 0 1 .852-.161 1 1 0 1 0-.26-1.982zM78.914 72.912a.99.99 0 0 0 .393.08 1 1 0 0 0 .92-.606q.172-.408.386-.807a1.015 1.015 0 0 0-.384-1.354.988.988 0 0 0-1.341.34 12.336 12.336 0 0 0-.501 1.031 1 1 0 0 0 .527 1.316zM80.258 80.081a1 1 0 1 0-1.791.889 9.39 9.39 0 0 0 .54.948 1 1 0 0 0 1.678-1.088 7.779 7.779 0 0 1-.427-.749zM78.463 77.758a1 1 0 0 0 .953-1.045c0-.134-.008-.27-.008-.4 0-.163 0-.321.011-.478a1 1 0 0 0-2-.1c-.009.195-.014.389-.013.583 0 .162 0 .327.01.492a1 1 0 0 0 1 .954z" fill="#3c0a74" opacity="1" data-original="#000000"></path></g></svg>
                            </div>
                            <div class="hero-service-text">
                                <h5>Skincare</h5>
                                <p>Facials • Cleanups • Glow</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths"><g><path d="M34.258 33.352H14.097a3.003 3.003 0 0 0-3 3v7.18a3.003 3.003 0 0 0 3 3h20.16a3.003 3.003 0 0 0 3-3v-7.18a3.003 3.003 0 0 0-3-3zm1 10.18a1.001 1.001 0 0 1-1 1H14.097a1.001 1.001 0 0 1-1-1v-7.18a1.001 1.001 0 0 1 1-1h20.16a1.001 1.001 0 0 1 1 1z" fill="#3c0a74" opacity="1" data-original="#000000" class="hovered-path"></path><path d="M40.278 27.31v-3.609a3.258 3.258 0 0 0-2.915-3.23L28 14.419a7.056 7.056 0 0 0-7.645 0l-9.363 6.054a3.258 3.258 0 0 0-2.915 3.23v3.608a4.773 4.773 0 0 0-4.074 4.687L4 44.9a7.754 7.754 0 0 0 7.745 7.746H36.61a7.754 7.754 0 0 0 7.745-7.746l-.002-12.903a4.773 4.773 0 0 0-4.074-4.687zM21.44 16.098a5.05 5.05 0 0 1 5.473 0l6.71 4.339H14.73zm-10.1 6.339h25.672a1.266 1.266 0 0 1 1.265 1.264v3.538H10.077v-3.538a1.266 1.266 0 0 1 1.265-1.264zM36.61 50.646H11.745A5.752 5.752 0 0 1 6 44.9l.003-12.895a2.78 2.78 0 0 1 2.775-2.766h30.799a2.78 2.78 0 0 1 2.775 2.766l.002 12.895a5.752 5.752 0 0 1-5.745 5.746zM57.164 36.623a1.021 1.021 0 0 1-.498-.842v-21.46a2.965 2.965 0 0 0-5.93 0v21.46a1.021 1.021 0 0 1-.499.842 6.253 6.253 0 0 0-2.78 6.09l1.098 8.19a2.017 2.017 0 0 0 1.991 1.743h6.309a2.016 2.016 0 0 0 1.991-1.744l1.097-8.188a6.253 6.253 0 0 0-2.78-6.09zM53.7 13.354a.967.967 0 0 1 .965.966v20.461h-1.93v-20.46a.967.967 0 0 1 .965-.967zm4.26 29.094-1.106 8.198-6.318-.01-1.097-8.188a4.267 4.267 0 0 1 1.899-4.155 3.094 3.094 0 0 0 1.193-1.512h2.337a3.095 3.095 0 0 0 1.193 1.512 4.267 4.267 0 0 1 1.899 4.155z" fill="#3c0a74" opacity="1" data-original="#000000" class="hovered-path"></path></g></svg>
                            </div>
                            <div class="hero-service-text">
                                <h5>Waxing</h5>
                                <p>Full Body • Facial</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 6.827 6.827" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class=""><g><g fill="#212121" fill-rule="nonzero"><path d="M1.519 3.143h1.935a.446.446 0 0 1 .448.448v1.935a.446.446 0 0 1-.448.447H1.52a.446.446 0 0 1-.448-.447V3.59a.446.446 0 0 1 .448-.448zm1.935.213H1.52a.233.233 0 0 0-.234.235v1.935a.233.233 0 0 0 .234.234h1.935a.233.233 0 0 0 .234-.234V3.59a.233.233 0 0 0-.234-.235z" fill="#3c0a74" opacity="1" data-original="#212121"></path><path d="m1.808 3.244.136-2.29.006-.1h1.073l.006.1.136 2.29-.212.012-.13-2.19H2.15l-.13 2.19z" fill="#3c0a74" opacity="1" data-original="#212121"></path><path d="M1.966 2.273h1.037v.213H1.966zM5.106 5.103V2.05h.213v3.053z" fill="#3c0a74" opacity="1" data-original="#212121"></path><path d="M5.049.853h.327a.27.27 0 0 1 .27.27v1.034H4.78V1.124a.27.27 0 0 1 .27-.27zm.327.214h-.327a.057.057 0 0 0-.04.016.057.057 0 0 0-.017.04v.82h.44v-.82a.057.057 0 0 0-.016-.04.057.057 0 0 0-.04-.016zM4.913 4.888h.705v.106l.004.873v.106h-.819v-.106l.003-.873v-.106h.107zm.493.213h-.388l-.002.659h.393l-.003-.659z" fill="#3c0a74" opacity="1" data-original="#212121"></path></g></g></svg>
                            </div>
                            <div class="hero-service-text">
                                <h5>Nails</h5>
                                <p>Manicure • Pedicure</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M26 31a1 1 0 0 1-1-1 15.202 15.202 0 0 1 1.872-7.001 1 1 0 0 1 1.775.922A13.23 13.23 0 0 0 27 30a1 1 0 0 1-1 1ZM17.001 35.265a1 1 0 0 1-.885-.532 25.613 25.613 0 0 1-2.314-6.52 1 1 0 1 1 1.953-.427 23.62 23.62 0 0 0 2.129 6.01A1 1 0 0 1 17 35.264Z" fill="#3c0a74" opacity="1" data-original="#000000" class=""></path><circle cx="14" cy="24" r="1" fill="#3c0a74" opacity="1" data-original="#000000" class=""></circle><circle cx="30" cy="20" r="1" fill="#3c0a74" opacity="1" data-original="#000000" class=""></circle><path d="M60.787 41.384a34.351 34.351 0 0 0-8.226-7.224 36.541 36.541 0 0 0 2.417-14.214.998.998 0 0 0-.942-.944 36.773 36.773 0 0 0-13.369 2.124 34.188 34.188 0 0 0-8.04-9.904 1.002 1.002 0 0 0-1.255 0 34.188 34.188 0 0 0-8.04 9.904 36.767 36.767 0 0 0-13.368-2.124.998.998 0 0 0-.942.943 36.539 36.539 0 0 0 2.417 14.215 34.349 34.349 0 0 0-8.226 7.224.997.997 0 0 0 0 1.233C3.545 43.04 11.458 53 21.5 53c4.053 0 7.688-1.96 10.5-3.804C34.812 51.04 38.447 53 42.5 53c10.042 0 17.955-9.96 18.287-10.384a.997.997 0 0 0 0-1.232Zm-7.79-20.4c-.015 3.085-.556 13.135-6.704 19.3a24.778 24.778 0 0 1-11.035 6.024C38.335 43.092 43 37.055 43 30a18.446 18.446 0 0 0-1.492-7.059 35.57 35.57 0 0 1 11.488-1.958ZM32 13.325c2.139 1.933 9 8.754 9 16.675s-6.861 14.742-9 16.675C29.861 44.742 23 37.92 23 30s6.861-14.742 9-16.675Zm-9.508 9.616A18.446 18.446 0 0 0 21 30c0 7.055 4.665 13.092 7.742 16.308a24.775 24.775 0 0 1-11.034-6.024c-6.15-6.165-6.69-16.216-6.704-19.3a35.57 35.57 0 0 1 11.488 1.957ZM5.308 42a33.295 33.295 0 0 1 6.964-5.993 21.653 21.653 0 0 0 4.021 5.691 26.994 26.994 0 0 0 13.018 6.82A15.87 15.87 0 0 1 21.5 51c-7.7 0-14.33-6.878-16.192-9.001ZM42.5 51a15.87 15.87 0 0 1-7.81-2.482 26.997 26.997 0 0 0 13.018-6.822 21.65 21.65 0 0 0 4.02-5.69A33.384 33.384 0 0 1 58.693 42c-1.859 2.124-8.477 9-16.192 9Z" fill="#3c0a74" opacity="1" data-original="#000000" class=""></path></g></svg>
                            </div>
                            <div class="hero-service-text">
                                <h5>Spa & Wellness</h5>
                                <p>Relax • Rejuvenate</p>
                            </div>
                        </div>
                    </div>
                </div>

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


<!-- <div class="container-fluid">
    <div class="mid-content skill-about-content align-items-center choose_glam">
        <div class="row about-cont align-items-center">
            <div class="col-lg-6 col-sm-12 col-md-12">
                <div class="text-center">
                    <div class="about-left-banner pe-0">
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
</div> -->

<div class="container-fluid">
    <div class="mid-content skill-about-content align-items-center choose_glam">
        <div class="about-cont align-items-center">
            <h4 class="heading-size text-center">Why Choose Glam On Tap?</h4>
            <p class="text-center mb-4">We make beauty simple, safe, and satisfying. Experience premium salon-quality services at your convenience.</p>

            <div class="row g-4">
                <div class="col-12 col-md-4 col-lg-2">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="8" r="7" />
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88" />
                            </svg></div>
                        <h5>Verified Professionals</h5>
                        <p>All professionals are, qualified and continuously verified for your safety.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-2">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                <path d="M9 12l2 2 4-4" />
                            </svg></div>
                        <h5>Safe and <br> Hygienic</h5>
                        <p>We follow strict hygiene protocols and use high-quality, tools for every service.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-2">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg></div>
                        <h5>Convenient and Flexible</h5>
                        <p>Book at your preferred time and place. We come to you, saving your time and effort.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-2">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                                <polyline points="2 17 12 22 22 17" />
                                <polyline points="2 12 12 17 22 12" />
                            </svg></div>
                        <h5>Premium <br> Quality</h5>
                        <p>We use top-quality products to deliver salon-like results in the comfort of your home.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-2">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                            </svg></div>
                        <h5>Personalized Experience</h5>
                        <p>Every service is tailored to your needs, preferences, and by our experts.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-2">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg></div>
                        <h5>Trusted by Thousands</h5>
                        <p>Thousands of happy customers trust us for their beauty and wellness needs.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<section class="about-blue-footer about_skilled_trades mt-3">
    <div class="container">
        <div class="row about-blue-footer-right">
            <div class="col-lg-6 col-md-12">
                <h3 class="heading-size">Beauty Expertise, Delivered to Your Doorstep</h3>
                <p class="footer-content">Connecting trusted beauty professionals with clients who value convenience, quality and personalized care.
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
            <div class="col-lg-6  col-md-0 position-relative">
                <div class="abt-img-box">
                    <img class="abt-arrow-img" src="../images/psd-images/roll-arrow.png" />
                    <img class="abt-mob-img" src="../images/psd-images/mobile1.webp" />
                </div>
            </div>
        </div>
    </div>

</section>

@endsection