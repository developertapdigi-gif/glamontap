@extends('tradie.layouts.master')
@section('title') Connections @endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2>Connections</h2>
    </div>

    {{-- Search Tradies --}}
    <div class="white-background p-4 mb-4">
        <h5>Find Tradies</h5>
        <form action="{{ route('tradie.connections.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        @if(request('search'))
        <div class="row mt-3">
            @forelse($searchResults as $tradie)
            @php
            $pic = url('/').'/images/icons/Profile.svg';
            if($tradie->profile_picture && File::exists(public_path($tradie->profile_picture))){
                $pic = asset($tradie->profile_picture);
            }
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="white-background p-3 text-center border">
                    <img src="{{ $pic }}" class="rounded-circle mb-2" width="60" height="60">
                    <p><b>{{ $tradie->first_name }} {{ $tradie->last_name }}</b></p>
                    <p class="text-muted small">{{ $tradie->skillCategory->name ?? '' }}</p>
                    <form action="{{ route('tradie.connections.send') }}" method="POST">
                        @csrf
                        <input type="hidden" name="connection_id" value="{{ $tradie->id }}">
                        <input type="hidden" name="search_term" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Send Request</button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-muted mt-2">No tradies found.</p>
            @endforelse
        </div>
        @endif
    </div>

    {{-- Sent Requests --}}
    @if($sentRequests->count())
    <div class="mb-4">
        <h5>Sent Requests ({{ $sentRequests->count() }})</h5>
        <div class="row">
            @foreach($sentRequests as $req)
            @php
            $pic = url('/').'/images/icons/Profile.svg';
            if($req->receiver && $req->receiver->profile_picture && File::exists(public_path($req->receiver->profile_picture))){
                $pic = asset($req->receiver->profile_picture);
            }
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="white-background p-3 text-center border">
                    <img src="{{ $pic }}" class="rounded-circle mb-2" width="60" height="60">
                    <p><b>{{ $req->receiver->first_name ?? '' }} {{ $req->receiver->last_name ?? '' }}</b></p>
                    <p class="text-muted small">{{ $req->receiver->skillCategory->name ?? '' }}</p>
                    <form action="{{ route('tradie.connections.action') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $req->id }}">
                        <input type="hidden" name="action" value="remove">
                        <button class="btn btn-sm btn-outline-danger">Cancel Request</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Friend Requests --}}
    @if($requests->count())
    <div class="mb-4">
        <h5>Friend Requests ({{ $requests->count() }})</h5>
        <div class="row">
            @foreach($requests as $req)
            @php
            $pic = url('/').'/images/icons/Profile.svg';
            if($req->sender && $req->sender->profile_picture && File::exists(public_path($req->sender->profile_picture))){
                $pic = asset($req->sender->profile_picture);
            }
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="white-background p-3 text-center border">
                    <img src="{{ $pic }}" class="rounded-circle mb-2" width="60" height="60">
                    <p><b>{{ $req->sender->first_name ?? '' }} {{ $req->sender->last_name ?? '' }}</b></p>
                    <div class="d-flex justify-content-center gap-2">
                        <form action="{{ route('tradie.connections.action') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $req->id }}">
                            <input type="hidden" name="action" value="accept">
                            <button class="btn btn-sm btn-success">Accept</button>
                        </form>
                        <form action="{{ route('tradie.connections.action') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $req->id }}">
                            <input type="hidden" name="action" value="reject">
                            <button class="btn btn-sm btn-danger">Reject</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Friends List --}}
    <h5>Friends ({{ $friends->count() }})</h5>
    <div class="row">
        @forelse($friends as $conn)
        @php
        $friend = $conn->user_id == Auth::id() ? $conn->receiver : $conn->sender;
        $pic = url('/').'/images/icons/Profile.svg';
        if($friend && $friend->profile_picture && File::exists(public_path($friend->profile_picture))){
            $pic = asset($friend->profile_picture);
        }
        @endphp
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <div class="white-background p-3 text-center border">
                <img src="{{ $pic }}" class="rounded-circle mb-2" width="60" height="60">
                <p><b>{{ $friend->first_name ?? '' }} {{ $friend->last_name ?? '' }}</b></p>
                <p class="text-muted small">{{ $friend->skillCategory->name ?? '' }}</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('user', $friend->id) }}" target="_blank" class="btn btn-sm btn-primary">Message</a>
                    <form action="{{ route('tradie.connections.action') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $conn->id }}">
                        <input type="hidden" name="action" value="remove">
                        <button class="btn btn-sm btn-outline-danger">Remove</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12"><p class="text-center text-muted">No friends yet. Search for tradies above.</p></div>
        @endforelse
    </div>
</div>
@endsection
