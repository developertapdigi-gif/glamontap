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
    <title>{{$model['name_of_website']}} - Verify OTP</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <main role="main" class="container-fluid full-height">
        <div class="row full-height justify-content-center align-items-center">
            <div class="col-md-5 white-background p-5">
                @include('flash-message')
                <a href="{{ url('/') }}">
                    <img src="{{ $model['website_logo'] }}" class="login-logo mb-4" />
                </a>
                <h4>Verify Your Email</h4>
                <p class="text-muted">An OTP has been sent to <b>{{ $email }}</b></p>
                <form action="{{ route('user.tradie.verifypost') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="form-group mb-3">
                        <label>Enter OTP</label>
                        <input type="text" name="otp" class="form-control" placeholder="Enter 5-digit OTP" required>
                        @error('otp')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
                </form>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
    $(document).ready(function(){
        setTimeout(function() { $(".alert").alert('close'); }, 5000);
    });
    </script>
</body>
</html>
