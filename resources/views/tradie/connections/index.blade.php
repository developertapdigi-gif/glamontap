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
            @if(request('search'))
                <a href="{{ route('tradie.connections.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>

        {{-- Search Results --}}
        @if(request('search') && $searchResults)
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="mb-3">Search Results for "{{ request('search') }}"</h6>
            </div>
            @forelse($searchResults as $tradie)
            @php
            $pic = url('/').'/images/icons/Profile.svg';
            if($tradie->profile_picture && File::exists(public_path($tradie->profile_picture))){
                $pic = asset($tradie->profile_picture);
            }
            
            // Check if request already sent
            $isSent = $sentRequests->contains('receiver_id', $tradie->id);
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="white-background p-3 text-center border">
                    <img src="{{ $pic }}" class="rounded-circle mb-2" width="60" height="60">
                    <p><b>{{ $tradie->first_name }} {{ $tradie->last_name }}</b></p>
                    <p class="text-muted small">{{ $tradie->skillCategory->name ?? '' }}</p>
                    @if($isSent)
                        <form action="{{ route('tradie.connections.action') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $sentRequests->where('receiver_id', $tradie->id)->first()->id ?? '' }}">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Cancel Request</button>
                        </form>
                    @else
                        <form action="{{ route('tradie.connections.send') }}" method="POST">
                            @csrf
                            <input type="hidden" name="connection_id" value="{{ $tradie->id }}">
                            <input type="hidden" name="search_term" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-primary">Send Request</button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-muted mt-2">No tradies found for "{{ request('search') }}".</p>
            </div>
            @endforelse
        </div>
        
        {{-- Search Results Pagination --}}
        @if(method_exists($searchResults, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $searchResults->links() }}
            </div>
        @endif
        @endif
    </div>

    {{-- Tabs Section --}}
    @if(!request('search'))
    <div class="white-background p-4">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="connectionTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                    All Tradies <span class="badge bg-secondary">{{ $allprofiles->total() ?? $allprofiles->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent" type="button" role="tab" aria-controls="sent" aria-selected="false">
                    Sent Requests <span class="badge bg-warning text-dark">{{ $sentRequests->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="friends-tab" data-bs-toggle="tab" data-bs-target="#friends" type="button" role="tab" aria-controls="friends" aria-selected="false">
                    Friends <span class="badge bg-success">{{ $friends->count() }}</span>
                </button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content mt-3" id="connectionTabsContent">
            <!-- Tab 1: All Tradies -->
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="row">
                    @forelse($allprofiles as $tradie)
                    @php
                    $pic = url('/').'/images/icons/Profile.svg';
                    if($tradie->profile_picture && File::exists(public_path($tradie->profile_picture))){
                        $pic = asset($tradie->profile_picture);
                    }
                    
                    // Check if request already sent
                    $isSent = $sentRequests->contains('receiver_id', $tradie->id);
                    
                    // Check if already friends
                    $isFriend = $friends->contains(function($friend) use ($tradie) {
                        return ($friend->user_id == $tradie->id || $friend->receiver_id == $tradie->id);
                    });
                    @endphp
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="white-background p-3 text-center border h-100">
                            <img src="{{ $pic }}" class="rounded-circle mb-2" width="60" height="60">
                            <p><b>{{ $tradie->first_name }} {{ $tradie->last_name }}</b></p>
                            <p class="text-muted small">{{ $tradie->skillCategory->name ?? '' }}</p>
                            @if($isFriend)
                                <span class="badge bg-success">Friend</span>
                            @elseif($isSent)
                                <form action="{{ route('tradie.connections.action') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $sentRequests->where('receiver_id', $tradie->id)->first()->id ?? '' }}">
                                    <input type="hidden" name="action" value="remove">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancel Request</button>
                                </form>
                            @else
                                <form action="{{ route('tradie.connections.send') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="connection_id" value="{{ $tradie->id }}">
                                    <button type="submit" class="btn btn-sm btn-primary">Send Request</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No tradies available.</p>
                    </div>
                    @endforelse
                </div>
                
                {{-- All Profiles Pagination --}}
                @if(method_exists($allprofiles, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $allprofiles->links() }}
                    </div>
                @endif
            </div>

            <!-- Tab 2: Sent Requests -->
            <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab">
                @if($sentRequests->count())
                    <div class="row">
                        @foreach($sentRequests as $req)
                        @php
                        $pic = url('/').'/images/icons/Profile.svg';
                        if($req->receiver && $req->receiver->profile_picture && File::exists(public_path($req->receiver->profile_picture))){
                            $pic = asset($req->receiver->profile_picture);
                        }
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="white-background p-3 text-center border h-100">
                                <img src="{{ $pic }}" class="rounded-circle mb-2" width="60" height="60">
                                <p><b>{{ $req->receiver->first_name ?? '' }} {{ $req->receiver->last_name ?? '' }}</b></p>
                                <p class="text-muted small">{{ $req->receiver->skillCategory->name ?? '' }}</p>
                                <p class="text-warning small">Pending</p>
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
                @else
                    <p class="text-center text-muted py-3">No pending requests.</p>
                @endif
            </div>

            <!-- Tab 3: Friends -->
            <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                @if($friends->count())
                    <div class="row">
                        @foreach($friends as $conn)
                        @php
                        $friend = $conn->user_id == Auth::id() ? $conn->receiver : $conn->sender;
                        $pic = url('/').'/images/icons/Profile.svg';
                        if($friend && $friend->profile_picture && File::exists(public_path($friend->profile_picture))){
                            $pic = asset($friend->profile_picture);
                        }
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="white-background p-3 text-center border h-100">
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
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted py-3">No friends yet. Search for tradies above.</p>
                @endif
            </div>
        </div>
    </div>
    @endif {{-- End of !request('search') --}}
</div>

@push('scripts')
<script>
    // Optional: Store active tab in localStorage to persist across page reloads
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('#connectionTabs button[data-bs-toggle="tab"]');
        
        // Restore active tab from localStorage
        const activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            const tabElement = document.querySelector(`#connectionTabs button[data-bs-target="${activeTab}"]`);
            if (tabElement) {
                const tabInstance = new bootstrap.Tab(tabElement);
                tabInstance.show();
            }
        }
        
        // Save active tab on change
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(event) {
                localStorage.setItem('activeTab', event.target.getAttribute('data-bs-target'));
            });
        });
    });
</script>
@endpush
@endsection