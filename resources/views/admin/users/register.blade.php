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
    <title>{{ $model['name_of_website'] }} - Apply as Employee or Hirer</title>
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
                        <img src="{{ asset('images/glam-logo.svg') }}" class="login-logo d-sm-block d-md-none mb-3" width="80"/>
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
                        <div class="apply-toggle">
                            <div class="toggle-buttons">
                                <button type="button" class="toggle-btn active" id="employeeToggle"> <i class="fas fa-tools"></i> Join as  Professionals</button>
                                <button type="button" class="toggle-btn" id="hirerToggle">  <i class="fas fa-building"></i> Join as Company</button>
                            </div>
                        </div>
                         <h3 class="dynamic-heading" id="formHeading">Professional Register</h3>

                        <!-- TRADIE REGISTRATION FORM -->
                        <div id="employeeForm" class="form-card">
                            <form role="form" action="{{ route('user.tradie.registerpost') }}" method="POST" class="login-form" id="employeeFormValidate">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>First Name *</label>
                                            <input type="text" name="tradie_first_name" class="form-control" value="{{ old('tradie_first_name') }}">
                                            @error('tradie_first_name')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Last Name *</label>
                                            <input type="text" name="tradie_last_name" class="form-control" value="{{ old('tradie_last_name') }}">
                                            @error('tradie_last_name')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Email *</label>
                                            <input type="email" name="tradie_email" class="form-control" value="{{ old('tradie_email') }}">
                                            @error('tradie_email')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Phone *</label>
                                            <input type="text" name="tradie_mobile" class="form-control" value="{{ old('tradie_mobile') }}">
                                            @error('tradie_mobile')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Address *</label>
                                            <input type="text" name="tradie_address" id="employee_address" class="form-control" value="{{ old('tradie_address') }}" placeholder="Enter a location">
                                            <input type="hidden" name="tradie_latitude" id="employee_latitude">
                                            <input type="hidden" name="tradie_longitude" id="employee_longitude">
                                            <input type="hidden" name="tradie_city" id="employee_city">
                                            <input type="hidden" name="tradie_state" id="employee_state">
                                            <input type="hidden" name="tradie_country" id="employee_country">
                                            <input type="hidden" name="tradie_pincode" id="employee_pincode">
                                            @error('tradie_address')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Skill Category *</label>
                                            <select name="tradie_skill_category_id" class="form-control form-select">
                                                <option value="">Select Skill</option>
                                                @foreach($skills as $skill)
                                                <option value="{{ $skill->id }}" {{ old('tradie_skill_category_id') == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('tradie_skill_category_id')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-buttons">
                                    <button type="submit" class="btn btn-primary">Register as Tradie</button>
                                    <span>Already have an account? <a class="skill-link" href="{{ route('user.login') }}">Login</a></span>
                                </div>
                            </form>
                        </div>

                        <!-- COMPANY REGISTRATION FORM -->
                        <div id="hirerForm" class="form-card" style="display: none;">
                            <form role="form" action="{{ route('user.registerpost') }}" method="POST" class="login-form" id="hirerFormValidate">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>First Name *</label>
                                            <input type="text" name="company_first_name" class="form-control" value="{{ old('company_first_name') }}">
                                            @error('company_first_name')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Last Name *</label>
                                            <input type="text" name="company_last_name" class="form-control" value="{{ old('company_last_name') }}">
                                            @error('company_last_name')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Email *</label>
                                            <input type="email" name="company_email" class="form-control" value="{{ old('company_email') }}">
                                            @error('company_email')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Phone *</label>
                                            <input type="text" name="company_mobile" class="form-control" value="{{ old('company_mobile') }}">
                                            @error('company_mobile')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-login-group mb-3">
                                            <label>Address *</label>
                                            <input type="text" name="company_address" id="hirer_address" class="form-control" value="{{ old('company_address') }}" placeholder="Enter a location">
                                            <input type="hidden" id="hirer_latitude" name="company_latitude" value="{{ old('company_latitude') }}">
                                            <input type="hidden" id="hirer_longitude" name="company_longitude" value="{{ old('company_longitude') }}">
                                            <input type="hidden" id="hirer_street" name="company_street" value="{{ old('company_street') }}">
                                            <input type="hidden" id="hirer_city" name="company_city" value="{{ old('company_city') }}">
                                            <input type="hidden" id="hirer_pincode" name="company_pincode" value="{{ old('company_pincode') }}">
                                            <input type="hidden" id="hirer_state" name="company_state" value="{{ old('company_state') }}">
                                            <input type="hidden" id="hirer_country" name="company_country" value="{{ old('company_country') }}">
                                            @error('company_address')<div class="text-danger small">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-buttons">
                                    <button type="submit" class="btn btn-primary">Register as Company</button>
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
        $(document).ready(function() {
            // Toggle between Tradie and Company
            const empToggle = $('#employeeToggle');
            const hirerToggle = $('#hirerToggle');
            const empForm = $('#employeeForm');
            const hirerForm = $('#hirerForm');
            const formHeading = $('#formHeading');

            function showTradie() {
                empToggle.addClass('active');
                hirerToggle.removeClass('active');
                empForm.show();
                hirerForm.hide();
                formHeading.text('Tradie Register');
                setTimeout(() => { if(window.google) initEmployeeAddress(); }, 100);
            }

            function showCompany() {
                hirerToggle.addClass('active');
                empToggle.removeClass('active');
                hirerForm.show();
                empForm.hide();
                formHeading.text('Company Register');
                setTimeout(() => { if(window.google) initHirerAddress(); }, 100);
            }

            empToggle.on('click', showTradie);
            hirerToggle.on('click', showCompany);

            // Auto-open correct tab if validation errors exist
            @if($errors->any())
                @php
                    $tradieFields = ['tradie_first_name', 'tradie_last_name', 'tradie_email', 'tradie_mobile', 'tradie_address', 'tradie_skill_category_id'];
                    $companyFields = ['company_first_name', 'company_last_name', 'company_email', 'company_mobile', 'company_address'];
                    $isTradieError = false;
                    $isCompanyError = false;
                    foreach($tradieFields as $f) if($errors->has($f)) { $isTradieError = true; break; }
                    foreach($companyFields as $f) if($errors->has($f)) { $isCompanyError = true; break; }
                @endphp
                @if($isTradieError)
                    showTradie();
                @elseif($isCompanyError)
                    showCompany();
                @endif
            @endif

            // Google Places for Tradie
            let empAutocomplete;
            function initEmployeeAddress() {
                let input = document.getElementById('employee_address');
                if(!input || !window.google) return;
                if(empAutocomplete) google.maps.event.clearInstanceListeners(empAutocomplete);
                empAutocomplete = new google.maps.places.Autocomplete(input);
                empAutocomplete.addListener('place_changed', function() {
                    let place = empAutocomplete.getPlace();
                    if(place && place.geometry) {
                        $('#employee_latitude').val(place.geometry.location.lat());
                        $('#employee_longitude').val(place.geometry.location.lng());
                        place.address_components.forEach(c => {
                            if(c.types.includes('postal_code')) $('#employee_pincode').val(c.long_name);
                            if(c.types.includes('locality')) $('#employee_city').val(c.long_name);
                            if(c.types.includes('administrative_area_level_1')) $('#employee_state').val(c.long_name);
                            if(c.types.includes('country')) $('#employee_country').val(c.long_name);
                        });
                    }
                });
            }

            // Google Places for Company
            let hirerAutocomplete;
            function initHirerAddress() {
                let input = document.getElementById('hirer_address');
                if(!input || !window.google) return;
                if(hirerAutocomplete) google.maps.event.clearInstanceListeners(hirerAutocomplete);
                hirerAutocomplete = new google.maps.places.Autocomplete(input);
                hirerAutocomplete.setComponentRestrictions({ country: ["au","in"] });
                hirerAutocomplete.addListener('place_changed', function() {
                    let place = hirerAutocomplete.getPlace();
                    if(place && place.geometry) {
                        $('#hirer_latitude').val(place.geometry.location.lat());
                        $('#hirer_longitude').val(place.geometry.location.lng());
                        for(let comp of place.address_components) {
                            if(comp.types.includes('postal_code')) $('#hirer_pincode').val(comp.long_name);
                            if(comp.types.includes('route')) $('#hirer_street').val(comp.long_name);
                            if(comp.types.includes('locality')) $('#hirer_city').val(comp.long_name);
                            if(comp.types.includes('administrative_area_level_1')) $('#hirer_state').val(comp.long_name);
                            if(comp.types.includes('country')) $('#hirer_country').val(comp.long_name);
                        }
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

            // Validation for Tradie form
            $('#employeeFormValidate').validate({
                rules: {
                    tradie_first_name: { required: true },
                    tradie_last_name: { required: true },
                    tradie_email: { required: true, email: true },
                    tradie_mobile: { required: true },
                    tradie_address: { required: true },
                    tradie_skill_category_id: { required: true },
                },
                messages: {
                    tradie_skill_category_id: "Please select a skill category"
                },
                errorElement: 'div',
                errorPlacement: function(error, element) { error.addClass('text-danger small').insertAfter(element); }
            });

            // Validation for Company form
            $('#hirerFormValidate').validate({
                rules: {
                    company_first_name: { required: true },
                    company_last_name: { required: true },
                    company_email: { required: true, email: true },
                    company_mobile: { required: true },
                    company_address: { required: true },
                },
                errorElement: 'div',
                errorPlacement: function(error, element) { error.addClass('text-danger small').insertAfter(element); }
            });
        });
    </script>
</body>
</html>