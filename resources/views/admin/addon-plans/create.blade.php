@extends('admin.layouts.master')
@section('title')
  Add New Add-on
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2 class="desktop-content"><i class="subscription-black"></i>Add Add-on</h2>    
        <h2 class="mobile-content"><i class="subscription-black"></i>Add Add-on</h2>
        <div class="right-title">             
            <a href="{{ route('addon-plans.index') }}">
              <button class="primary-btn blue-button"><i class="fas fa-eye btn-eye"></i>View All Add-on</button>
            </a>
        </div>
    </div>
    <div class="skill-reg-form">
        <form id="createform" class="regular-form" action="{{ route('addon-plans.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Plan Name<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" type="text" value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Price<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="price" name="price" min="0" class="form-control @error('price') is-invalid @enderror" type="number" value="{{ old('price') }}">
                    </div>
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select name="status" class="form-select form-select-lg @error('status') is-invalid @enderror">
                            <option value="">Select Status</option>
                            @foreach ($status as $key =>$statusname)
                                <option value="{{ $key}}">{{ $statusname }}</option>
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
                  <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="{{ route('addon-plans.index') }}" class="btn btn-primary black-button">Cancel</a>
                    <a href="" class="btn btn-secondary btn-primary">Reset</a>
                </div>
            </div>            
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
            price   : {required: true},            
            status   : {required: true},
            
        },
        submitHandler: function(form) {
           form.submit();
        }
    });
</script>
@endsection
