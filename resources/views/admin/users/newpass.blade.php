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
                        <img src="{{ $model['website_logo'] }}" class="login-logo d-sm-block d-md-none" />
                    </a>
                    <div class="left-login-top-text">
                        <h1>
                            Explore the Platform To Connect With Skilled Tradesmen
                        </h1>
                        <p>Discover a Hub to Connect with Right Fit Tradesmen for Your Projects</p>
                    </div>
                    <div class="left-login-banner">
                        <img src="{{ asset('images/psd-images/mobile.png') }}" class="img-fluid" />
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12  relative-box">
                <div class="right-login-section">
                    <a href="/">
                        <img src="{{ $model['website_logo'] }}" class="login-logo d-none d-md-block" />
                    </a>
                    <div class="login-user-details">
                        Set a New Password
                        <form role="form" class="text-start skill-login-form" method="POST" action="{{ route('user.reset.setpass') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{request()->route('token')}}">
                            <div class="form-group form-login-group mb-4 tooltip_text">
                                <label for="email">Password </label>
                                <div class="password-tooltip ms-2" data-bs-toggle="tooltip" data-bs-placement="right" title="Password must be 8-20 characters and include at least one uppercase letter and one number. No spaces.">
                                    <!-- <span>Password must be 8-20 characters and include at least one uppercase letter and one number. No spaces.</span> -->
                                    <svg width="512" height="512" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M256 426.846C161.795 426.846 85.1553 350.205 85.1553 256C85.1553 161.795 161.795 85.1543 256 85.1543C350.205 85.1543 426.845 161.795 426.845 256C426.845 350.205 350.205 426.846 256 426.846ZM256 105.154C172.824 105.154 105.155 172.823 105.155 256C105.155 339.177 172.824 406.846 256 406.846C339.176 406.846 406.845 339.177 406.845 256C406.845 172.823 339.176 105.154 256 105.154Z" fill="#FF6461" />
                                        <path d="M256.507 169.769C255.849 169.77 255.193 169.707 254.547 169.578C253.907 169.449 253.281 169.259 252.677 169.009C252.073 168.758 251.493 168.45 250.947 168.089C250.404 167.723 249.895 167.308 249.427 166.849C248.965 166.384 248.55 165.874 248.187 165.328C247.828 164.781 247.52 164.202 247.267 163.599C247.018 162.996 246.827 162.369 246.697 161.729C246.431 160.439 246.431 159.108 246.697 157.818C246.827 157.178 247.018 156.552 247.267 155.948C247.52 155.345 247.828 154.766 248.187 154.219C249.097 152.847 250.333 151.721 251.784 150.942C253.235 150.163 254.856 149.756 256.502 149.756C258.149 149.756 259.77 150.163 261.221 150.942C262.672 151.721 263.907 152.847 264.817 154.219C265.176 154.766 265.484 155.345 265.737 155.948C265.987 156.552 266.178 157.178 266.307 157.818C266.574 159.108 266.574 160.439 266.307 161.729C266.178 162.369 265.987 162.996 265.737 163.599C265.484 164.202 265.176 164.781 264.817 165.328C264.455 165.874 264.039 166.384 263.577 166.849C262.646 167.775 261.541 168.509 260.327 169.009C259.724 169.259 259.098 169.449 258.457 169.578C257.815 169.706 257.162 169.77 256.507 169.769ZM256.5 363.228C253.848 363.228 251.305 362.175 249.429 360.299C247.554 358.424 246.5 355.88 246.5 353.228V214.828H233.069C230.417 214.828 227.874 213.775 225.998 211.899C224.123 210.024 223.069 207.48 223.069 204.828C223.069 202.176 224.123 199.632 225.998 197.757C227.874 195.882 230.417 194.828 233.069 194.828H256.5C259.153 194.828 261.696 195.882 263.571 197.757C265.447 199.632 266.5 202.176 266.5 204.828V353.228C266.5 355.88 265.447 358.424 263.571 360.299C261.696 362.175 259.153 363.228 256.5 363.228Z" fill="#FF6461" />
                                    </svg>

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
                <div class="reserved">All Rights Reserved by {{$model['name_of_website']}} </div>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
</body>

</html>