@php
use App\Models\Setting;
$model = Setting::setting();
@endphp
<h1><a href="{{ url('/') }}" class="logo">
    <img src="{{ $model['favicon'] }}" /></a>
</h1>
<ul class="list-unstyled components mb-5">
    <li class="{{ Str::contains(url()->current(), 'tradie/dashboard') ? 'active' : '' }}">
        <a href="{{ route('tradie.dashboard') }}">
            <i class="dashboard-icon"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="{{ Str::contains(url()->current(), 'tradie/jobs') ? 'active' : '' }}">
        <a href="{{ route('tradie.jobs.index') }}">
            <i class="jobs-icon"></i>
          Work
        </a>
    </li>
    <li class="{{ Str::contains(url()->current(), 'tradie/posts') ? 'active' : '' }}">
        <a href="{{ route('tradie.posts.index') }}">
            <i class="post-icon"></i>
            Posts
        </a>
    </li>
    <li class="{{ Str::contains(url()->current(), 'tradie/connections') ? 'active' : '' }}">
        <a href="{{ route('tradie.connections.index') }}">
            <i class="employees-icon"></i>
            Connections
        </a>
    </li>
    {{-- <li class="{{ Str::contains(url()->current(), 'tradie/notifications') ? 'active' : '' }}">
        <a href="{{ route('tradie.notifications.index') }}">
            <i class="bi bi-bell"></i>
            Notifications
        </a>
    </li> --}}

    
    <li class="{{ Str::contains(url()->current(), 'tradie/messenger') ? 'active' : '' }}">
        <a href="{{ route('messages') }}" target="_blank" >
           <i class="bi bi-chat-dots"></i>
            Chat
        </a>
    </li>
    <li class="{{ Str::contains(url()->current(), 'tradie/profile') ? 'active' : '' }}">
        <a href="{{ route('tradie.profile.index') }}">
            <i class="profile-icon"></i>
            Profile
        </a>
    </li>
</ul>
<div class="aside-footer">
    <ul class="list-unstyled components">
        <li>
            <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('tradie-logout-form').submit();">
                <i class="logout-icon"></i>
                Logout
            </a>
            <form id="tradie-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
