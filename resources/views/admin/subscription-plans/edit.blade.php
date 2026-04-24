@extends('admin.layouts.master')
@section('title')
  Update {{$model->name}}
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2 class="desktop-content"><i class="subscription-black"></i>Update {{$model->name}}</h2>    
        <h2 class="mobile-content"><i class="subscription-black"></i>Update {{$model->name}}</h2>
        <div class="right-title">             
            <a href="{{ route('plans.index') }}">
              <button class="primary-btn blue-button"><i class="fas fa-eye btn-eye"></i>View All Subscription Plan</button>
            </a>
        </div>
    </div>
    <div class="skill-reg-form">
        <form id="createform" class="regular-form" action="{{ route('plans.update',$model->id) }}" method="POST"  enctype="multipart/form-data">
          @csrf
          @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Plan Name<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" type="text" value="{{ old('name') ?? $model->name }}">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select name="status" class="form-select form-select-lg @error('status') is-invalid @enderror">
                            <option value="">Select Status</option>
                            @foreach ($status as $key =>$statusname)
                                <option value="{{ $key}}" @if($key==$model->status) selected @endif>{{ $statusname }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>  
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Monthly Price<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="monthly_price" name="monthly_price" min="0" class="form-control @error('monthly_price') is-invalid @enderror" type="number" value="{{ old('monthly_price') ?? $model->monthly_price }}">
                    </div>
                    @error('monthly_price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Yearly Price<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="yearly_price" name="yearly_price" min="0" class="form-control @error('yearly_price') is-invalid @enderror" type="number" value="{{ old('yearly_price') ?? $model->yearly_price }}">
                    </div>
                    @error('yearly_price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Stripe Id<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="stripe_product_id" name="stripe_product_id" class="form-control @error('stripe_product_id') is-invalid @enderror" type="text" value="{{ old('stripe_product_id')?? $model->stripe_product_id }}">
                    </div>
                    @error('stripe_product_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stripe Monthly Price<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="stripe_monthly_price_id" name="stripe_monthly_price_id" class="form-control @error('stripe_monthly_price_id') is-invalid @enderror" type="text" value="{{ old('stripe_monthly_price_id')?? $model->stripe_monthly_price_id }}">
                    </div>
                    @error('stripe_monthly_price_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stripe Yearly Price<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="stripe_yearly_price_id" name="stripe_yearly_price_id" class="form-control @error('stripe_yearly_price_id') is-invalid @enderror" type="text" value="{{ old('stripe_yearly_price_id')?? $model->stripe_yearly_price_id }}">
                    </div>
                    @error('stripe_yearly_price_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Job Limit<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="job_limit" name="job_limit" min="0" class="form-control @error('job_limit') is-invalid @enderror" type="number" value="{{ old('job_limit') ?? $model->job_limit }}">
                    </div>
                    @error('job_limit')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Candidate Recommendations limit<span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input id="tradesman_limit" name="tradesman_limit" min="0" class="form-control @error('tradesman_limit') is-invalid @enderror" type="number" value="{{ old('tradesman_limit') ?? $model->tradesman_limit }}">
                    </div>
                    @error('tradesman_limit')
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
                <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="6\4">{{ old('description') ?? $model->description }}</textarea>
                </div> 
            </div>
            <div class="row">
                <div class="mt-5">
                  <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="{{ route('plans.index') }}" class="btn btn-primary black-button">Cancel</a>
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
            monthly_price      : {required: true},            
            yearly_price   : {required: true},
            job_limit       : {required: true},
            tradesman_limit : {required: true},
            description     : {required: true},
            class_name     : {required: true},
        },
        submitHandler: function(form) {
           form.submit();
        }
    });
</script>
@endsection
