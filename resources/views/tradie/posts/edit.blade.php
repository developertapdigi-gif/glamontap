@extends('tradie.layouts.master')
@section('title') Edit Post @endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2>Edit Post</h2>
        <div class="right-title">
            <a href="{{ route('tradie.posts.index') }}"><button class="primary-btn black-button">Back</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="post-job white-background p-4">
                <form action="{{ route('tradie.posts.update', $post->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $post->title }}">
                        @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="4">{{ $post->short_description }}</textarea>
                        @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Skill Category</label>
                        <select name="skill_category_id" class="form-control form-select">
                            <option value="">Select Skill (optional)</option>
                            @foreach($skills as $skill)
                            <option value="{{ $skill->id }}" {{ $post->skill == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
