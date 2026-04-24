@extends('frontend.layouts.master')
@section('title')
  Add new Job
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2 class="desktop-content"><i class="newjob-black"></i>Post New Job</h2>

        <h2 class="mobile-content"><i class="newjob-black"></i>Post New Job</h2>
        <div class="right-title">
            <button class="primary-btn blue-button"><i class="fas fa-eye btn-eye"></i>Preview Post</button>

        </div>
    </div>
      <div class="skill-reg-form">
        <form id="createform" class="regular-form" action="{{ route('job.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row mt-3">
            <label for="image">Upload Picture</label>
             <div class="form-group">
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
             </div>
         </div>
            <div class="row">
              <div class="col-4">
                <label class="form-label">Title<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="title" name="title" class="form-control @error('title') is-invalid @enderror" type="text" value="{{ old('title') }}">
                </div>
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <label class="form-label">Skill Categories<span class="text-danger">*</span></label>
                <div class="input-group">
                    <select name="skill_category" id="skill_category" class="form-control form-select @error('skill_category') is-invalid @enderror" aria-label="skill_category">
                        <option value="">Select Skill Category</option>
                        @foreach ($categories as $_cat)
                            <option value="{{ $_cat->id}}" @if($_cat->id == old('skill_category')) {{ 'selected' }} @endif>{{ $_cat->name }}</option>
                        @endforeach

                      </select>
                </div>
                @error('skill_category')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <label class="form-label">Experience Range<span class="text-danger">*</span></label>
                <div class="input-group">
                    <select name="experiance_range" class="form-control form-select @error('experiance_range') is-invalid @enderror" aria-label="agency_id" id="agency_id">
                        @foreach ($experience_range as $key=>$experiance)
                            <option value="{{ $key }}" @if($key == old('experiance_range')) {{ 'selected' }} @endif>{{ $experiance }}</option>
                        @endforeach

                      </select>
                </div>
                @error('experiance_range')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
            <div class="row">

              <div class="col-6">
                <label class="form-label">Number of Employees<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="number_of_employees" name="number_of_employees" class="form-control @error('number_of_employees') is-invalid @enderror" type="number" value="{{ old('number_of_employees') }}">
                </div>
                @error('number_of_employees')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>

            </div>
            <div class="row">
                <div>
                    <label class="form-label">Location<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="location" name="location" class="form-control @error('location') is-invalid @enderror" type="text" value="{{ old('location') }}">
                      <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                      <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                    </div>
                    @error('location')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
            </div>
            <div class="row">

                <div class="col-md-4">
                    <label for="date" class="col-form-label">Start Date</label>
                      <div class="input-group date" id="start_date_div">
                        <input type="date" class="form-control " id="start_date" name="start_date" placeholder=''/>

                      </div>
                    </div>
                    <div class="col-md-4">
                         <label for="date" class="col-form-label">End Date</label>
                      <div class="input-group date" id="end_date_div">
                        <input type="date" class="form-control" id="end_date" name="end_date" />

                      </div>
                    </div>
                    <div class="col-md-4">
                        <label for="payment" class="form-label">Payment Range</label>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input id="minimum_price" name="minimum_price" class="form-control @error('minimum_price') is-invalid @enderror" type="number" value="{{ old('minimum_price') }}">
                                    <span class="input-group-text">$</span>
                                </div>
                            </div>
                            <div class="col-md-1 from-border">-</div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="maximum_price" name="maximum_price" class="form-control @error('maximum_price') is-invalid @enderror" type="number" value="{{ old('maximum_price') }}">
                                    <span class="input-group-text">$</span>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="exampleFormControlTextarea1" class="form-label">Additional Note</label>
                    <textarea class="form-control" id="note" name="note" rows="6\4"></textarea>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn btn-primary" type="submit">Post New Job</button>
                <a href="{{ route('supanel.job.index') }}" class="btn btn-primary black-button">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/additional-methods.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCrmh8yLjd1qXmwHaN-v9UKNoZ3mtRB6W8&libraries=places,geometry&callback=initialize&loading=async"></script>
<script type="text/javascript">
function initialize() {
        const input = document.getElementById('location');
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
$(function() {
    $( ".datepicker" ).datepicker({ dateFormat: "yyyy-mm-dd" });
});
/********* Validation start from here ***********/
 var createform = $('#createform');
    createform.validate({
        ignore: [],
        rules: {
            title: {
                required: true,
                minlength: 3
            },
            skill_category:{
                required: true
            },
            latitude:{
                required: false
            },
            longitude:{
                required: false
            },
            location:{
                required: true
            },
            start_date:{
                required: true
            },
            end_date:{
                required: true
            },
            experiance_range:{
                required: true
            },
            number_of_employees:{
                required: true
            }
        },
        submitHandler: function(form) {
           form.submit();
        }
    });
</script>
@endsection
