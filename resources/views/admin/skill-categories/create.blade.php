@extends('admin.layouts.master')
@section('title')
Add new Skill Category
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
   <div class="page-title">
      <h2 class="desktop-content"><i class="skill-black"></i>Add Skill Category</h2>
      <h2 class="mobile-content"><i class="skill-black"></i>Add Skill Category</h2>
      <div class="right-title">
         <a href="{{ route('skill-categories.index') }}">
         <button class="primary-btn blue-button"><i class="fas fa-eye btn-eye"></i>View All Skill Categories</button>
         </a>
      </div>
   </div>
   <div class="skill-reg-form">
      <form id="createform" class="regular-form" action="{{ route('skill-categories.store') }}" method="POST" enctype="multipart/form-data">
         @csrf
         <div class="row">
            <div class="col">
               <label class="form-label">Name<span class="text-danger">*</span></label>
               <div class="input-group">
                  <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" type="text" value="{{ old('name') }}">
               </div>
               @error('name')
               <div class="alert alert-danger">{{ $message }}</div>
               @enderror
            </div>
         </div>
         <div class="row ">
            <div class="col">
               <label class="form-label">Status<span class="text-danger"></span></label>
               <div class="input-group">
                  <select name="status" class="form-select form-control " aria-label="Default select example">
                     <option value="0">Select Status</option>
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
               <button class="btn btn-primary" type="submit">Add New Skill Category</button>
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
   
       },
   
       submitHandler: function(form) {
          form.submit();
       }
   });
</script>
@endsection