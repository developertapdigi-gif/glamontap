@extends('frontend.layouts.master')
@section('title')
   My Profile
@endsection
@section('content')
<div class="container-fluid">
  <div class="page-title">
     <h2 class="mobile-hide"><i class="home-black"></i>Profile</h2>
  </div>
  <div class="row bg-light py-5">
    <div class="col-lg-8 mx-auto">
      <form id="createform" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
          <div class="row">
            <div class="col-6">
              <label class="form-label">First Name</label>
              <div class="form-group">
                <input id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" type="text" value="{{ $model->first_name }}">
              </div>
              @error('first_name')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-6">
              <label class="form-label">Last Name</label>
              <div class="form-group">
                <input id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" type="text" value="{{ $model->last_name }}">
              </div>
              @error('last_name')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <label class="form-label">Email</label>
              <div class="form-group">
                <input id="email" name="email" class="form-control @error('email') is-invalid @enderror" type="email" value="{{ $model->email }}">
              </div>
              @error('email')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-6">
              <label class="form-label">Mobile</label>
              <div class="form-group">
                <input id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" type="text" value="{{ $model->mobile }}">
              </div>
              @error('mobile')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row mt-3">
             <label for="profile_picture">Profile Picture</label>
              <div class="form-group">
                 <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" name="profile_picture" accept="image/*">
              </div>
          </div>
          <div class="submit-buttons">
            <button type="submit" class="btn btn-primary btn-right-margin">Update Profile</button>
         </div>
        </form>
    </div>
  </div>

  <div class="row bg-light py-5 mt-3">
    <div class="col-lg-8 mx-auto">
      <form action="{{ route('updateagency') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-6">
              <label class="form-label">Agency Name</label>
              <div class="form-group">
                <input id="agency_name" name="agency_name" class="form-control @error('agency_name') is-invalid @enderror" type="text" value="{{ $model->agency_name }}">
              </div>
              @error('agency_name')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
        </div>
        <div class="row">
            <div>
                <label class="form-label">Location<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="address" name="address" class="form-control @error('address') is-invalid @enderror" type="text" value="{{ $model->location }}">
                  <input type="hidden" id="latitude" name="latitude" value="{{$model->latitude }}">
                  <input type="hidden" id="longitude" name="longitude" value="{{ $model->longitude }}">
                </div>
                @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
        </div>
        <div class="row">
            <div class="col-8">
                <label for="logo">Agency Logo</label>
                 <div class="form-group">
                    <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" accept="image/*">
                 </div>
             </div>
        </div>

        <div class="submit-buttons">
            <button type="submit" class="btn btn-primary btn-right-margin">Update Agency Details</button>
         </div>
      </form>
    </div>
  </div>

  <div class="row bg-light py-5 mt-3">
    <div class="col-lg-8 mx-auto">
      <form action="{{ route('changepassword') }}" method="POST">
        @csrf
        <input style="display: none;" type="password"  autocomplete="new-password" />
        <label class="form-label">Current password</label>
        <div class="form-group">
           <input class="form-control @error('current_password') is-invalid @enderror" name="current_password" type="password">
        </div>
        @error('current_password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="form-label">New password</label>
        <div class="form-group">
           <input class="form-control @error('new_password') is-invalid @enderror" name="new_password" type="password">
        </div>
        @error('new_password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="form-label">Confirm new password</label>
        <div class="form-group">
           <input class="form-control @error('new_confirm_password') is-invalid @enderror" name="new_confirm_password" type="password">
        </div>
        @error('new_confirm_password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="submit-buttons">
            <button type="submit" class="btn btn-primary btn-right-margin">Update password</button>
         </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    var createform = $('#createform');
    createform.validate({
        ignore: [],
        rules: {
            first_name: {
                required: true,
                minlength: 3,
            },
            last_name:{
                required: true
            },
            email:{
                required: true
            },
            mobile:{
                required: true
            },
        },

        submitHandler: function(form) {
           form.submit();
        }
    });
</script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCrmh8yLjd1qXmwHaN-v9UKNoZ3mtRB6W8&libraries=places,geometry&callback=initialize&loading=async"></script>
<script type="text/javascript">
    function initialize() {
            const input = document.getElementById('address');
            const autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.setComponentRestrictions({
            country: ["in","ae"],
        });
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            $('#latitude').val(place.geometry.location.lat());
            $('#longitude').val(place.geometry.location.lng());
        });
    }
</script>
@endsection
