@extends('admin.layouts.master')
@section('title')
   My Profile
@endsection
@section('content')
<div class="container skill-reg-form pb-5">
  <div class="page-title">
     <div class="admin-profile"><i class="profile-black"></i><h2 class="profile-login">Profile</h2></div>
  </div>
  @if(Auth::user()->hasRole('agency') && empty($model->agency_name) )
   <div class="row">
      <div class="col-12">
        <div class="d-flex flex-column flex-sm-row bg-danger p-3 mb-3 text-white">
           <span class="svg-icon svg-icon-2hx svg-icon-danger me-4 mb-5 mb-sm-0">
             <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="#ffffff" d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4zM18 14H6v-2h12zm0-3H6V9h12zm0-3H6V6h12z"/></svg>
            </span>
            <div class="d-flex flex-column pe-0 pe-sm-10">
              <h4 class="fw-bold">Warning</h4>
              <span>{{ __('Your account is incomplete, Please fill out all required fields.') }}</span>
            </div>
        </div>
      </div>
  </div>
  @endif
  <div class="row  py-1">
    <div class="col-12 col-lg-10 m-auto">
      <form id="createform" class="regular-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
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
          
            <div class="row">  
                  <div class="col-md-12">        
                            <label>Upload Profile Picture</label>                         
                                    <div id="imgzone"  class="dropzone upload_dropZone" style="height:auto;border:0">
                                        <div id="upload-label">
                                <i class="bi bi-upload bold-upload" id="display-bold" onclick="$('.dropzone').get(0).dropzone.hiddenFileInput.click()"></i>
                            </div> </div>
                                    <div class="fallback">                            
                                        <input type="hidden" name="profile_picture" id="filenames" value="{{$model->profile_picture}}" />
                                    </div>
                  </div>
            </div>
          <div class="row">
              <div class="mt-5">
                <button class="btn btn-primary" type="submit">Update Profile</button>
              </div>
          </div>
        </form>
    </div>
  </div>
  <hr/>
  @hasrole('admin')
  @else
  @if(Auth::user()->user_type == 2)
  <div class="row py-1 mt-3">
    <div class="col-12 col-lg-10 m-auto">
      <form class="regular-form" action="{{ route('updateagency') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-6">
              <label class="form-label">Company Name</label>
              <div class="form-group">
                <input id="agency_name" name="agency_name" class="form-control @error('agency_name') is-invalid @enderror" type="text" value="{{ $model->agency_name }}">
              </div>
              @error('agency_name')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
        </div>
        <div class="row">
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">About Company</label>
                    <textarea class="form-control" id="about_agency" name="about_agency" rows="6\4" value="{{  $model->about_agency }}">{{$model->about_agency}}</textarea>
                </div>
            </div>
        <div class="row">
            <div>
                <label class="form-label">Company Address<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="address" name="address" class="form-control @error('address') is-invalid @enderror" type="text" value="{{ $model->address }}">
                  <input type="hidden" id="latitude" name="latitude" value="{{$model->latitude }}">
                  <input type="hidden" id="longitude" name="longitude" value="{{ $model->longitude }}">
                  <input type="hidden" id="street" name="street" value="{{ $model->street }}">
                  <input type="hidden" id="city" name="city" value="{{ $model->city }}">
                  <input type="hidden" id="pincode" name="pincode" value="{{ $model->pincode }}">
                  <input type="hidden" id="state" name="state" value="{{ $model->state }}">
                  <input type="hidden" id="country" name="country" value="{{ $model->country }}">
                </div>
                @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="facebook_url">Facebook Url</label>
            <input type="url" name="facebook_url" id="facebook_url" class="form-control" pattern="https://.*" size="30" value="{{ $model->facebook_url }}"/>
          </div>
          <div class="col-md-4">
            <label for="linkedin_url">Linkedin Url</label>
            <input type="url" name="linkedin_url" id="linkedin_url" class="form-control" pattern="https://.*" size="30" value="{{ $model->linkedin_url }}"/>
          </div>
          <div class="col-md-4">
          <label for="instagram_url">Instagram Url</label>
          <input type="url" name="instagram_url" id="instagram_url" class="form-control" pattern="https://.*" size="30" value="{{ $model->twitter_url }}"/>
          </div>
        </div>
       
        <div class="row">  
                    <div class="col-md-12">        
                            <label>Company Logo</label>                         
                                    <div id="logozone"  class="dropzone upload_dropZone dropzone_logo upload_dropZone_logo" style="height:auto;border:0">
                                        <div id="upload-label-logo">
                                <i class="bi bi-upload bold-upload-logo" id="display-bold-logo" onclick="$('.dropzone_logo').get(0).dropzone.hiddenFileInput.click()"></i>
                            </div> </div>
                                    <div class="fallback">                            
                                        <input type="hidden" name="logo" id="filenames_logo" value="{{$model->logo}}" />
                                    </div>
                    </div>
                </div>
        <div class="row">
              <div class="mt-5">
                <button class="btn btn-primary" type="submit">Update Company Details</button>
              </div>
          </div>
       
      </form>
    </div>
  </div>
  @endif
</hr>
  @endhasrole
  <div class="row  py-1 mt-3">
    <div class="col-12 col-lg-10 m-auto">
      <form class="regular-form" action="{{ route('changepassword') }}" method="POST">
        @csrf
        <input style="display: none;" type="password"  autocomplete="new-password" />
        <label class="form-label">Current password</label>
        <div class="form-group">
           <input class="form-control @error('current_password') is-invalid @enderror" name="current_password" type="password" placeholder="Current password">
        </div>
        @error('current_password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        
        <div class="form-group tooltip_text">
          <label class="form-label">New password</label>
          <div class="admin-profile-tooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="Password must be 8-20 characters and include at least one uppercase letter and one number. No spaces.">
            <!-- <span>Password must be 8-20 characters and include at least one uppercase letter and one number. No spaces.</span> -->
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M256 426.846c-94.205 0-170.845-76.641-170.845-170.846S161.795 85.154 256 85.154 426.845 161.795 426.845 256 350.205 426.846 256 426.846zm0-321.692c-83.176 0-150.845 67.669-150.845 150.846S172.824 406.846 256 406.846 406.845 339.177 406.845 256 339.176 105.154 256 105.154z" fill="#000000" opacity="1" data-original="#000000"></path><path d="M256.507 169.769a9.941 9.941 0 0 1-1.96-.191 10.1 10.1 0 0 1-1.87-.569 10.31 10.31 0 0 1-1.73-.92 10.684 10.684 0 0 1-1.52-1.24 10.048 10.048 0 0 1-1.24-1.521 10.666 10.666 0 0 1-.92-1.729 10.145 10.145 0 0 1-.57-1.87 9.66 9.66 0 0 1 0-3.911 10.145 10.145 0 0 1 .57-1.87 10.666 10.666 0 0 1 .92-1.729 9.977 9.977 0 0 1 16.63 0 10.666 10.666 0 0 1 .92 1.729 10.145 10.145 0 0 1 .57 1.87 9.66 9.66 0 0 1 0 3.911 10.145 10.145 0 0 1-.57 1.87 10.666 10.666 0 0 1-.92 1.729 10.048 10.048 0 0 1-1.24 1.521 10.042 10.042 0 0 1-3.25 2.16 10.1 10.1 0 0 1-1.87.569 9.915 9.915 0 0 1-1.95.191zM256.5 363.228a10 10 0 0 1-10-10v-138.4h-13.431a10 10 0 1 1 0-20H256.5a10 10 0 0 1 10 10v148.4a10 10 0 0 1-10 10z" fill="#000000" opacity="1" data-original="#000000"></path></g></svg>
          </div>
           <input class="form-control @error('new_password') is-invalid @enderror" name="new_password" type="password" placeholder="New password">
        </div>
        @error('new_password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="form-label">Confirm new password</label>
        <div class="form-group">
           <input class="form-control @error('new_confirm_password') is-invalid @enderror" name="new_confirm_password" type="password" placeholder="Confirm password">
        </div>
        @error('new_confirm_password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="row">
              <div class="mt-5">
                <button class="btn btn-primary" type="submit">Update password</button>
              </div>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet" />
{{-- ...Some more scripts... --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script type="text/javascript">
  Dropzone.autoDiscover = false;  
var dropzone = new Dropzone('div#imgzone', {
    url: "{{ route('user.storeMedia') }}",
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    addRemoveLinks:true,
    thumbnailWidth: 200,
    uploadMultiple: false,
    maxFiles: 1,
    clickable: true,
    //clickable: "#upload-label",
    dictDefaultMessage: "Drag & Drop or click to upload image",
    acceptedFiles: ".jpeg,.jpg,.png,.gif,.webp",
    success: function(file, response) {
        $('#filenames').val(response.name);            
        if($('#filenames').val(response.name)){
            $('#upload-label').css('visibility', 'hidden');
        }
    },     
    init: function() {
      this.on("maxfilesexceeded", function(file) {
            this.removeAllFiles();
            this.addFile(file);
            
      });
    }     
});
let mockFile = { name: "{{$model->profile_picture}}",size:100};
if(mockFile.name){
    $('#upload-label').css('visibility', 'hidden');
    dropzone.displayExistingFile(mockFile,"{{asset($model->profile_picture)}}");  
}
$('.dz-remove').on('click',function(){
    $('#upload-label').css('visibility', 'visible');
    $('#filenames').val('');
});

Dropzone.autoDiscover = false;  
var dropzonelogo = new Dropzone('div#logozone', {
    url: "{{ route('user.storeLogoMedia') }}",
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    addRemoveLinks:true,
    thumbnailWidth: 200,
    uploadMultiple: false,
    maxFiles: 1,
    clickable: true,
    //clickable: "#upload-label",
    dictDefaultMessage: "Drag & Drop or click to upload logo",
    acceptedFiles: ".jpeg,.jpg,.png,.gif,.webp",
    success: function(file, response) {
        $('#filenames_logo').val(response.name);            
        if($('#filenames_logo').val(response.name)){
            $('#upload-label-logo').css('visibility', 'hidden');
        }
    },     
    init: function() {
      this.on("maxfilesexceeded", function(file) {
            this.removeAllFiles();
            this.addFile(file);
            
      });
    }     
});
let mockFilelogo = { name: "{{$model->logo}}",size:100};
if(mockFilelogo.name){
  console.log(mockFilelogo);
    $('#upload-label-logo').css('visibility', 'hidden');
    dropzonelogo.displayExistingFile(mockFilelogo,"{{asset($model->logo)}}");  
}
$('.dz-remove').on('click',function(){
    $('#upload-label-logo').css('visibility', 'visible');
    $('#filenames_logo').val('');
});
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
            console.log(place);
            $('#latitude').val(place.geometry.location.lat());
            $('#longitude').val(place.geometry.location.lng());
            for (var i = 0; i < place.address_components.length; i++) {
              for (var j = 0; j < place.address_components[i].types.length; j++) {
                if (place.address_components[i].types[j] == "postal_code") { /* pincode */
                  $('#pincode').val(place.address_components[i].long_name);
                }else  if (place.address_components[i].types[j] == "route") {
                    $('#street').val(place.address_components[i].long_name);
                }else  if (place.address_components[i].types[j] == "locality") {
                    $('#city').val(place.address_components[i].long_name);
                }else if (place.address_components[i].types[j] == "administrative_area_level_1") {
                    $('#state').val(place.address_components[i].long_name);
                }else  if (place.address_components[i].types[j] == "country") {
                    $('#country').val(place.address_components[i].long_name);
                }
              }
            }
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script> 
        <!-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> -->
        <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        </script>
@endsection
