@extends('tradie.layouts.master')
@section('title') Create Post @endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2>Create Post</h2>
        <div class="right-title">
            <a href="{{ route('tradie.posts.index') }}"><button class="primary-btn black-button">Back</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="post-job white-background p-4">
                <form action="{{ route('tradie.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                        @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Photo / Video <span class="text-danger">*</span></label>
                        <input type="file" name="media" class="form-control" accept="image/*,video/mp4">
                        @error('media')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Skill Category</label>
                        <select name="skill_category_id" class="form-control form-select">
                            <option value="">Select Skill (optional)</option>
                            @foreach($skills as $skill)
                            <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Publish Post</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
