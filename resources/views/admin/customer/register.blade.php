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
    <title>{{ $model['name_of_website'] }} - Apply as Customer</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Toggle switch styling */
        .apply-toggle {
            text-align: center;
            margin-bottom: 2rem;
        }
        .apply-toggle h3 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #1e2a3e;
            margin-bottom: 1rem;
        }
        .toggle-buttons {
            display: inline-flex;
            background: #f1f5f9;
            border-radius: 50px;
            padding: 10px;
            gap: 0.2rem;
        }
        .toggle-btn {
            padding: 0.6rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            background: transparent;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #475569;
        }
        .toggle-btn.active {
            background: white;
            color: #0d6efd;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .toggle-btn:focus {
            outline: none;
        }
        .form-card {
            transition: all 0.2s ease;
        }
        .form-login-group label {
            font-weight: 500;
            margin-bottom: 0.3rem;
        }
        .submit-buttons {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            margin-top: 1.5rem;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 0.5rem 1.8rem;
            font-weight: 500;
        }
        .skill-link {
            color: #0d6efd;
            text-decoration: none;
        }
        .error {
            width: 100%;
            color: #dc3545 !important;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        .text-danger.small {
            font-size: 0.7rem;
        }
        .terms-note {
            margin-top: 1.2rem;
            padding-top: 0.8rem;
            border-top: 1px solid #e9ecef;
            text-align: center;
            font-size: 0.8rem;
        }
        @media (max-width: 576px) {
            .toggle-btn {
                padding: 0.4rem 1.2rem;
                font-size: 0.9rem;
            }
            .apply-toggle h3 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <main role="main" class="container-fluid full-height">
        <div class="row full-height">
            <!-- Left side: branding / illustration -->
            <div class="col-md-6 col-lg-6 col-sm-12 ps-0 pe-0">
                <div class="left-login-section">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/psd-images/logo.png') }}" class="login-logo d-sm-block d-md-none"/>
                    </a>
                    <div class="left-login-top-text">
                        <h1>Discover Trusted Beauty Professionals Near You</h1>
                        <p>Experience convenience, quality and personalized care with beauty experts ready to deliver exceptional services at your doorstep.</p>
                    </div>
                    <div class="left-login-banner">
                        <img src="{{ asset('images/psd-images/macbook.png') }}" class="img-fluid"/>
                    </div>
                </div>
            </div>

            <!-- Right side: registration with Employee / Hirer toggle -->
            <div class="col-lg-6 col-12 relative-box white-background">
                @include('flash-message')

                <div class="right-login-section register-right-section">
                     <a href="{{ url('/') }}">
                        <img src="{{ $model['website_logo'] }}" class="login-logo d-none d-lg-block" />
                    </a>
                    <div class="login-user-details">
                        <!-- Toggle -->
                         <h3 class="dynamic-heading" id="formHeading">Customer Register</h3>

                        <!-- TRADIE REGISTRATION FORM -->
                        <div id="employeeForm" class="form-card">
                            <form role="form" action="{{ route('customer.registerpost') }}" method="POST" class="login-form" id="customerFormValidate">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>First Name *</label>
                                            <input type="text" name="customer_first_name" class="form-control" value="{{ old('customer_first_name') }}">
                                            @error('customer_first_name')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Last Name *</label>
                                            <input type="text" name="customer_last_name" class="form-control" value="{{ old('customer_last_name') }}">
                                            @error('customer_last_name')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Email *</label>
                                            <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}">
                                            @error('customer_email')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Phone *</label>
                                            <input type="text" name="customer_mobile" class="form-control" value="{{ old('customer_mobile') }}">
                                            @error('customer_mobile')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Password *</label>
                                            <input type="password" name="customer_password" class="form-control" value="{{ old('customer_password') }}">
                                            @error('customer_password')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Confirm Password *</label>
                                            <input type="password" name="customer_confirm_password" class="form-control" value="{{ old('customer_confirm_password') }}">
                                            @error('customer_confirm_password')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Address *</label>
                                            <input type="text" name="customer_address" id="customer_address" class="form-control" value="{{ old('customer_address') }}" placeholder="Enter a location">
                                            <input type="hidden" name="customer_latitude" id="customer_latitude">
                                            <input type="hidden" name="customer_longitude" id="customer_longitude">
                                            <input type="hidden" name="customer_city" id="customer_city">
                                            <input type="hidden" name="customer_state" id="customer_state">
                                            <input type="hidden" name="customer_country" id="customer_country">
                                            <input type="hidden" name="customer_pincode" id="customer_pincode">
                                            @error('customer_address')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-buttons">
                                    <button type="submit" class="btn btn-primary">Register as Customer</button>
                                    <span>Already have an account? <a class="skill-link" href="{{ route('user.login') }}">Login</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="reserved terms">
                    <p><a href="{{ route('termsCondition') }}">Terms and Conditions</a></p>
                    <p>All Rights Reserved by {{ $model['name_of_website'] }}</p>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key={{ config('app.places_key') }}&libraries=places,geometry&callback=initialize&loading=async"></script>

    <script>
        let empAutocomplete;
        function initEmployeeAddress() {
            let input = document.getElementById('customer_address');
            if(!input || !window.google) return;
            if(empAutocomplete) google.maps.event.clearInstanceListeners(empAutocomplete);
            empAutocomplete = new google.maps.places.Autocomplete(input);
            empAutocomplete.addListener('place_changed', function() {
                let place = empAutocomplete.getPlace();
                if(place && place.geometry) {
                    $('#customer_latitude').val(place.geometry.location.lat());
                    $('#customer_longitude').val(place.geometry.location.lng());
                    place.address_components.forEach(c => {
                        if(c.types.includes('postal_code')) $('#customer_pincode').val(c.long_name);
                        if(c.types.includes('locality')) $('#customer_city').val(c.long_name);
                        if(c.types.includes('administrative_area_level_1')) $('#customer_state').val(c.long_name);
                        if(c.types.includes('country')) $('#customer_country').val(c.long_name);
                    });
                }
            });
        }

        window.initialize = function() {
            initEmployeeAddress();
            initHirerAddress();
        };
        if(window.google && google.maps) {
            initEmployeeAddress();
            initHirerAddress();
        }
    </script>
   
</body>
</html>