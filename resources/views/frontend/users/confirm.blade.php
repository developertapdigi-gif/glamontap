<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('images/favicon.png') }}" rel="icon" type="image/x-icon">
    <title>{{config('app.name')}} - Register</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
    <body>
        @include('flash-message')
        <main role="main" class="container-fluid full-height">
            <div class="row full-height">
                <div class="col-md-6 col-lg-6 col-sm-12 ps-0 pe-0">
                    <div class="left-login-section">
                        <a href="/register">
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
                <div class="col-md-6 col-lg-6 col-sm-12  relative-box">
                    <div class="right-login-section">
                        <a href="/register">
                            <img src="{{ asset('images/psd-images/logo.png') }}" class="login-logo d-none d-md-block"/>
                        </a>
                        <div class="login-user-details">
                            Set a New Password
                            <form role="form" class="text-start" method="POST" action="{{ route('createNewPass') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{request()->route('token')}}">
                                 <div class="form-group form-login-group mb-4">
                                   <label for="email">Password</label>
                                   <input type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                         <div class="alert alert-danger">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div class="form-group form-login-group mb-4">
                                   <label for="email">Confirm Password</label>
                                   <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                         <div class="alert alert-danger">{{ $message }}</div>
                                     @enderror
                                 </div>
                                  <div class="submit-buttons">
                                     <button type="submit" class="btn btn-primary btn-right-margin">Set a New Password</button>
                                  </div>
                               </form>

                        </div>
                    </div>
                    <div class="reserved">Copyright © {{date('Y')}} {{config('app.name')}}</div>
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
        });
    </script>
</body>
</html>
