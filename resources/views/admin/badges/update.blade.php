@extends('admin.layouts.master')
@section('title')
  Update Badge
@endsection
@section('content')

<div class="container-fluid middle-content dashboard-content">
        <div class="page-title">
            <h2 class="desktop-content"><i class="badge-black"></i>Update Badge</h2>
    
            <h2 class="mobile-content"><i class="badge-black"></i>Add Badge</h2>
            <div class="right-title">
            <a href="{{ route('badges.index') }}">
              <button class="primary-btn blue-button"><i class="fas fa-eye btn-eye"></i>View All Badges</button>
</a>
            </div>
        </div>
      <div class="skill-reg-form">
          <form id="createform" class="regular-form" action="{{ route('badges.update',$model->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
            <div class="row">
              <div class="col">
                <label class="form-label">First Name<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" type="text" value="{{ old('name') ?? $model->name }}">
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>

              <div class="row ">
              <div class="col-6">
                <label class="form-label">Experience Range<span class="text-danger">*</span></label>
                <div class="row">
                  <div class="col-6">
                  <input id="minimum_range" name="minimum_range" min="0" class="form-control @error('minimum_range') is-invalid @enderror" type="number" value="{{ old('minimum_range') ?? $model->minimum_range }}">
                  @error('minimum_range')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror  
                </div>
                  <div class="col-6">                   
                  <input id="maximum_range" name="maximum_range" min="0" class="form-control @error('maximum_range') is-invalid @enderror" type="number" value="{{ old('maximum_range') ?? $model->maximum_range}}">
                  @error('maximum_range')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror  
                </div> 
                </div>                
              </div>

              <div class="col-6">
                <label class="form-label">Status<span class="text-danger">*</span></label>
                <div class="input-group">

                    <select name="status" class="form-control form-select" aria-label="Default select example" {{($model->JobBadge)?'disabled':''}}>
                        <option value="0">Select Status</option>
                        @foreach ($status as $key=>$statusvalue)
                            <option value="{{ $key }}" {{ ($key == $model->status)?'selected':''}}>{{ $statusvalue }}</option>
                        @endforeach

                      </select>
                      @php 
                      if($model->JobBadge){
                        @endphp
                        <input type="hidden" name="status" value="{{$model->status}}" />
                      @php   
                      }
                      @endphp
                </div>
                @error('status')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                    <label class="form-label">Class Name<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select name="class_name" class="form-select form-select-lg @error('class_name') is-invalid @enderror">
                            <option value="">Select Class Name</option>
                            @foreach ($classnames as $key =>$classname)
                                <option value="{{ $key}}" @if($key==$model->class_name || $key==old('class_name')) selected @endif>{{ $classname }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('class_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
              <div class="mt-5">
              <button class="btn btn-primary" type="submit">Update Badge</button>
                <a href="{{ route('badges.index') }}" class="btn btn-primary black-button">Cancel</a>
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
            name: {
                required: true,
                minlength: 3,
            },

        },

        submitHandler: function(form) {
           form.submit();
        }
    });
</script>
@endsection
