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
    <title>{{$model['name_of_website']}} - Tradie Register</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <main role="main" class="container-fluid full-height">
        <div class="row full-height">
            <div class="col-lg-6 col-12 ps-0 pe-0">
                <div class="left-login-section">
                    <a href="{{ url('/') }}" class="d-flex justify-content-center mb-3">
                        <img src="{{ $model['website_logo'] }}" class="login-logo d-md-block d-lg-none" />
                    </a>
                    <div class="left-login-top-text">
                        <h1>Join as a Tradie</h1>
                        <p>Find jobs that match your skills and experience</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 relative-box white-background">
                @include('flash-message')
                <div class="right-login-section register-right-section">
                    <a href="{{ url('/') }}">
                        <img src="{{ $model['website_logo'] }}" class="login-logo d-none d-lg-block" />
                    </a>
                    <div class="login-user-details">
                        <h4>Tradie Register</h4>
                        <form role="form" action="{{ route('user.tradie.registerpost') }}" method="POST" class="login-form" id="tradieform">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group form-login-group mb-3">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                                        @error('first_name')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group form-login-group mb-3">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                                        @error('last_name')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group form-login-group mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                        @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group form-login-group mb-3">
                                        <label>Phone</label>
                                        <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                                        @error('mobile')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group form-login-group mb-3">
                                        <label>Address</label>
                                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                                        <input type="hidden" name="latitude" id="latitude">
                                        <input type="hidden" name="longitude" id="longitude">
                                        <input type="hidden" name="city" id="city">
                                        <input type="hidden" name="state" id="state">
                                        <input type="hidden" name="country" id="country">
                                        <input type="hidden" name="pincode" id="pincode">
                                        @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group form-login-group mb-3">
                                        <label>Skill Category</label>
                                        <select name="skill_category_id" class="form-control form-select">
                                            <option value="">Select Skill</option>
                                            @foreach($skills as $skill)
                                            <option value="{{ $skill->id }}" {{ old('skill_category_id') == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('skill_category_id')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group form-login-group mb-3">
                                        <label>ABN</label>
                                        <input type="text" name="abn_acn" class="form-control" value="{{ old('abn_acn') }}">
                                        @error('abn_acn')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group form-login-group mb-3">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control">
                                        @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group form-login-group mb-3">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-buttons">
                                <button type="submit" class="btn btn-primary btn-right-margin">Register</button>
                                <span>Already have an account? <a class="skill-link" href="{{ route('user.login') }}">Login</a></span>
                            </div>
                        </form>
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
    function initialize() {
        const input = document.getElementById('address');
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            $('#latitude').val(place.geometry.location.lat());
            $('#longitude').val(place.geometry.location.lng());
            place.address_components.forEach(c => {
                if(c.types.includes('postal_code')) $('#pincode').val(c.long_name);
                if(c.types.includes('locality')) $('#city').val(c.long_name);
                if(c.types.includes('administrative_area_level_1')) $('#state').val(c.long_name);
                if(c.types.includes('country')) $('#country').val(c.long_name);
            });
        });
    }
    $('#tradieform').validate({
        rules: {
            first_name: { required: true },
            last_name: { required: true },
            email: { required: true, email: true },
            mobile: { required: true },
            address: { required: true },
            skill_category_id: { required: true },
            password: { required: true, minlength: 8 },
            password_confirmation: { required: true, equalTo: '[name=password]' },
        }
    });
    </script>
</body>
</html>
