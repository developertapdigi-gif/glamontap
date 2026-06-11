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
                    <h4 class="heading-size"> Let's Connect & <br> Create Something <span class= "color-text">Beautiful</span></h4>
                    <p class="mt-1 regular-grey-txt">Have questions, need assistance, or want to partner with us? Our team is here to help you every step of the way.</p>

                    <div class="service-box row">
                        <div class="col-6">
                            <div class="skill-tiles text-center email-cnt">
                                <i class="fa-regular fa-envelope contact-icon"></i>
                                <div>
                                    <h6 class="contact-info">Email Address</h6>
                                    <a href="mailto:{{$model['support_email']}}">{{$model['support_email']}}</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="skill-tiles text-center email-cnt">
                                <div class="contact-icon">
                                    <svg viewBox="0 0 24 24" width="22px" fill="none" stroke="#612d8a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="contact-info">Call Us</h6>
                                    <a href="tel:+91-9686681076">+91-9686681076</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="skill-tiles text-center email-cnt">
                                <div class="contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" width="22px" stroke="#612d8a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="contact-info">Business Hours</h6>
                                    <p>Mon‑Sat: 10AM‑6PM <br>
                                        Sun: 10AM‑4PM</p>

                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="skill-tiles text-center email-cnt">
                                <div class="contact-icon">
                                    <svg viewBox="0 0 24 24" width="22px" fill="none" stroke="#612d8a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
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
                    <h4 class="heading-size">Send Us a <span class="color-text">Message </span></h4>
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
        <div class="trust-bar-inner row">
            <div class="trust-item reveal col-3">
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
            <div class="trust-item reveal col-3">
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
            <div class="trust-item reveal col-3">
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
            <div class="trust-item reveal col-3">
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