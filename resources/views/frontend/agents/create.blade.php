@extends('frontend.layouts.master')
@section('title')
  Add new Agent
@endsection
@section('content')
<div class="row mx-3">
  <div class="col-lg-12 mt-lg-0 mt-4">
    <div class="card mt-4">
     <div class="card-header">
        <h5>Agent Information</h5>
      </div>
      <div class="card-body pt-0">
        <form id="createform" action="{{ route('agent.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="row">
              <div class="col-6">
                <label class="form-label">First Name<span class="text-danger">*</span></label>
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
            <div class="row mt-3">
              <div class="col-6">
                <label class="form-label">Email<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="email" name="email" class="form-control @error('email') is-invalid @enderror" type="email" value="{{ old('email') }}">
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-6">
                <label class="form-label">Mobile<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" type="text" value="{{ old('mobile') }}">
                </div>
                @error('mobile')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <button class="btn bg-gradient-dark btn-sm float-end mt-6 mb-0" type="submit">Save</button>
          </form>
        </div>
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
@endsection
