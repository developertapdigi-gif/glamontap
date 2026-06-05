@php 
use App\Models\{Setting,User};
use Illuminate\Support\Facades\Auth;
$condition = 'id>0';
$setting = Setting::whereRaw($condition)->orderby('id', 'desc')->paginate(1); 
if(count($setting)){
    $setting_link = route("setting.edit", $setting[0]->id);
    $mail_setting_link = route("setting.mailedit", $setting[0]->id);
}
else{
    $mail_setting_link = $setting_link = route('setting.create');
}
$model = Setting::setting();
@endphp
<h1><a href="{{url('/')}}" id="dashboard-logo" class="logo">
    <img src="{{ $model['favicon'] }}" /></a>
</h1>
<ul class="list-unstyled components mb-5">
    @hasrole('admin')
    <li class="{{Str::contains(url()->current(), 'dashboard') ? 'active' : '' }}">
        <a href="/dashboard">
        <i class="dashboard-icon"></i>
        <span> Dashboard</span></a>
    </li>
    <li class="{{Str::endSWith(url()->current(), 'job/create') ? 'active' : '' }}">
        <a href="{{ route('job.create') }}">
            <i class="post-icon"></i>
             Post New Job
        </a>
    </li>
    <li class="{{Str::endSWith(url()->current(), 'job') ? 'active' : '' }}">
        <a href="{{ route('job.index') }}">
            <i class="jobs-icon"></i>
             Jobs
        </a>
    </li>
    <li class="{{Str::contains(url()->current(), 'agency') ? 'active' : '' }}">
        <a href="{{ route('agency.index') }}">
            <i class="agencies-icon"></i>
            Companies
        </a>
    </li>
    <li class="{{Str::contains(url()->current(), 'agent') ? 'active' : '' }}">
        <a href="{{route('agent.index')}}">
            <i class="employees-icon"></i>
             Sub Users
        </a>
    </li>
    <li class="{{Str::contains(url()->current(), 'trader') ? 'active' : '' }}">
            <a href="{{ route('trader.index') }}">
                <i class="employees-icon"></i>
                Tradies
            </a>
        </li>
        
    <li class="pb-0 {{Str::contains(url()->current(), 'post-over-wall') ? 'active' : '' }}">
        <a href="{{ route('post-over-wall.index') }}">
            <i class="post-icon"></i>
             Post Over Wall
        </a>
    </li>
    <div class="leftnav navmenu admin-leftbar">
        <li class="dropdown pb-0 {{Str::contains(url()->current(), ['plans','subscribers']) ? 'active' : '' }}">
        <a class="mt-0 mb-0"  href="#">
            <i class="subsription-icon"></i>
             Subscription
        </a>
        <ul class="dropdown-menu leftnav-deepmenu">
            <li><a href="{{ route('plans.index') }}">Plans</a></li>
            <li><a href="{{ route('addon-plans.index') }}">Add-on Plans</a></li>
            <li><a href="{{ route('subscriber.view') }}">Subscribers</a></li>
          </ul>
        </li>
    </div>
    <li class="pb-0 {{Str::contains(url()->current(), 'skill-categories') ? 'active' : '' }}">
        <a href="{{ route('skill-categories.index') }}">
            <i class="skill-icon"></i>
             Skill Categories
        </a>
    </li>
     <li class="pb-0 {{Str::contains(url()->current(), 'appointments') ? 'active' : '' }}">
        <a href="{{ route('appointments.index') }}" class="appointment-icon">
            <i class="bi bi-calendar-check"></i>
             Appointment 
        </a>
    </li>
    <li class="{{Str::contains(url()->current(), 'badges') ? 'active' : '' }}">
        <a href="{{ route('badges.index') }}">
            <i class="badges-icon"></i>
             Badges
        </a>
    </li>
    <li class="{{Str::contains(url()->current(), 'feedback') ? 'active' : '' }}">
        <a href="{{ route('feedback-survey.index') }}">
            <img src="{{ asset('images/icons/feedback1.svg')}}" alt="" class="mx-auto">
             Feedback
        </a>
    </li>

    <div class="leftnav navmenu admin-leftbar">
        <li class="dropdown pb-0 {{Str::contains(url()->current(), 'setting') ? 'active' : '' }}">
        <a class="mt-0 mb-0"  href="#">
            <i class="setting-icon"></i>
             Settings
        </a>
        <ul class="dropdown-menu leftnav-deepmenu">
            <li><a href="{{ $setting_link }}">General</a></li>
            <li><a href="{{ $mail_setting_link }}">SMTP</a></li>
          </ul>
        </li>
    </div>
    @else
    @if(Auth::user()->user_type == User::ROLE['agency'])
    <li class="{{Str::contains(url()->current(), 'dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
        <i class="dashboard-icon"></i>
        <span> Dashboard</span></a>
    </li>
    <li class="{{Str::endSWith(url()->current(), 'job/create') ? 'active' : '' }}">
        <a href="{{ route('job.create') }}">
            <i class="post-icon"></i>
             Post New Job
        </a>
    </li>
    <li class="{{Str::endSWith(url()->current(), 'job') ? 'active' : '' }}">
        <a href="{{ route('job.index') }}">
            <i class="jobs-icon"></i>
             Jobs
        </a>
    </li>
    <li class="pb-0 {{Str::contains(url()->current(), 'appointments') ? 'active' : '' }}">
        <a href="{{ route('bookings') }}">
            <i class="bi bi-calendar-check"></i>
             Appointment 
        </a>
    </li>
    <li class = "{{ Str::contains(url()->current(), 'endrosement-post') ? 'active' : '' }}">
        <a href="{{route('endrosement-post.index')}}">
            <i class="endorsments-icon"></i>
             Endorsement Posts
        </a>
    </li>
    <li class="{{Str::contains(url()->current(), 'agent') ? 'active' : '' }}">
        <a href="{{route('agent.index')}}">
            <i class="employees-icon"></i>
             Sub Users
        </a>
    </li>
    
    <li class="{{Str::contains(url()->current(), 'subscription') ? 'active' : '' }}">
        <a href="{{ route('subscription.index') }}">
            <i class="subsription-icon"></i>
            Subscription 
        </a>
    </li>
    @else
    <li class="{{Str::contains(url()->current(), 'dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
        <i class="dashboard-icon"></i>
        <span> Dashboard</span></a>
    </li>
    <li class="{{Str::endSWith(url()->current(), 'job/create') ? 'active' : '' }}">
        <a href="{{ route('job.create') }}">
            <i class="post-icon"></i>
             Post New Job
        </a>
    </li>
    <li class="{{Str::endSWith(url()->current(), 'job') ? 'active' : '' }}">
        <a href="{{ route('job.index') }}">
            <i class="jobs-icon"></i>
             Jobs
        </a>
    </li>
    <li class = "{{ Str::contains(url()->current(), 'endrosement-post') ? 'active' : '' }}">
        <a href="{{route('endrosement-post.index')}}">
            <i class="endorsments-icon"></i>
             Endrosement Posts
        </a>
    </li>
    @endif
    @endhasrole
    
    <li class="{{Str::contains(url()->current(), 'profile') ? 'active' : '' }}">
        <a href="{{ route('showprofile') }}">
            <i class="profile-icon"></i>
             Profile
        </a>
    </li>
</ul>
<div class="aside-footer">
    <ul class="list-unstyled components">
    <li>
         <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="logout-icon"></i>
             Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    </li>
    </ul>
</div>

<script>
$(document).ready(function () {

    $('#dashboard-logo').click(function (e) {
        e.preventDefault();

        $.get("{{ route('clear.employer.mode') }}", function () {
            window.location.href = "{{ url('/') }}";
        });
    });

});
</script>