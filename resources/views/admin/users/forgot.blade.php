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
    <title>{{$model['name_of_website']}} - Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
    <body>
        <main role="main" class="container-fluid full-height">
            <div class="row full-height">
                <div class="col-md-6 col-lg-6 col-sm-12 ps-0 pe-0">
                    <div class="left-login-section">
                        <a href="/">
                            <img src="{{ $model['website_logo'] }}" class="login-logo d-sm-block d-md-none"/>
                        </a>
                        <div class="left-login-top-text">
                            <h1>
                            Reset your {{$model['name_of_website']}} <br>password for account access
                            </h1>
                            <p>No worries , we'll send you instruction for reset</p>
                        </div>
                        <div class="left-login-banner">
                            <img src="{{ asset('images/psd-images/mobile.png') }}" class="img-fluid"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12  relative-box">
                @include('flash-message')
                    <div class="right-login-section">
                        <a href="/">
                            <img src="{{ $model['website_logo'] }}" class="login-logo d-none d-md-block"/>
                        </a>
                        <div class="login-user-details">
                            Forgot Password
                            <div class="sub-heading">Enter your email address and we'll send you a link to reset your password.</div>
                           <form role="form" class="text-start skill-login-form" method="POST" action="{{ route('user.reset.email') }}">
                               @csrf
                                <div class="form-group form-login-group mb-4">
                                  <label for="email">Email Address</label>
                                  <input type="email" name="email" placeholder="Enter your register email" class="form-control @error('email') is-invalid @enderror" aria-label="Email">
                                   @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                 <div class="submit-buttons">
                                    <button type="submit" class="btn btn-primary btn-right-margin">Reset password</button>
                                    <a href="/user/login" class="text-decoration-none"><button type="button" class="btn btn-primary btn-black">Back</button></a>
                                 </div>
                                    
                              </form>
                        </div>
                    </div>
                    <div class="reserved">All Rights Reserved by {{$model['name_of_website']}}  </div>
                </div>
              </div>
        </main>
         <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    </body>   
</html>
