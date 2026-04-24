<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('images/favicon.png') }}" rel="icon" type="image/x-icon">
    <title>{{config('app.name')}} - Login</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
    <body>
        @include('flash-message')
        <main role="main" class="container-fluid full-height">
            <div class="row full-height">
                <div class="col-md-6 col-lg-6 col-sm-12 ps-0 pe-0">
                    <div class="left-login-section">
                        <a href="/">
                            <img src="{{ asset('images/psd-images/logo.png') }}" class="login-logo d-sm-block d-md-none"/>
                        </a>
                        <div class="left-login-top-text">
                            <h1>
                                Explore the Platform To Connect With Skilled Tradesmen
                            </h1>
                            <p>Discover a Hub to Connect with Right Fit Tradesmen for Your Projects</p>
                        </div>
                        <div class="left-login-banner">
                            <img src="{{ asset('images/psd-images/macbook.png') }}" class="img-fluid"/>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col-lg-6 col-sm-12  relative-box white-background">
                    <div class="right-login-section">
                        <a href="/">
                            <img src="{{ asset('images/psd-images/logo.png') }}" class="login-logo d-none d-md-block"/>
                        </a>
                        <div class="login-user-details">
                            Log into your account
                            <form role="form" class="skill-login-form" method="POST" action="{{ route('loginpost') }}">
                               @csrf
                                <div class="form-group form-login-group mb-4">
                                  <label for="email">Email Address</label>
                                  <input type="email" name="email" placeholder="Please enter your email" class="form-control @error('email') is-invalid @enderror" aria-label="Email">
                                   @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group form-login-group mb-4">
                                  <label for="password">Password</label>
                                  <div class="input-group">
                                  <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="WallaceLema" placeholder="enter your passsword">
                                  <span class="input-group-addon" id="show_hide_password">
                                    <i class="bi bi-eye-slash-fill" id="togglePassword"
                                   style="cursor: pointer"></i>
                                   </span>
                                    @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                                <div class="row">
                                   <div class="col-6">
                                        <div class="form-check form-group form-login-group">
                                            <input class="form-check-input" name="rememberme" type="checkbox" id="rememberMe" checked="">
                                            <label class="form-check-label text-secondary" for="remember_me">
                                            Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <a href="/password/forgot" class="link-secondary text-decoration-none">Forgot password?</a>
                                        </div>

                                    </div>
                                </div>
                                 <div class="submit-buttons">
                                    <button type="submit" class="btn btn-primary btn-right-margin">Login</button>
                                    <a href="/register" class="btn btn-primary btn-black text-decoration-none">Register</a>
                                 </div>

                              </form>
                        </div>
                    </div>
                    <div class="reserved">All Rights Reserved by Skill House</div>
                </div>
              </div>
        </main>
            <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <style type="text/css">
        .alert{z-index: 99; top: 60px;right:18px; min-width:30%; position: fixed;animation: slideflash 0.5s forwards;     }
        @keyframes slideflash { 100% { top: 30px; }     }
        .error {width: 100%;color: red;margin-top: 5px;    }
        @media screen and (max-width: 668px)
        {
            .alert{ left: 10px;right: 10px; }
        }
    </style>
    <script type="text/javascript">
        /* auto close flash message*/
        $(document).ready(function(){
          setTimeout(function() { $(".alert").alert('close'); }, 3000);

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

    </script>

    </body>
</html>
