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
            <h1>
                Contact
            </h1>
            <h3> Connect with us</h3>

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
                        <h4>Let’s Connect</h4>
                        <p class="mt-1 regular-grey-txt">Reach out today, and our team will respond promptly to assist with your home-service needs.</p>
                       
                        <div class = "service-box">
                        <div class="skill-tiles d-flex email-cnt">
                            <i class="bi bi-envelope-fill"></i>
                            <div>
                                <b class="black-tile-txt">Email Address</b>
                                <p>{{$model['support_email']}}</p>

                            </div>
                        </div>
                        </div>
 
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <h4>Got a question? Fill in the details below to find the answers</h4>
                    <form action="{{ route('submitform')}}" class="no-label-form" id="createform"  method="POST">
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
                            <textarea type="text" class="form-control @error('message') is-invalid @enderror" id="messageInput" placeholder="Message *" col="5" name="message"></textarea>
                            <div class="invalid-feedback" id="messageError"></div>
                        </div>                        
                        <button type="submit" class="btn btn-primary mt-lg-4 mt-md-3 mt-2 w-100" id="statussubmit2">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    <section class="blue-footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9 col-8">
                    <h3>Take the hassle out of finding trusted home-service experts.</h3>
                    <p>Contact us today and connect with verified professionals.</p>
                </div>
                <div class="col-lg-3 col-4 start-trial">
                <a href="{{ route('user.register') }}"><button class="skill-primary-btn white-btn strt-now">Start Now <p class="blue-circle"><img
                                src="../images/icons/start-now.png" /></p></button></a>

                </div>
            </div>
        </div>
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
                        if(response.status == 200) {
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
                        if(response.status === 422) {
                            var errors = response.responseJSON.errors;
                            Object.keys(errors).forEach(function (key) {
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