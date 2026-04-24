@extends('admin.layouts.master')
@section('title')
Update Page
@endsection

@section('content')
<div class="container-fluid middle-content dashboard-content">
   <div class="page-title">
      <h2 class="desktop-content"><i class="post-icon"></i>Add Page</h2>
      <h2 class="mobile-content"><i class="post-icon"></i>Add Page</h2>
      <div class="right-title">
         <a href="{{ route('cms.index') }}">
         <button class="primary-btn blue-button"><i class="fas fa-eye btn-eye"></i>View All Page</button>
         </a>
      </div>
   </div>
   <div class="skill-reg-form">
      <form id="createform" class="regular-form" action="{{ route('cms.update',$model->id) }}" method="POST" enctype="multipart/form-data">
           @csrf
          @method('PUT')
         <div class="row">
            <div class="col-6">
               <label class="form-label">Page Title<span class="text-danger">*</span></label>
               <div class="input-group">
                  <input id="page_title" name="page_title" class="form-control @error('page_title') is-invalid @enderror" type="text" value="{{ old('page_title') ?? $model->page_title }}">
               </div>
               @error('page_title')
               <div class="alert alert-danger">{{ $message }}</div>
               @enderror
            </div>
            <div class="col-6">
               <label class="form-label">URL Key<span class="text-danger">*</span></label>
               <div class="input-group">
                  <input id="url_key" name="url_key" class="form-control @error('url_key') is-invalid @enderror" type="text" value="{{ old('url_key') ?? $model->url_key }}">
               </div>
               @error('url_key')
               <div class="alert alert-danger">{{ $message }}</div>
               @enderror
            </div>
         </div>       
         <div class="row">
            <div class="col">
               <label class="form-label">Meta Title<span class="text-danger">*</span></label>
               <div class="input-group">
                  <input id="meta_title" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" type="text" value="{{ old('meta_title') ?? $model->meta_title }}">
               </div>
               @error('meta_title')
               <div class="alert alert-danger">{{ $message }}</div>
               @enderror
            </div>
         </div>
         <div class="row">
            <div class="col">
               <label class="form-label">Meta Description<span class="text-danger">*</span></label>
               <div class="input-group">
                  <input id="meta_description" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" type="text" value="{{ old('meta_description') ?? $model->meta_description }}">
               </div>
               @error('meta_description')
               <div class="alert alert-danger">{{ $message }}</div>
               @enderror
            </div>
         </div>
         <div class="row">
            <div class="col">
               <label class="form-label">Content<span class="text-danger">*</span></label>
               <div class="input-group">                 
                  <textarea id="page_content" class="form-control @error('page_content') is-invalid @enderror" rows="10" name="page_content">{{ old('page_content') ?? $model->page_content }}</textarea>
               </div>
               @error('page_content')
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
                     @foreach ($status as $key=>$statusvalue)
                        <option value="{{ $key }}" {{ ($key == $model->status)?'selected':''}}>{{ $statusvalue }}</option>
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
               <button class="btn btn-primary" type="submit">Update Page</button>
               <a href="{{ route('cms.index') }}" class="btn btn-primary black-button">Cancel</a>
               <a href="" class="btn btn-secondary btn-primary">Reset</a>
            </div>
         </div>
   </form>
</div>
</div>
@endsection
@section('css')
<style type="text/css">
   .ck.ck-editor__editable_inline[role='textbox'] {
       min-height: 200px;
   }
</style>
@endsection
@section('script')
<script src="{{asset('js/ckeditor.js')}}"></script> 
<script src="{{ asset('js/editor.js') }}"></script>  
<script type="text/javascript">
   var mediauploadUrl = "{{ route('ckeditor.image-upload') }}";
</script>
@endsection