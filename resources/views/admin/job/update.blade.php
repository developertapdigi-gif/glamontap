@extends('admin.layouts.master')
@section('title')
  Update new Job
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2 class="desktop-content"><i class="jobs-black"></i>Update Post Job</h2>

        <h2 class="mobile-content"><i class="jobs-black"></i>Update Post Job</h2>
        <div class="right-title">
            <button class="primary-btn blue-button preview-post"><i class="fas fa-eye btn-eye"></i>Preview Post</button>
            <input type="hidden" id="preview_value" name="preview_value" value="0">
        </div>
    </div>
      <div class="skill-reg-form">
        <form id="createform" class="regular-form" action="{{ route('job.update',$model->id) }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="hidden" name="image" id="filenames" value="{{$model->image}}" />
                                    </div>
                    </div>
                </div>
                        
            <div class="row">
                @php  
                    $col = '';             
                    if(Auth::user()->user_type == '1'){
                        $col = 'col-4';
                    }else{
                        $col = 'col-6';
                    }                           
                @endphp
              <div class="{{$col}}">
                <label class="form-label">Title<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="title" name="title" class="form-control @error('title') is-invalid @enderror" type="text" value="{{ $model->title }}">
                </div>
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="{{$col}}">
                <label class="form-label">Skill Categories<span class="text-danger">*</span></label>
                <div class="input-group">
                    <select name="skill_category" id="skill_category" class="form-control form-select @error('skill_category') is-invalid @enderror" aria-label="skill_category">
                        <option value="">Select Skill Category</option>
                        @foreach ($categories as $_cat)
                            <option value="{{ $_cat['id']}}" @if($_cat['id'] == $model->skill_category || $_cat['id']==old('skill_category')) {{ 'selected' }} @endif>{{ $_cat['name'] }}</option>
                        @endforeach

                      </select>
                </div>
                @error('skill_category')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              
              <div class="{{$col}}">
              @hasrole('admin')
              <label class="form-label">Agency<span class="text-danger">*</span></label>
                <div class="input-group">
                    <select name="agency_id" class="form-control form-select @error('agency_id') is-invalid @enderror" aria-label="agency_id" id="agency_id">
                    @foreach ($agencies as $agency)
                            <option value="{{ $agency->id}}" @if($agency->id == $model->agency_id) {{ 'selected' }} @endif>{{ $agency->first_name }}</option>
                        @endforeach

                      </select>
                </div>
                    @else
                        <input type="hidden" id="agency_id" name="agency_id" value="{{$model->agency_id}}">
                    @endhasrole
                
                @error('agency_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            

            </div>
            <div class="col-4 d-none" id="other_skill">
                <label class="form-label">Other Skill</label>
                <div class="input-group">
                  <input id="other_skill" name="other_skill" class="form-control @error('other_skill') is-invalid @enderror" type="text" value="{{ old('other_skill') }}">
                </div>
                </div>
            <div class="row">
                <div class="col-4">
                    <label class="form-label">Experience Range<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select name="experiance_range" class="form-control form-select @error('experiance_range') is-invalid @enderror" aria-label="experiance_range" id="experiance_range">
                        <option value="">Select Experience Range</option>
                            @foreach ($experience_range as $key=>$experiance)
                                <option value="{{ $experiance->id }}" @if($experiance->id == $model->experiance_range) {{ 'selected' }} @endif>{{ $experiance->name }} ( {{$experiance->minimum_range}} to {{$experiance->maximum_range}} years)</option>
                            @endforeach

                          </select>
                    </div>
                    @error('experiance_range')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
              <div class="col-4">
                <label class="form-label">Number of Tradies<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="number_of_employees" name="number_of_employees" min="1" class="form-control @error('number_of_employees') is-invalid @enderror" type="number" value="{{ $model->number_of_employees }}">
                </div>
                @error('number_of_employees')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                    <label class="form-label">Status<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select name="status" class="form-control form-select @error('status') is-invalid @enderror" aria-label="status" id="status">                       
                        <option value="-1">Select Status</option>
                            @foreach ([0=>'Draft',1=>'Approval'] as $key=> $_status)
                                <option value="{{ $key }}" @if($key == $model->status) {{ 'selected' }} @endif>{{ $_status }}</option>
                            @endforeach
                          </select>
                    </div>
                    @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div>
                    <label class="form-label">Company Address<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="company_address" name="company_address" class="form-control @error('company_address') is-invalid @enderror" type="text" value="{{ $model->company_address }}">
                      <input type="hidden" id="company_latitude" name="company_latitude" value="{{ $model->company_latitude }}">
                      <input type="hidden" id="company_longitude" name="company_longitude" value="{{ $model->company_longitude }}">
                    </div>
                    @error('company_address')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
            </div>
            <div class="row">
                <div>
                    <label class="form-label">Location<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="location" name="location" class="form-control @error('location') is-invalid @enderror" type="text" value="{{ $model->location }}">
                      <input type="hidden" id="latitude" name="latitude" value="{{ $model->latitude }}">
                      <input type="hidden" id="longitude" name="longitude" value="{{ $model->longitude }}">
                    </div>
                    @error('location')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                  </div>
            </div>
            <div class="row">

                <div class="col-md-4">
                    <label for="date" class="col-form-label">Start Date<span class="text-danger">*</span></label>
                      <div class="input-group date" id="start_date_div">
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ Carbon\Carbon::parse($model->start_date)->format('Y-m-d') }}" {{count($model->applications)?'readonly':''}} />

                      </div>
                    </div>
                    <div class="col-md-4">
                         <label for="date" class="col-form-label">End Date<span class="text-danger">*</span></label>
                      <div class="input-group date" id="end_date_div">
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ Carbon\Carbon::parse($model->end_date)->format('Y-m-d') }}" min="{{date('Y-m-d')}}"/>

                      </div>
                    </div>
                    <div class="col-md-4">
                        <label for="payment" class="col-form-label">Payment Range<span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input id="minimum_price" name="minimum_price" min="0" class="form-control @error('minimum_price') is-invalid @enderror" type="number" value="{{ $model->minimum_price }}">
                                    
                                </div>
                                @error('minimum_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-1 from-border">-</div>
                            <div class="col-md-6">
                                <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input id="maximum_price" name="maximum_price" min="0" class="form-control @error('maximum_price') is-invalid @enderror" type="number" value="{{ $model->maximum_price }}">
                                   
                                </div>
                                @error('maximum_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
            </div>

            <div class="row">
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Additional Note</label>
                    <textarea class="form-control" id="note" name="note" rows="6\4" value="{{  $model->note }}">{{$model->note}}</textarea>
                </div>
            </div>
            
            <div class="mt-5">
                <button class="btn btn-primary" type="submit" id="post-job">Update Post Job</button>
                <a href="{{ route('job.index') }}" class="btn btn-primary black-button">Cancel</a>
                <a href="" class="btn btn-primary btn-secondary">Reset</a>
            </div>
          </form>
        </div>
    </div>
@endsection
@section('script')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet" />
{{-- ...Some more scripts... --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script src="{{asset('js/additional-methods.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key={{config('app.places_key')}}&libraries=places,geometry&callback=initialize&loading=async"></script>
<style>

</style>
<script type="text/javascript">

Dropzone.autoDiscover = false;  
var dropzone = new Dropzone('div#imgzone', {
    url: "{{ route('job.storeMedia') }}",
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
let mockFile = { name: "{{$model->image}}",size:100};
if(mockFile.name){
    $('#upload-label').css('visibility', 'hidden');
    dropzone.displayExistingFile(mockFile,"{{asset($model->image)}}");  
}
$('.dz-remove').on('click',function(){
    $('#upload-label').css('visibility', 'visible');
    $('#filenames').val('');
});
function initialize() {
    const companyinput = document.getElementById('company_address');
            const companyautocomplete = new google.maps.places.Autocomplete(companyinput);
            companyautocomplete.setComponentRestrictions({
            country: ["au","in"],
        });
        companyautocomplete.addListener('place_changed', function() {
        const companyplace = companyautocomplete.getPlace();
        $('#company_latitude').val(companyplace.geometry.location.lat());
        $('#company_longitude').val(companyplace.geometry.location.lng());
    });
        const input = document.getElementById('location');
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
$(function() {
    $( ".datepicker" ).datepicker({ dateFormat: "yyyy-mm-dd" });
});
$('.preview-post').click(function(){
    $('#preview_value').val('1');
    $('#createform').trigger("submit");
});
$('#post-job').click(function(){
    $('#preview_value').val('0');
    $('#createform').trigger("submit");
});
/********* Validation start from here ***********/
$.validator.addMethod("payment_range", 
    function(value, element) {
    	var min = parseFloat($('#minimum_price').val());	
    	var max = parseFloat($('#maximum_price').val());	
    	if(max > min){
    		return true;
    	}else{
        	return false;
        }
    }, 
    "Max range must be greater than minimum range."
);


$.validator.addMethod("greaterThan", function(value, element, params) {
var startDate = $(params).val();
if (!value || !startDate) {
    return true;
}
try {
    var endDateObj = new Date(value);
    var startDateObj = new Date(startDate);
    return endDateObj > startDateObj;
} catch (e) {    
    return false;
}
}, "End date must be greater than start date."); 
$.validator.addMethod("otherSkill", function(value,element, params){
        var select = document.getElementById("skill_category");
        var selectedIndex = select.selectedIndex;
        var options = select.options;
        var selectedValue = options[selectedIndex].value;
        if(selectedValue == '2800000'){
            if(value){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }, "Other Skill is required.");
$('#skill_category').on('change', function (e) {
  var optionSelected = $("option:selected", this);
  var valueSelected = this.value;
  if(valueSelected == 2800000){
    $('#other_skill').removeClass('d-none');
  }else{
    $('#other_skill').addClass('d-none');
  }
});
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
            agency_id:{
                required: true
            },
            company_address:{
                required:true
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
                required: true,
                greaterThan: "#start_date"
            },
            experiance_range:{
                required: true
            },
            number_of_employees:{
                required: true
            },
            minimum_price:{
                required:true
            },
            maximum_price:{
                required:true,
                payment_range : true
            },
            other_skill:{
                otherSkill : true
            }
        },
        submitHandler: function(form) {
            if($('#preview_value').val() == 1){
                var form = $("#createform");
                var formData = new FormData(form[0]);
                $.ajax({
                    method: "POST",
                    processData: false,
                    contentType: false,
                    url:form.attr('action'),
                    data: formData,
                    success: (response) =>{
                    $('.loader').hide();
                        if(response.status==200){
                            window.open(response.url, '_blank').focus();                        
                        }
                    },
                    error: (response) => {
                        
                    }
                });
            }else{
                form.submit();
            }
           
        }
    });

</script>
@endsection
