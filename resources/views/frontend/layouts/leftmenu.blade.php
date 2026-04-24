<h1><a href="/" class="logo">
    <img src="{{ asset('images/logo-small.png') }}" /></a>
</h1>
<ul class="list-unstyled components mb-5">
    <li class="{{Str::contains(url()->current(), 'dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
        <i class="dashboard-icon"></i>
        <span> Dashboard</span></a>
    </li>
    <li class="{{Str::contains(url()->current(), 'job/create') ? 'active' : '' }}">
        <a href="{{ route('job.create') }}">
            <i class="post-icon"></i>
            <span class="fa fa-jobs"></span> Post New Job
        </a>
    </li>
    <li class="{{Str::contains(url()->current(), 'job') ? 'active' : '' }}">
        <a href="{{ route('job.index') }}">
            <i class="jobs-icon"></i>
            <span class="fa fa-jobs"></span> Jobs
        </a>
    </li>
    <li>
        <a href="#">
            <i class="agencies-icon"></i>
            <span class="fa fa-jobs"></span> Endrosement Posts
        </a>
    </li>
    <li class="{{Str::contains(url()->current(), 'agent') ? 'active' : '' }}">
        <a href="{{route('agent.index')}}">
            <i class="employees-icon"></i>
            <span class="fa fa-jobs"></span> Agents
        </a>
    </li>


    <li>
        <a href="#">
            <i class="subsription-icon"></i>
            <span class="fa fa-jobs"></span> Subscription
        </a>
    </li>


    <li>
        <a href="{{ route('profile') }}">
            <i class="profile-icon"></i>
            <span class="fa fa-jobs"></span> Profile
        </a>
    </li>
</ul>
<div class="aside-footer">
    <ul class="list-unstyled components">
    <li>
         <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="logout-icon"></i>
            <span class="fa fa-jobs"></span> Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    </li>
    </ul>
</div>
