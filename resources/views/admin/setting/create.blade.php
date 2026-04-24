@extends('admin.layouts.master')
@section('title')
   Web Settings
@endsection
@section('content')

    <div class="container-fluid middle-content dashboard-content">
        <div class="page-title">
            <h2 class="desktop-content"><i class="setting-black"></i>Web Settings</h2>

            <h2 class="mobile-content"><i class="setting-black"></i>Web Settings</h2>
        </div>
      <div class="skill-reg-form">
        <form id="createform" class="regular-form" action="{{ route('setting.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row mt-3">
            <label for="site_logo">Website Logo</label>
             <div class="form-group">
                <input type="file" class="form-control @error('site_logo') is-invalid @enderror" name="site_logo" accept="image/*">
             </div>
         </div>
            <div class="row">
              <div class="col-4">
                <label class="form-label">Website Name<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="site_name" name="site_name" class="form-control @error('site_name') is-invalid @enderror" type="site_name" value="{{ old('site_name') }}">
                </div>
                @error('site_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              

              </div>
              <div class="row mt-3">
            <label for="site_logo">Website FavIcon</label>
             <div class="form-group">
                <input type="file" class="form-control @error('favicon') is-invalid @enderror" name="favicon" accept="image/*">
             </div>
         </div>
            <div class="row">
                <div class="col-12">
                <label class="form-label">Email<span class="text-danger">*</span></label>
                <div class="input-group">
                <input id="emails" name="emails" class="form-control @error('emails') is-invalid @enderror" type="email" value="{{ old('emails  ') }}" multiple>
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                </div>
            </div>
            <div class="row">
                <div>
                    <label class="form-label">Location<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="address" name="address" class="form-control @error('address') is-invalid @enderror" type="text" value="{{ old('address') }}">
                      <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                      <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                    </div>
                    @error('location')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
            </div>
            
            <div class="row">
              <div class="col-4">
                <label class="form-label">Facebook Link</label>
                <div class="input-group">
                  <input id="fb_link" name="fb_link" class="form-control @error('fb_link') is-invalid @enderror" type="fb_link" value="{{ old('twitter_link') }}">
                </div>
                @error('fb_link')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
              <label class="form-label">Instagram Link</label>
                <div class="input-group">
                  <input id="instagram_link" name="instagram_link" class="form-control @error('instagram_link') is-invalid @enderror" type="instagram_link" value="{{$model->instagram_link }}">
                </div>
                @error('instagram_link')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
              <label class="form-label">LinkedIn Link</label>
                <div class="input-group">
                  <input id="linkedIn_link" name="linkedIn_link" class="form-control @error('linkedIn_link') is-invalid @enderror" type="linkedIn_link" value="{{ old('instagram_link') }}">
                </div>
                @error('linkedIn_link')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>

              </div>

            
            <div class="mt-5">
                <button class="btn btn-primary" type="submit">Save Changes</button>
            </div>
          </form>
        </div>
    </div>

@endsection
@section('script')
<script src="{{asset('js/additional-methods.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key={{config('app.places_key')}}&libraries=places,geometry&callback=initialize&loading=async"></script>
<script type="text/javascript">
function initialize() {
        const input = document.getElementById('address');
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.setComponentRestrictions({
        country: ["au","in"],
    });
    autocomplete.addListener('place_changed', function() {
        const place = autocomplete.getPlace();
        $('#latitude').val(place.geometry.location.lat());
        $('#longitude').val(place.geometry.location.lng());
    });
}

</script>
@endsection
