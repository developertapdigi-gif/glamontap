@extends('admin.layouts.master')
@section('title','Comment on Post')
@section('content')
<div class="container-fluid middle-content dashboard-content">
<div class="page-title">
	    <h2 class="mobile-hide"><i class="bi  bi-chat-fill"></i>Comments</h2>
	    
	</div>
	<div class="current-notifications">
	    <ul class="notification-list">
			@foreach($comments as $_comment)
			<li>	            <div>
	                <b>{{$_comment->comment}}</b>
	            </div> 
	              
	        </li>
			@endforeach
	       
	    </ul>  
	</div>

	<div class="skill-reg-form">
        <form id="createform" class="regular-form" action="{{ route('endrosement-post.storecomment') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="row">
              <div class="col">
                <label class="form-label">Comment<span class="text-danger">*</span></label>
                <div class="input-group">
				<textarea class="form-control" id="comment" name="comment" rows="6\4" required>{{ old('comment') }}</textarea>
                </div>
                @error('comment')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
			  <input type="hidden" name="post_id" id="post_id" value="{{$post_id}}">
			  <input type="hidden" name="parent_id" id="parent_id" value="{{$parent_id}}">
            <div class="row">
            <div class="mt-5">
              <button class="btn btn-primary" type="submit">Add New Comment</button>
                <a href="{{ route('endrosement-post.index') }}" class="btn btn-primary black-button">Cancel</a>
                <a href="" class="btn btn-secondary btn-primary">Reset</a>
              </div>
            </div>
            </div>
            <!-- <button class="btn bg-gradient-dark btn-sm float-end mt-6 mb-0" type="submit">Save</button> -->
          </form>
        </div>
	
</div>

@endsection