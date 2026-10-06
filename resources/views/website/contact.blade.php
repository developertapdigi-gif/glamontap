@extends($layout)
@section('title')
Contact Us
@endsection
@php
use App\Models\Setting;
$model = Setting::setting();
@endphp
@section('content')
<div class="top-content banner-outer">
    <div class="row skill-title text-center">
        <h1 class="heading-size">
            Contact
        </h1>

        <ul class="skill-breadcrumbs d-flex justify-content-center">
            <li><a href="{{(session('employer_mode')?'/employer':'/')}}">Home</a> <i class="bi bi-arrow-right"></i></li>
            <li>Contact</li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="mid-content skill-about-content">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="contact-left-content contact-content">
                    <h4 class="heading-size"> Let's Connect & <br> Create Something <span class="color-text">Beautiful</span></h4>
                    <p class="mt-1 regular-grey-txt">Have questions, need assistance, or want to partner with us? Our team is here to help you every step of the way.</p>

                    <div class="service-box row">
                        <div class="col-md-6 col-12">
                            <div class="skill-tiles text-center email-cnt">
                                <i class="fa-regular fa-envelope contact-icon"></i>
                                <div>
                                    <h6 class="contact-info">Email Address</h6>
                                    <a href="mailto:{{$model['support_email']}}">{{$model['support_email']}}</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="skill-tiles text-center email-cnt">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.9999 16.9201V19.9201C22.0011 20.1986 21.944 20.4743 21.8324 20.7294C21.7209 20.9846 21.5572 21.2137 21.352 21.402C21.1468 21.5902 20.9045 21.7336 20.6407 21.8228C20.3769 21.912 20.0973 21.9452 19.8199 21.9201C16.7428 21.5857 13.7869 20.5342 11.1899 18.8501C8.77376 17.3148 6.72527 15.2663 5.18993 12.8501C3.49991 10.2413 2.44818 7.27109 2.11993 4.1801C2.09494 3.90356 2.12781 3.62486 2.21643 3.36172C2.30506 3.09859 2.4475 2.85679 2.6347 2.65172C2.82189 2.44665 3.04974 2.28281 3.30372 2.17062C3.55771 2.05843 3.83227 2.00036 4.10993 2.0001H7.10993C7.59524 1.99532 8.06572 2.16718 8.43369 2.48363C8.80166 2.80008 9.04201 3.23954 9.10993 3.7201C9.23693 4.6801 9.47093 5.6231 9.80993 6.5301C9.94448 6.88802 9.9736 7.27701 9.89384 7.65098C9.81408 8.02494 9.6288 8.36821 9.35993 8.6401L8.08993 9.9101C9.51349 12.4136 11.5864 14.4865 14.0899 15.9101L15.3599 14.6401C15.6318 14.3712 15.9751 14.1859 16.3491 14.1062C16.723 14.0264 17.112 14.0556 17.4699 14.1901C18.3769 14.5291 19.3199 14.7631 20.2799 14.8901C20.7657 14.9586 21.2093 15.2033 21.5265 15.5776C21.8436 15.9519 22.0121 16.4297 21.9999 16.9201Z" stroke="#372315" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                </div>
                                <div>
                                    <h6 class="contact-info">Call Us</h6>
                                    <a href="tel:+91-9686681076">+91-9686681076</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="skill-tiles text-center email-cnt">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#372315" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 6V12L16 14" stroke="#372315" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                </div>
                                <div>
                                    <h6 class="contact-info">Business Hours</h6>
                                    <p>Mon‑Sat: 10AM‑6PM <br>
                                        Sun: 10AM‑4PM</p>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="skill-tiles text-center email-cnt">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 10C20 16 12 22 12 22C12 22 4 16 4 10C4 7.87827 4.84285 5.84344 6.34315 4.34315C7.84344 2.84285 9.87827 2 12 2C14.1217 2 16.1566 2.84285 17.6569 4.34315C19.1571 5.84344 20 7.87827 20 10Z" stroke="#372315" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#372315" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                </div>
                                <div>
                                    <h6 class="contact-info">Our Location</h6>
                                    <a href="https://maps.app.goo.gl/wxc76ZVtUqZyRHVXA" target="_blank">Office G5, D-229, Sector 74, Mohali, Punjab 140307</a>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-card">
                    <h4 class="heading-size send-us">Send Us a <span class="color-text">Message </span></h4>
                    <form action="{{ route('submitform')}}" class="no-label-form" id="createform" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-2 mt-2 col-md-6">
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_nameInput" placeholder="First Name *" name="first_name">
                                <div class="invalid-feedback" id="first_nameError"></div>
                            </div>
                            <div class="mb-2 mt-2 col-md-6">
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_nameInput" placeholder="Last Name *" name="last_name">
                                <div class="invalid-feedback" id="last_nameError"></div>
                            </div>
                        </div>
                        <div class="mb-3 mt-2 col-md-12">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="emailInput" placeholder="Email *" name="email">
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>
                        <div class="mb-3 mt-2 col-md-12">
                            <input type="phone" class="form-control @error('phone') is-invalid @enderror" id="phoneInput" placeholder="Phone" name="phone">
                            <div class="invalid-feedback" id="phoneError"></div>
                        </div>
                        <div class="mb-3 mt-3 col-md-12">
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subjectInput" placeholder="Subject *" name="subject">
                            <div class="invalid-feedback" id="subjectError"></div>
                        </div>
                        <div class="mb-3 mt-3 col-md-12">
                            <textarea type="text" class="form-control @error('message') is-invalid @enderror" id="messageInput" placeholder="Message *" col="8" name="message"></textarea>
                            <div class="invalid-feedback" id="messageError"></div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-lg-4 mt-md-3 mt-2 w-100" id="statussubmit2"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg> Send Message</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<section class="blue-footer">
    <section class="trust-bar container" id="trust-section">
        <div class="trust-bar-inner row gy-4">
            <div class="trust-item reveal col-xl-3 col-md-6">
                <div class="trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <div>
                    <h4>Fast Response</h4>
                    <p>We reply within 24 hours</p>
                </div>
            </div>
            <div class="trust-item reveal col-xl-3 col-md-6">
                <div class="trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                </div>
                <div>
                    <h4>Friendly Support</h4>
                    <p>Our team is always happy to help</p>
                </div>
            </div>
            <div class="trust-item reveal col-xl-3 col-md-6">
                <div class="trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <div>
                    <h4>Secure &amp; Safe</h4>
                    <p>Your information is 100% secure</p>
                </div>
            </div>
            <div class="trust-item reveal col-xl-3 col-md-6">
                <div class="trust-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div>
                    <h4>Trusted by Thousands</h4>
                    <p>Loved by professionals &amp; clients</p>
                </div>
            </div>
        </div>
    </section>
    <!-- <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-9 col-8">
                <h3>Bringing Beauty & Wellness to Your Doorstep</h3>
                <p>Discover salon-quality beauty services delivered by skilled professionals. Get in touch with us and let us help you create your perfect beauty experience.</p>
            </div>
            <div class="col-lg-3 col-4 start-trial">
                <a href="{{ route('user.register') }}"><button class="skill-primary-btn white-btn strt-now">Start Now <p class="blue-circle"><img
                                src="../images/icons/start-now.png" /></p></button></a>

            </div>
        </div>
    </div> -->
</section>
@endsection
@section('script')
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var createform = $('#createform');
        var isSubmitting = false; // Flag to track submission state

        createform.validate({
            ignore: [],
            rules: {
                first_name: {
                    required: true,
                    minlength: 3,
                },
                last_name: {
                    required: true,
                    minlength: 3,
                },
                email: {
                    required: true,
                },
                phone: {
                    required: false,
                },
                subject: {
                    required: true,
                },
                message: {
                    required: true,
                    minlength: 3,
                },
            },
            submitHandler: function(form) {
                if (isSubmitting) return false; // Block if already submitting

                // Disable button and set submission flag
                isSubmitting = true;
                $('#statussubmit').attr("disabled", true).text("Sending...");

                var formData = new FormData(form);
                $(".invalid-feedback").text("");
                $("input, textarea", form).removeClass("is-invalid");
                $('.loader').show();
                $.ajax({
                    method: "POST",
                    processData: false,
                    contentType: false,
                    url: $(form).attr('action'),
                    data: formData,
                    success: (response) => {
                        $('.loader').hide();
                        if (response.status == 200) {
                            form.reset();
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: response.message,
                                timer: 3000
                            });
                        }
                    },
                    error: (response) => {
                        if (response.status === 422) {
                            var errors = response.responseJSON.errors;
                            Object.keys(errors).forEach(function(key) {
                                $("#" + key + "Input").addClass("is-invalid");
                                $("#" + key + "Error").text(errors[key][0]);
                            });
                        }
                    },
                    complete: () => {
                        // Always re-enable after request finishes
                        isSubmitting = false;
                        $('#statussubmit').attr("disabled", false).text("Send Message");
                    }
                });
            }
        });
    });
</script>
@endsection