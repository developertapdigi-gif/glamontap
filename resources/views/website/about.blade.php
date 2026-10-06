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
                <p class="hero-v2-desc">Professional beauty experts delivering salon-quality services in the comfort, privacy and convenience of your home for easy beauty appointments.</p>
                <div class="row g-4 mb-lg-0 mb-4">
                    <div class="col-xxl-4 col-xl-6 col-md-6 col-12">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.9413 4.05904C19.1328 3.24504 18.1707 2.59969 17.1109 2.1604C16.051 1.72112 14.9145 1.49666 13.7673 1.50004C13.7279 1.50004 13.6885 1.50004 13.6488 1.50079C13.4266 1.50366 13.2126 1.58452 13.044 1.72923C12.8754 1.87393 12.7631 2.07328 12.7266 2.29241L11.6864 8.54254L9.32913 12.2438L1.9075 20.0127C1.64003 20.2902 1.49215 20.6616 1.49567 21.047C1.49918 21.4324 1.65381 21.801 1.9263 22.0736C2.19879 22.3462 2.56737 22.501 2.95278 22.5046C3.33819 22.5083 3.70965 22.3605 3.98725 22.0932L11.7573 14.6704L15.457 12.3139L21.7075 11.2733C21.9267 11.2369 22.1261 11.1246 22.2708 10.956C22.4155 10.7874 22.4963 10.5733 22.4991 10.3512C22.5183 9.18425 22.3016 8.02549 21.862 6.94435C21.4225 5.8632 20.7692 4.88158 19.9413 4.05904ZM3.46938 21.5502C3.33394 21.6843 3.15088 21.7594 2.96024 21.759C2.7696 21.7585 2.58689 21.6826 2.45206 21.5479C2.31723 21.4131 2.24126 21.2304 2.24075 21.0397C2.24025 20.8491 2.31526 20.666 2.44938 20.5305L9.6325 13.0118L10.9881 14.3674L3.46938 21.5502ZM11.5769 13.8957L10.8404 13.1595L10.1039 12.423L12.109 9.27529L13.8171 10.983L14.7246 11.8909L11.5769 13.8957ZM21.5845 10.533L15.4495 11.5545L14.7183 10.8233L17.2368 9.52729C17.3252 9.48174 17.3919 9.40293 17.4222 9.3082C17.4525 9.21347 17.4439 9.11058 17.3984 9.02216C17.3528 8.93375 17.274 8.86705 17.1793 8.83674C17.0846 8.80643 16.9817 8.81499 16.8933 8.86054L14.1614 10.2668L13.7331 9.83816L15.1394 7.10629C15.163 7.06241 15.1777 7.01425 15.1826 6.96463C15.1874 6.91501 15.1823 6.86492 15.1675 6.8173C15.1528 6.76968 15.1287 6.72548 15.0966 6.68728C15.0646 6.64909 15.0252 6.61766 14.9809 6.59485C14.9366 6.57204 14.8881 6.55829 14.8384 6.55442C14.7887 6.55055 14.7388 6.55663 14.6914 6.5723C14.6441 6.58797 14.6004 6.61292 14.5628 6.64569C14.5252 6.67847 14.4946 6.7184 14.4726 6.76316L13.1763 9.28166L12.4458 8.55079L13.4665 2.41579C13.4741 2.3701 13.4976 2.32855 13.5328 2.29839C13.5679 2.26823 13.6126 2.25138 13.6589 2.25079C13.6949 2.25004 13.7309 2.25004 13.7669 2.25004C14.8242 2.25054 15.8708 2.46097 16.8462 2.86911C17.8215 3.27725 18.7061 3.87498 19.4486 4.62764C20.1912 5.3803 20.7769 6.27289 21.1718 7.25366C21.5667 8.23443 21.7629 9.28384 21.7491 10.341C21.7485 10.3873 21.7317 10.4319 21.7015 10.467C21.6713 10.5021 21.6302 10.5255 21.5845 10.533Z" fill="#372315" />
                                </svg>

                            </div>
                            <div class="hero-service-text">
                                <h5>Makeup</h5>
                                <p>Bridal • Party • Event</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-6 col-md-6 col-12">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <img src="../images/Hair-Styling.svg" />
                            </div>
                            <div class="hero-service-text">
                                <h5>Hair Styling</h5>
                                <p>Cut • Style • Treat</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-6 col-md-6 col-12">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <img src="../images/Skincare.svg" />

                            </div>
                            <div class="hero-service-text">
                                <h5>Skincare</h5>
                                <p>Facials • Cleanups • Glow</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-6 col-md-6 col-12">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <img src="../images/Waxing.svg" />
                            </div>
                            <div class="hero-service-text">
                                <h5>Waxing</h5>
                                <p>Full Body • Facial</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-6 col-md-6 col-12">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.33998 11.0485H12.1424C12.3495 11.0475 12.5547 11.0876 12.7462 11.1664C12.9377 11.2453 13.1117 11.3612 13.2581 11.5077C13.4045 11.6541 13.5205 11.8281 13.5993 12.0196C13.6781 12.2111 13.7182 12.4163 13.7173 12.6234V19.4258C13.7178 19.6326 13.6773 19.8374 13.5983 20.0285C13.5193 20.2196 13.4032 20.3932 13.2568 20.5392C13.1105 20.6853 12.9366 20.8009 12.7454 20.8795C12.5541 20.9581 12.3492 20.9981 12.1424 20.9972H5.34349C5.13671 20.9981 4.93178 20.9581 4.74051 20.8795C4.54925 20.8009 4.37542 20.6853 4.22903 20.5392C4.08265 20.3932 3.9666 20.2196 3.88757 20.0285C3.80855 19.8374 3.7681 19.6326 3.76857 19.4258V12.6199C3.76764 12.4128 3.80774 12.2076 3.88656 12.0161C3.96538 11.8246 4.08135 11.6506 4.22778 11.5041C4.37421 11.3577 4.5482 11.2417 4.7397 11.1629C4.9312 11.0841 5.13641 11.044 5.34349 11.0449L5.33998 11.0485ZM12.1424 11.7972H5.34349C5.23504 11.7968 5.12757 11.8178 5.02732 11.8592C4.92708 11.9006 4.83605 11.9615 4.75952 12.0384C4.683 12.1152 4.62249 12.2065 4.58153 12.3069C4.54056 12.4074 4.51995 12.5149 4.52088 12.6234V19.4258C4.52041 19.5339 4.54137 19.6411 4.58255 19.7411C4.62372 19.8411 4.6843 19.932 4.76078 20.0085C4.83726 20.085 4.92813 20.1455 5.02814 20.1867C5.12816 20.2279 5.23534 20.2489 5.34349 20.2484H12.1459C12.2541 20.2489 12.3612 20.2279 12.4612 20.1867C12.5613 20.1455 12.6521 20.085 12.7286 20.0085C12.8051 19.932 12.8657 19.8411 12.9068 19.7411C12.948 19.6411 12.969 19.5339 12.9685 19.4258V12.6199C12.9694 12.5114 12.9488 12.4039 12.9079 12.3034C12.8669 12.203 12.8064 12.1117 12.7299 12.0349C12.6533 11.958 12.5623 11.8971 12.4621 11.8557C12.3618 11.8143 12.2544 11.7933 12.1459 11.7937L12.1424 11.7972Z" fill="#372315" />
                                    <path d="M6.35596 11.4039L6.83406 3.3535L6.85515 3.00195H10.6272L10.6483 3.3535L11.1264 11.4039L10.3812 11.4461L9.92414 3.74723H7.55824L7.10123 11.4461L6.35596 11.4039Z" fill="#372315" />
                                    <path d="M6.91138 7.98902H10.5569V8.73782H6.91138V7.98902ZM17.9499 17.9378V7.20508H18.6987V17.9378H17.9499Z" fill="#372315" />
                                    <path d="M17.7496 2.99805H18.8992C19.1509 2.99805 19.3923 3.09805 19.5703 3.27605C19.7483 3.45406 19.8483 3.69548 19.8483 3.94722V7.5822H16.804V3.95073C16.804 3.82609 16.8285 3.70266 16.8762 3.5875C16.9239 3.47234 16.9938 3.36771 17.082 3.27957C17.1701 3.19143 17.2747 3.12151 17.3899 3.07381C17.5051 3.02611 17.6285 3.00156 17.7531 3.00156L17.7496 2.99805ZM18.8992 3.75035H17.7496C17.6972 3.74999 17.6467 3.77018 17.609 3.8066C17.5713 3.84374 17.5498 3.89429 17.5492 3.94722V6.82989H19.096V3.94722C19.0964 3.89479 19.0762 3.84431 19.0398 3.8066C19.0021 3.77018 18.9516 3.74999 18.8992 3.75035ZM17.2715 17.1829H19.7499V17.5555L19.764 20.6245V20.9972H16.8848V20.6245L16.8954 17.5555V17.1829H17.2715ZM19.0046 17.9317H17.6406L17.6336 20.2484H19.0152L19.0046 17.9317Z" fill="#372315" />
                                </svg>

                            </div>
                            <div class="hero-service-text">
                                <h5>Nails</h5>
                                <p>Manicure • Pedicure</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-6 col-md-6 col-12">
                        <div class="hero-service-item">
                            <div class="hero-service-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.74997 11.6244C9.65051 11.6244 9.55513 11.5849 9.4848 11.5146C9.41448 11.4442 9.37497 11.3489 9.37497 11.2494C9.39391 10.3305 9.63475 9.42977 10.077 8.62403C10.1228 8.53577 10.2019 8.46933 10.2967 8.43933C10.3915 8.40934 10.4944 8.41825 10.5827 8.4641C10.6709 8.50995 10.7374 8.58898 10.7674 8.68382C10.7974 8.77865 10.7884 8.88152 10.7426 8.96978C10.3562 9.66886 10.1443 10.4509 10.125 11.2494C10.125 11.3489 10.0855 11.4442 10.0151 11.5146C9.94481 11.5849 9.84943 11.6244 9.74997 11.6244ZM6.37534 13.2238C6.30711 13.2239 6.24015 13.2053 6.18167 13.1702C6.12318 13.135 6.0754 13.0846 6.04347 13.0243C5.64497 12.2523 5.35306 11.4298 5.17572 10.5793C5.16357 10.5306 5.1613 10.48 5.16907 10.4304C5.17683 10.3808 5.19447 10.3333 5.22092 10.2907C5.24738 10.2481 5.28213 10.2112 5.3231 10.1822C5.36407 10.1533 5.41044 10.1328 5.45945 10.1221C5.50847 10.1114 5.55914 10.1106 5.60846 10.1198C5.65778 10.129 5.70475 10.1481 5.74658 10.1758C5.78842 10.2035 5.82427 10.2393 5.85201 10.2811C5.87975 10.3229 5.89882 10.3698 5.90809 10.4192C6.07113 11.203 6.33971 11.9612 6.70647 12.6729C6.73674 12.7301 6.75171 12.7941 6.74993 12.8587C6.74815 12.9234 6.72968 12.9865 6.69632 13.0419C6.66296 13.0973 6.61584 13.1431 6.55953 13.1749C6.50322 13.2067 6.43964 13.2234 6.37497 13.2234L6.37534 13.2238Z" fill="#372315" />
                                    <path d="M5.25 9.375C5.45711 9.375 5.625 9.20711 5.625 9C5.625 8.79289 5.45711 8.625 5.25 8.625C5.04289 8.625 4.875 8.79289 4.875 9C4.875 9.20711 5.04289 9.375 5.25 9.375Z" fill="#372315" />
                                    <path d="M11.25 7.875C11.4571 7.875 11.625 7.70711 11.625 7.5C11.625 7.29289 11.4571 7.125 11.25 7.125C11.0429 7.125 10.875 7.29289 10.875 7.5C10.875 7.70711 11.0429 7.875 11.25 7.875Z" fill="#372315" />
                                    <path d="M22.7951 15.5186C21.9182 14.4565 20.8768 13.5418 19.7103 12.8096C20.3634 11.1106 20.6716 9.29862 20.6167 7.47931C20.6118 7.38712 20.5731 7.29998 20.5079 7.23464C20.4427 7.1693 20.3556 7.13036 20.2634 7.12531C18.5574 7.07829 16.8575 7.34836 15.2501 7.92181C14.487 6.50561 13.4642 5.24568 12.2351 4.20781C12.1683 4.15421 12.0853 4.125 11.9997 4.125C11.9142 4.125 11.8311 4.15421 11.7644 4.20781C10.5353 5.24568 9.51251 6.50561 8.74943 7.92181C7.14212 7.34836 5.44232 7.07828 3.73643 7.12531C3.64432 7.13035 3.55731 7.16924 3.49211 7.2345C3.42692 7.29977 3.38812 7.38681 3.38318 7.47893C3.32823 9.29837 3.63635 11.1105 4.28955 12.8096C3.12309 13.5418 2.08161 14.4564 1.2048 15.5186C1.15295 15.5845 1.12476 15.6659 1.12476 15.7497C1.12476 15.8336 1.15295 15.915 1.2048 15.9809C1.3293 16.1396 4.29668 19.8746 8.06243 19.8746C9.5823 19.8746 10.9454 19.1396 11.9999 18.4481C13.0544 19.1396 14.4176 19.8746 15.9374 19.8746C19.7032 19.8746 22.6706 16.1396 22.7951 15.9806C22.8468 15.9147 22.875 15.8333 22.875 15.7496C22.875 15.6658 22.8468 15.5844 22.7951 15.5186ZM19.8738 7.86856C19.8682 9.02543 19.6653 12.7942 17.3598 15.1061C16.1976 16.2023 14.7723 16.9803 13.2217 17.3651C14.3756 16.1591 16.1249 13.8952 16.1249 11.2496C16.1145 10.339 15.9244 9.43937 15.5654 8.60243C16.9513 8.12251 18.4068 7.87443 19.8734 7.86818L19.8738 7.86856ZM11.9999 4.99643C12.8021 5.72131 15.3749 8.27918 15.3749 11.2496C15.3749 14.2199 12.8021 16.7778 11.9999 17.5027C11.1978 16.7778 8.62493 14.2196 8.62493 11.2496C8.62493 8.27956 11.1978 5.72131 11.9999 4.99643ZM8.43443 8.60243C8.0755 9.43937 7.88536 10.339 7.87493 11.2496C7.87493 13.8952 9.6243 16.1591 10.7782 17.3651C9.22765 16.9803 7.80252 16.2023 6.64043 15.1061C4.33418 12.7942 4.13168 9.02506 4.12643 7.86856C5.59301 7.87469 7.04854 8.12264 8.43443 8.60243ZM1.99043 15.7496C2.75289 14.8833 3.63175 14.127 4.60193 13.5022C4.98604 14.2903 5.49526 15.011 6.1098 15.6363C7.46921 16.9239 9.15909 17.8092 10.9916 18.1938C10.1135 18.7552 9.10346 19.0761 8.06243 19.1246C5.17493 19.1246 2.68868 16.5457 1.99043 15.7496ZM15.9374 19.1246C14.8965 19.0761 13.8866 18.7551 13.0087 18.1938C14.8412 17.8089 16.5311 16.9234 17.8904 15.6356C18.5048 15.0104 19.0139 14.2898 19.3979 13.5018C20.368 14.1271 21.247 14.8835 22.0098 15.7496C21.3127 16.5461 18.8306 19.1246 15.9374 19.1246Z" fill="#372315" />
                                </svg>

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
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="8" r="7" />
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88" />
                            </svg></div>
                        <h5>Verified Professionals</h5>
                        <p>All professionals are, qualified and continuously verified for your safety.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                <path d="M9 12l2 2 4-4" />
                            </svg></div>
                        <h5>Safe and Hygienic</h5>
                        <p>We follow strict hygiene protocols and use high-quality, tools for every service.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg></div>
                        <h5>Convenient and Flexible</h5>
                        <p>Book at your preferred time and place. We come to you, saving your time and effort.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                                <polyline points="2 17 12 22 22 17" />
                                <polyline points="2 12 12 17 22 12" />
                            </svg></div>
                        <h5>Premium Quality</h5>
                        <p>We use top-quality products to deliver salon-like results in the comfort of your home.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="why-card">
                        <div class="why-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                            </svg></div>
                        <h5>Personalized Experience</h5>
                        <p>Every service is tailored to your needs, preferences, and by our experts.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
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