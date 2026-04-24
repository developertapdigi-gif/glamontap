@extends('tradie.layouts.master')
@section('title') My Posts @endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2>My Posts</h2>
        <div class="right-title">
            <a href="{{ route('tradie.posts.create') }}"><button class="primary-btn blue-button"><i class="icon-plus"></i> New Post</button></a>
        </div>
    </div>

    <div class="row">
        @forelse($posts as $post)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="white-background p-3">
                @if($post->gallery->first())
                @php $media = $post->gallery->first(); @endphp
                @if($media->type == 2)
                <video src="{{ asset($media->path) }}" class="img-fluid mb-2" style="max-height:180px;width:100%" controls></video>
                @else
                <img src="{{ asset($media->path) }}" class="img-fluid mb-2" style="max-height:180px;width:100%;object-fit:cover">
                @endif
                @endif
                <h6>{{ $post->title }}</h6>
                <p class="text-muted small">{{ mb_strimwidth($post->short_description, 0, 80, '...') }}</p>
                <p class="text-muted small">{{ $post->created_at->format('d M Y') }}</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('tradie.posts.show', $post->id) }}" class="btn btn-sm btn-secondary">View</a>
                    @if($post->created_at->diffInDays(now()) <= 2)
                    <a href="{{ route('tradie.posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    @endif
                    <form action="{{ route('tradie.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Delete this post?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12"><p class="text-center">No posts yet.</p></div>
        @endforelse
    </div>
    {{ $posts->links() }}
</div>
@endsection
