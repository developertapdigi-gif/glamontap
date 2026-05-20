@extends('admin.layouts.master')
@section('title')
  Update Skill Category
@endsection
@section('content')

<div class="container-fluid middle-content dashboard-content">
        <div class="page-title">
            <h2 class="desktop-content"><i class="skill-black"></i>Update Skill Category</h2>
    
            <h2 class="mobile-content"><i class="skill-black"></i>Add Skill Category</h2>
            <div class="right-title">
            <a href="{{ route('skill-categories.index') }}">
              <button class="primary-btn blue-button"><i class="fas fa-eye btn-eye"></i>View All Skill Categories</button>
</a>
            </div>
        </div>
      <div class="skill-reg-form">
          <form id="createform" class="regular-form" action="{{ route('skill-categories.update',$model->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
            <div class="row">
              <div class="col">
                <label class="form-label">Name<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" type="text" value="{{ old('name') ?? $model->name }}">
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col">
                <label class="form-label">Image</label>
                <div class="input-group">
                  <input id="image" name="image" class="form-control @error('image') is-invalid @enderror" type="file" accept="image/*">
                </div>
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                @if(!empty($model->image) && file_exists(public_path($model->image)))
                <div class="mt-2">
                    <img id="current-image" src="{{ asset($model->image) }}" alt="{{ $model->name }}" class="img-thumbnail" style="max-height:150px;">
                </div>
                @else
                <div class="mt-2">
                    <img id="current-image" src="{{ asset('/images/icons/brand-logo1.png') }}" alt="No image" class="img-thumbnail" style="max-height:150px;">
                </div>
                @endif
              </div>
            </div>

            <div class="row">
              <div class="col">
                <label class="form-label">Status<span class="text-danger">*</span></label>
                <div class="input-group">

                    <select name="status" class="form-select" aria-label="Default select example" {{($model->JobSkillCategory)?'disabled':''}}>
                        <option value="0">Select Status</option>
                        @foreach ($status as $key=>$statusvalue)
                            <option value="{{ $key }}" {{ ($key == $model->status)?'selected':''}}>{{ $statusvalue }}</option>
                        @endforeach

                      </select>
                </div>
                @error('company_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="mt-5">
              <button class="btn btn-primary" type="submit">Update Skill Category</button>
                <a href="{{ route('skill-categories.index') }}" class="btn btn-primary black-button">Cancel</a>
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
            image: {
                required: false,
            },
        },

        submitHandler: function(form) {
           form.submit();
        }
    });

      // preview selected image
      $('#image').on('change', function(e){
        var input = this;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e){
            $('#current-image').attr('src', e.target.result);
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
</script>
@endsection
