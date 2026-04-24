@extends('admin.layouts.master')
@section('title')
  Add new Company
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
        <div class="page-title"> 
            <h2 class="desktop-content"><i class="agency-black"></i>Add New Company</h2>
    
            <h2 class="mobile-content"><i class="agency-black"></i>Add New Company</h2>
            <div class="right-title">
            <a href="{{ route('agency.index') }}">
              <button class="primary-btn blue-button"><i class="fas fa-eye btn-eye"></i>View All Companies</button>
</a>
            </div>
        </div>
      <div class="skill-reg-form">
        <form id="createform" class="regular-form" action="{{ route('agency.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
                            <div class="col-md-12">
                                <label for="upload" class="form-label">Upload Picture</label>
                                <fieldset class="upload_dropZone text-center mb-3 p-4">

                                    <legend class="visually-hidden">Image uploader</legend>

                                    <i class="bi bi-upload bold-upload"></i>

                                    
                                    <input id="upload_image_background" type="file" class="form-control @error('profile_picture') is-invalid @enderror position-absolute invisible " name="profile_picture" accept="image/*">

                                    <label class="btn btn-upload mb-3" for="upload_image_background">Drag &amp; Drop or click to upload image
                                        </label>

                                    <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                    </div>

                                </fieldset>
                            </div>
                        </div>
              
            <div class="row mt-3">
                <div class="col-6">
                  <label class="form-label">First Name1<span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" type="text" value="{{ old('first_name') }}">
                  </div>
                  @error('first_name')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-6">
                  <label class="form-label">Last Name<span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" type="text" value="{{ old('last_name') }}">
                  </div>
                  @error('last_name')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
            </div>
              <div class="row">
            
                <label class="form-label">Location<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="address" name="address" class="form-control @error('address') is-invalid @enderror" type="text" value="{{ old('address') }}">
                  <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                  <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                </div>
                @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              
          </div>
            <div class="row mt-3">
              <div class="col-4">
                <label class="form-label">Email<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="email" name="email" class="form-control @error('email') is-invalid @enderror" type="email" value="{{ old('email') }}">
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <label class="form-label">Mobile<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" type="text" value="{{ old('mobile') }}">
                </div>
                @error('mobile')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <label class="form-label">Status<span class="text-danger"></span></label>
                <div class="input-group">

                    <select name="status" class="form-control form-select" aria-label="Default select example">
                        <!--option value="0">Select Status</option-->
                        @foreach ($status as $key =>$statusname)
                            <option value="{{ $key}}" {{ (old('status'))?'selected':''}}>{{ $statusname }}</option>
                        @endforeach

                      </select>
                </div>
                @error('status')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row">
            <div class="mt-5">
              <button class="btn btn-primary" type="submit">Add New Company</button>
                <a href="{{ route('agency.index') }}" class="btn btn-primary black-button">Cancel</a>
                <a href="" class="btn btn-secondary btn-primary">Reset</a>
              </div>
            </div>
            <!-- <button class="btn bg-gradient-dark btn-sm float-end mt-6 mb-0" type="submit">Save</button> -->
          </form>
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
