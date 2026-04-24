@extends('admin.layouts.master')
@section('title','Notifications')
@section('content')
<div class="container-fluid middle-content dashboard-content">
	<div class="page-title">
	    <h2 class="mobile-hide"><i class="bi bi-bell-title"></i>Notifications</h2>
	    
	</div>
	<div class="current-notifications">
	    <!-- <h3> TODAY  <a class="primary-btn blue-button ms-auto" href="{{route('notifications.index')}}"><i class="bi bi-arrow-clockwise"></i>Refresh</a></h3> -->
	    <ul class="notification-list">
			@foreach($notifications as $notify)
			<li>
			@php
                  $route = "#";
                  if(in_array($notify->type,[1,2,3,4,8,9,13,19,20])){
                     $route = route('job.show',$notify->reference_id);
				  }else if(in_array($notify->type,[7]) && in_array(Auth::user()->user_type,[2,4])){
                     $route = route('endrosement-post.show',$notify->reference_id);
                  }
                  @endphp
				  <img class="img-fluid" src="{{($notify->sender)?(($notify->sender->profile_picture)?asset($notify->sender->profile_picture):asset('images/person1.png')):asset('images/person1.png')}}"/>
	            <div>
					<a href="{{$route}}"><b>{{$notify->message}}</b></a>
	                <p> {{($notify->sender)?$notify->sender->address:''}}</p>
	            </div> 
	            <div class="not-time">

					@if(date('Y-m-d') == Carbon\Carbon::parse($notify->created_at)->format('Y-m-d'))
					@if(floor(round(abs(strtotime(now()) - strtotime($notify->created_at)) / 60) / 60) == 1)
                     {{floor(round(abs(strtotime(now()) - strtotime($notify->created_at)) / 60) / 60)}} hour ago
                     @elseif(floor(round(abs(strtotime(now()) - strtotime($notify->created_at)) / 60) / 60) > 1)
                     {{floor(round(abs(strtotime(now()) - strtotime($notify->created_at)) / 60) / 60)}} hours ago
                     @elseif(round(abs(strtotime(now()) - strtotime($notify->created_at)) / 60) <= 1)
                     {{round(abs(strtotime(now()) - strtotime($notify->created_at)) / 60)}}
                     min ago
					 @else
					 {{round(abs(strtotime(now()) - strtotime($notify->created_at)) / 60)}}
                     mins ago
                     @endif
					@else
					{{$days = round(floor(floor((strtotime(now())-strtotime($notify->created_at)) / 60) / 60) / 24)}} {{($days == 1)?"day":"days"}} ago
					@endif
			
	            </div>   
	        </li>
			@endforeach
	       
	    </ul>  
	</div>
	<div class="row">
        <div class="skill-table-pagintion grid-pagintion  d-flex">
            {{ $notifications->links() }}
        </div>         
    </div>
	<!-- <div class="past-notifications">
	    <h3> YESTERDAY</h3>
	</div>
 	  -->
</div>
@endsection