@php
use App\Models\Setting;
$model = Setting::setting();
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ $model['favicon'] }}" rel="icon" type="image/x-icon">
    <title>{{$model['name_of_website']}} - Login</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
    <body>
        <main role="main" class="container-fluid full-height">
            <div class="row full-height">
                <div class="col-lg-6 col-12 ps-0 pe-0">
                    <div class="left-login-section">
                        <a href="{{ url('/') }}?emp=1" class = "d-flex justify-content-center mb-3">
                            <img src="{{ $model['website_logo'] }}" class="login-logo d-md-block d-lg-none" />
                        </a>
                        <div class="left-login-top-text">
                            <h1>Find the right professionals for your jobs.</h1>
                            <p>From anywhere to everywhere</p>
                        </div>
                        <div class="left-login-banner">
                            <img src="{{ asset('images/psd-images/macbook.png') }}" class="img-fluid"/>
                        </div>
                    </div>

                </div> 
                <div class="col-lg-6 col-12  relative-box white-background">
                    <div class="right-login-section mb-0 mb-lg-3 register-right-section">
                        <a href="{{ url('/') }}?emp=1">
                            <img src="{{ $model['website_logo'] }}" class="login-logo d-none d-lg-block" />
                        </a>
                        <div class="login-user-details">
                            <h4> Login to your account </h4>
                            <form role="form" method="POST" class="skill-login-form" action="{{ route('user.loginpost') }}" id='createform'>
                               @csrf                          
                                <div class="form-group form-login-group mb-4">
                                  <label for="email">Email</label>
                                  <input type="email" name="email" placeholder="" class="form-control @error('email') is-invalid @enderror" aria-label="Email" @if(Cookie::get('login_email')) value="{{ Cookie::get('login_email') }}" @endif>
                                   @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group form-login-group mb-4">
                                  <label for="password">Password</label>
                                  <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control @error('email') is-invalid @enderror" placeholder="" aria-label="Password" @if(Cookie::get('login_password')) value="{{Cookie::get('login_password')}}" @endif>
                                    <span class="input-group-addon" id="show_hide_password">
                                    <i class="bi bi-eye-slash-fill" id="togglePassword" 
                                    style="cursor: pointer"></i>
                                    </span>
                                  </div>
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                <div class="row">
                                   <div class="col-6">
                                        <div class="form-check form-group form-login-group">
                                            <input class="form-check-input" name="rememberme" type="checkbox" id="rememberMe"  @if(Cookie::get('login_email')) checked @endif>
                                            <label class="form-check-label text-secondary" for="remember_me">
                                            Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <a href="/user/password/reset" class="link-secondary text-decoration-none">Forgot password?</a>
                                        </div>

                                    </div>
                                </div>
                                 <div class="row align-items-center submit-buttons">
                                    <div class = "col-xl-4 col-6">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </div>
                                    <div class="link-secondary col-xl-5 col-12 account">  Don't have an Account? </div>

                                    <div class = "col-xl-3 col-6 register_btn">
                                         <a href="register" class="btn btn-primary btn-black text-decoration-none">Register</a>
                                    </div>
                                 </div>
                              </form>
                        </div>
                    </div>
                    <div class="reserved copyright-login">All Rights Reserved by {{$model['name_of_website']}}</div>
                </div>
              </div>
        </main>
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery-3.7.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <style type="text/css">
        .alert{z-index: 99; top: 60px;right:18px; min-width:30%; position: fixed;animation: slideflash 0.5s forwards;     }
        @keyframes slideflash { 100% { top: 30px; }     }
        .error {width: 100%;color: red !important;margin-top: 5px;    }
        @media screen and (max-width: 668px)
        {
            .alert{ left: 10px;right: 10px; }
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
        $("#show_hide_password").on('click', function(event) {
        
        event.preventDefault();
        if($('#password').attr("type") == "text"){
            $('#password').attr('type', 'password');
            $('#show_hide_password i').addClass( "bi-eye-slash-fill" );
            $('#show_hide_password i').removeClass( "bi-eye-fill" );
        }else if($('#password').attr("type") == "password"){
            $('#password').attr('type', 'text');
            $('#show_hide_password i').removeClass( "bi-eye-slash-fill" );
            $('#show_hide_password i').addClass( "bi-eye-fill" );
        }
    });
});
        var createform = $('#createform');
    createform.validate({
        ignore: [],
        rules: {
            email: {
                required: true,
            },
            password:{
                required: true
            },
            
        },

        submitHandler: function(form) {
           form.submit();
        }
    });
    </script>
    </body>
</html>
