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
    <title>{{$model['name_of_website']}} - Set New Password</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
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
                                Explore the Platform To Connect With Skilled Tradesmen
                            </h1>
                            <p>Discover a Hub to Connect with Right Fit Tradesmen for Your Projects</p>
                        </div>
                        <div class="left-login-banner">
                            <img src="{{ asset('images/psd-images/mobile.png') }}" class="img-fluid"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12  relative-box">
                    <div class="right-login-section">
                        <a href="/">
                            <img src="{{ $model['website_logo'] }}" class="login-logo d-none d-md-block"/>
                        </a>
                        <div class="login-user-details">
                            Set a New Password
                           <form role="form" class="text-start skill-login-form" method="POST" action="{{ route('user.reset.setpass') }}">
                               @csrf 
                               <input type="hidden" name="token" value="{{request()->route('token')}}">
                                <div class="form-group form-login-group mb-4 tooltip_text">
                                  <label for="email">Password </label>
                                  <div class="password-tooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="Password must be 8-20 characters and include at least one uppercase letter and one number. No spaces.">
                                    <!-- <span>Password must be 8-20 characters and include at least one uppercase letter and one number. No spaces.</span> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M256 426.846c-94.205 0-170.845-76.641-170.845-170.846S161.795 85.154 256 85.154 426.845 161.795 426.845 256 350.205 426.846 256 426.846zm0-321.692c-83.176 0-150.845 67.669-150.845 150.846S172.824 406.846 256 406.846 406.845 339.177 406.845 256 339.176 105.154 256 105.154z" fill="#000000" opacity="1" data-original="#000000"></path><path d="M256.507 169.769a9.941 9.941 0 0 1-1.96-.191 10.1 10.1 0 0 1-1.87-.569 10.31 10.31 0 0 1-1.73-.92 10.684 10.684 0 0 1-1.52-1.24 10.048 10.048 0 0 1-1.24-1.521 10.666 10.666 0 0 1-.92-1.729 10.145 10.145 0 0 1-.57-1.87 9.66 9.66 0 0 1 0-3.911 10.145 10.145 0 0 1 .57-1.87 10.666 10.666 0 0 1 .92-1.729 9.977 9.977 0 0 1 16.63 0 10.666 10.666 0 0 1 .92 1.729 10.145 10.145 0 0 1 .57 1.87 9.66 9.66 0 0 1 0 3.911 10.145 10.145 0 0 1-.57 1.87 10.666 10.666 0 0 1-.92 1.729 10.048 10.048 0 0 1-1.24 1.521 10.042 10.042 0 0 1-3.25 2.16 10.1 10.1 0 0 1-1.87.569 9.915 9.915 0 0 1-1.95.191zM256.5 363.228a10 10 0 0 1-10-10v-138.4h-13.431a10 10 0 1 1 0-20H256.5a10 10 0 0 1 10 10v148.4a10 10 0 0 1-10 10z" fill="#000000" opacity="1" data-original="#000000"></path></g></svg>
                                  </div>
                                  <input type="password" name="password" title="Password must be 8-20 characters and include at least one uppercase letter and one number. No spaces." placeholder="" class="form-control @error('password') is-invalid @enderror">
                                   @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>     
                                <div class="form-group form-login-group mb-4">
                                  <label for="email">Confirm Password</label>
                                  <input type="password" name="password_confirmation" placeholder="" class="form-control @error('password_confirmation') is-invalid @enderror">
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
                    <div class="reserved">All Rights Reserved by {{$model['name_of_website']}}  </div>
                </div>
              </div>
        </main>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>  
        <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        </script>
    </body>
</html>  