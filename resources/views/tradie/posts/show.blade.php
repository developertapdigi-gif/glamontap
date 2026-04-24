@extends('tradie.layouts.master')
@section('title') Post Detail @endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2>Post Detail</h2>
        <div class="right-title">
            <a href="{{ route('tradie.posts.index') }}"><button class="primary-btn black-button">Back</button></a>
            @if($post->created_at->diffInDays(now()) <= 2)
            <a href="{{ route('tradie.posts.edit', $post->id) }}"><button class="primary-btn blue-button">Edit</button></a>
            @endif
            <form action="{{ route('tradie.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this post?')">
                @csrf
                <button type="submit" class="primary-btn" style="background:#dc3545;color:#fff;">Delete</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="post-job white-background p-4">

                {{-- Media --}}
                @if($post->gallery->count())
                <div class="mb-3">
                    @foreach($post->gallery as $media)
                    @if($media->type == 2)
                    <video src="{{ asset($media->path) }}" class="img-fluid mb-2" style="width:100%;max-height:350px;" controls></video>
                    @else
                    <img src="{{ asset($media->path) }}" class="img-fluid mb-2" style="width:100%;max-height:350px;object-fit:cover;">
                    @endif
                    @endforeach
                </div>
                @endif

                <h4>{{ $post->title }}</h4>
                <p class="text-muted small mb-3">{{ $post->created_at->format('d M Y') }}</p>

                @if($post->SkillCategory)
                <p><b>Skill:</b> {{ $post->SkillCategory->name }}</p>
                @endif

                @if($post->location)
                <p><b>Location:</b> {{ $post->location }}</p>
                @endif

                <div class="mt-3">
                    <b>Description</b>
                    <p class="mt-1">{{ $post->short_description }}</p>
                </div>

                @if($post->content)
                <div class="mt-3">
                    {!! $post->content !!}
                </div>
                @endif

            </div>
        </div>

        <div class="col-lg-4">
            <div class="dashboard-table white-background p-4">
                <h5>Post Info</h5>
                <p><b>Status:</b> {{ $post->status == 1 ? 'Active' : 'Inactive' }}</p>
                <p><b>Posted On:</b> {{ $post->created_at->format('d M Y, h:i A') }}</p>
                <p><b>Last Updated:</b> {{ $post->updated_at->format('d M Y, h:i A') }}</p>
                @if($post->created_at->diffInDays(now()) <= 2)
                <p class="text-success small"><i class="bi bi-pencil-fill"></i> Editable until {{ $post->created_at->addDays(2)->format('d M Y') }}</p>
                @else
                <p class="text-muted small"><i class="bi bi-lock-fill"></i> Editing period has expired</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
