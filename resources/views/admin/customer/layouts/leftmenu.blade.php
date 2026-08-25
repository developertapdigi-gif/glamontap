@php
use App\Models\Setting;
$model = Setting::setting();
@endphp
<h1><a href="{{ url('/') }}" class="logo">
    <img src="{{ $model['favicon'] }}" /></a>
</h1>
<ul class="list-unstyled components mb-5">
    <li class="{{ Str::contains(url()->current(), 'customer/dashboard') ? 'active' : '' }}">
        <a href="{{ route('customer.dashboard') }}">
            <i class="dashboard-icon"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="{{Str::endSWith(url()->current(), 'jobs/create') ? 'active' : '' }}">
        <a href="{{ route('jobs.create') }}">
            <i class="post-icon"></i>
             Post New Job
        </a>
    </li>
    <li class="{{Str::endSWith(url()->current(), 'jobs') ? 'active' : '' }}">
        <a href="{{ route('jobs.index') }}">
            <i class="jobs-icon"></i>
             Jobs
        </a>
    </li>
    {{-- <li class="{{ Str::contains(url()->current(), 'customer/jobs') ? 'active' : '' }}">
        <a href="{{ route('customer.jobs.index') }}">
            <i class="jobs-icon"></i>
          Work
        </a>
    </li> --}}
    <li class="{{ Str::contains(url()->current(), 'customer/posts/list') ? 'active' : '' }}">
        <a href="{{ route('customer.posts.list') }}">
            <i class="post-icon"></i>
            Posts
        </a>
    </li>

    <li class="{{ Str::contains(url()->current(), 'customer/profile') ? 'active' : '' }}">
        <a href="{{ route('customer.profile.index') }}">
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
