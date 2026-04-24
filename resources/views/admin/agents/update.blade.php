@extends('admin.layouts.master')
@section('title')
  Update Sub User
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
        <div class="page-title">
            <h2 class="desktop-content"><i class="traders-black"></i>Update Sub User</h2>
    
            <h2 class="mobile-content"><i class="traders-black"></i>Update Sub User</h2>
            <div class="right-title">
            <a href="{{ route('agent.index') }}">
              <button class="primary-btn blue-button"><i class="fas fa-eye btn-eye"></i>View All Sub Users</button>
</a>
            </div>
        </div>
      <div class="skill-reg-form">
          <form id="createform" class="regular-form" action="{{ route('agent.update',$model->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
                        <div class="row">  
            <div class="col-md-12">        
                            <label>Upload Picture</label>                         
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
              <div class="col-6">
                <label class="form-label">First Name<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" type="text" value="{{ old('first_name') ?? $model->first_name }}">
                </div>
                @error('first_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-6">
                <label class="form-label">Last Name<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" type="text" value="{{ old('last_name') ?? $model->last_name }}">
                </div>
                @error('last_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="row">
                <div>
                    <label class="form-label">Location<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="address" name="address" class="form-control @error('address') is-invalid @enderror" type="text" value="{{ $model->address }}">
                      <input type="hidden" id="latitude" name="latitude" value="{{ $model->latitude }}">
                      <input type="hidden" id="longitude" name="longitude" value="{{ $model->longitude }}">
                    </div>
                    @error('location')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
            </div>
            <div class="row mt-3">
              <div class="col-6">
                <label class="form-label">Email<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="email" name="email" class="form-control @error('email') is-invalid @enderror" type="email" value="{{ old('email') ?? $model->email }}">
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-6">
                <label class="form-label">Mobile</label>
                <div class="input-group">
                  <input id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" type="text" value="{{ old('mobile') ?? $model->mobile }}">
                </div>
                @error('mobile')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            
           
            <div class="row">
              <div class="mt-5">
              <button class="btn btn-primary" type="submit">Update Sub User</button>
                <a href="{{ route('agent.index') }}" class="btn btn-primary black-button">Cancel</a>
                <a href="" class="btn btn-secondary btn btn-primary">Reset</a>
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
            
        },

        submitHandler: function(form) {
           form.submit();
        }
    });
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key={{config('app.places_key')}}&libraries=places,geometry&callback=initialize&loading=async"></script>
<script type="text/javascript">
   Dropzone.autoDiscover = false;  
var dropzone = new Dropzone('div#imgzone', {
    url: "{{ route('agent.storeImage') }}",
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    addRemoveLinks:true,
    thumbnailWidth: 200,
    uploadMultiple: false,
    maxFiles: 1,
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