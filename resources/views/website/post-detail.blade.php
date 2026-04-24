@extends('website.layouts.master')
@section('title')
Search Details
@endsection
@section('content')

<h1>{{ $post->title }}</h1>

<p>
    By {{ $post->author->first_name ?? 'Admin' }} |
    {{ $post->created_at->format('d M Y') }}
</p>

@if($post->thumb_url)
    <img src="{{ asset('storage/'.$post->thumb_url) }}" width="400">
@endif

<p>{{ $post->content }}</p>

<hr>

{{-- <p>👍 {{ $post->likes }} | 👎 {{ $post->dislikes }} | 👁 {{ $post->views }}</p> --}}

<a href="{{ route('employer') }}">← Back</a>

@endsection