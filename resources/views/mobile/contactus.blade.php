@php
use App\Models\Setting;
$model = Setting::setting();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="{{ $model['favicon'] }}" rel="icon" type="image/x-icon">
  <title>Contact Us | {{$model['name_of_website']}}</title>
  <meta name="robots" content="noindex, nofollow, noarchive">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  <link href="{{ asset('css/slider.css') }}" rel="stylesheet">
  <link href="{{ asset('fortawesome/css/all.min.css') }}" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}">
  @yield('css')

</head>

<body class="index-page">

<div class="top-content">
        <div class="row skill-title text-center mb-4">
            <h1>
                Contact
            </h1>
            <h3 class="mb-4"> Connect with us</h3>
        </div>
    </div>

    <div class="container-fluid">
        <div class="mid-content skill-about-content">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="contact-left-content">
                        <h4> Get In Touch</h4>
                        <p class="mt-1 regular-grey-txt">Looking to collaborate? Contact us on the details below and we will get in touch soon.</p>
                       

                        <div class="skill-tiles d-flex">
                            <i class="bi bi-envelope-fill"></i>
                            <div>
                                <b class="black-tile-txt">Email Address</b>
                                <p>{{$model['support_email']}}</p>

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
                        <button type="submit" class="btn btn-primary mt-4 w-100" id="statussubmit">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    <!-- <section class="blue-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3>Take your construction jobs to the next level!?</h3>
                    <p>Register now to get top-notch trades of the industry around you.</p>
                </div>
                <div class="col-md-4">
                <a href="{{ route('user.register') }}"><button class="skill-primary-btn white-btn strt-now">Start Now <p class="blue-circle"><img
                                src="../images/icons/start-now.png" /></p></button></a>

                </div>
            </div>
        </div>
    </section> -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="{{ asset('js/slick.min.js') }}" type="text/javascript" charset="utf-8"></script>
@yield('script')
<div class="loader" style="display: none;"></div>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
    var createform = $('#createform');
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
        $('#createform').submit(function (e) {
        e.preventDefault();
        $('#statussubmit').attr("disabled", true).text("Please wait..!");      
        var form = $("#createform");
        var formData = new FormData(form[0]);
        $(".invalid-feedback").text("");
        $("#createform input").removeClass("is-invalid");
        $('.loader').show();
        $.ajax({
            method: "POST",
            processData: false,
            contentType: false,
            url:form.attr('action'),
            data: formData,
            success: (response) =>{
             $('.loader').hide();
              if(response.status==200){
                $('form#createform').trigger("reset");
                $('#statussubmit').attr("disabled", false).text("Submit");                            
                  Swal.fire({                       
                   icon: "success",
                   title: "Success!",
                   text: response.message,
                   timer:3000
                 });     
                ajax_table.ajax.reload();
              }
            },
            error: (response) => {
                 $('.loader').hide();
                $('#statussubmit').attr("disabled", false).text("Submit");
                if(response.status === 422) {
                    var errors = $.parseJSON(response.responseText).errors;
                    Object.keys(errors).forEach(function (key) {                
                        $("#" + key + "Input").addClass("is-invalid");
                        $("#" + key + "Error").text(errors[key][0]);
                    });
                } else {
                   window.location.reload();
                }
            }
        })
});
       }
   });
</script>
<script>
$(document).on('ready', function() {
 $(".center_slider").slick({
      dots: true,
      infinite: true,
      centerMode: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      variableWidth: true
    });
});
setTimeout(function() { $(".alert").alert('close'); },5000);
</script>
</body>
</html>