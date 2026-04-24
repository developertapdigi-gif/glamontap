@extends('tradie.layouts.master')
@section('title') Notifications @endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2>Notifications</h2>
    </div>

    <div class="dashboard-table white-background p-3">
        @forelse($notifications as $notify)
        <div class="notification-item d-flex align-items-start p-3 border-bottom">
            <i class="{{ $notify->type == 1 ? 'bi bi-check-circle text-success' : 'bi bi-info-circle text-primary' }} me-3 mt-1"></i>
            <div>
                <p class="mb-1">{{ $notify->message }}</p>
                <small class="text-muted">{{ $notify->created_at->diffForHumans() }}</small>
            </div>
        </div>
        @empty
        <p class="text-center p-4">No notifications.</p>
        @endforelse
        {{ $notifications->links() }}
    </div>
</div>
@endsection
