@php
use App\Models\{Notification,ChMessage};
use App\Http\Resources\MessageCollection;
$count = Notification::getNotificationsByRecieverIdCount(Auth::user()->id);
$query = ChMessage::LatestConversations(Auth::user()->id)->paginate(3);
$messages = new MessageCollection($query);
$unread = ChMessage::UnReadConversations(Auth::user()->id)->count();
//echo'<pre>';print_r($unread);die;
@endphp
<div class="container-fluid">
  <button type="button" id="sidebarCollapse" class="fa-bars"></button>
  <!----------------Search Bar start---------->
  <div class="search-bar">
     
      {{-- <div class="top-search-form d-flex align-items-center" >
         <input type="text" id="search-input" placeholder="Search..." />
         <i class="bi bi-search"></i>
      </div> --}}
   <div class="d-absolute" id="search-results"></div>
  </div>
  <!----------------Search Bar end---------->
  <nav class="header-nav ms-auto">
     <ul class="d-flex align-items-center">
        <li class="nav-item dropdown">
           <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
           <i class="bi bi-bell bell-icon"></i>
           <span class="badge edit-profile-color bg-primary badge-number">{{$count}}</span>
           </a><!-- End Notification Icon -->
           <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
              <li class="dropdown-header">
                 You have {{$count}} new notifications
                 <a href="{{route('notifications.index',['isviewed=1'])}}"><span class="badge rounded-pill bg-primary p-2 ms-2">View
                 all</span></a>
              </li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              @foreach(Notification::getNotificationsByRecieverId(Auth::user()->id) as $notify)
              <li class="notification-item">
               
                 <i class="{{($notify->type == 1)?'bi bi-check-circle text-success':'bi bi-info-circle text-primary'}}"></i>
                 <div>
                  @php
                  $route = "#";
                  if(in_array($notify->type,[1,2,3,4,8,9,13,19,20])){
                     $route = route('job.show',$notify->reference_id);
                  }else if(in_array($notify->type,[7]) && in_array(Auth::user()->user_type,[2,4])){
                     $route = route('endrosement-post.show',$notify->reference_id);
                  }
                  @endphp
                    <a href="{{$route}}"><h4>{{ $notify->sender ? $notify->sender->first_name : '' }}</h4></a>
                    
                    <p>{{mb_strimwidth($notify->message,0,30,'...')}}</p>
                    <p>@if(date('Y-m-d') == Carbon\Carbon::parse($notify->created_at)->format('Y-m-d'))
                     
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
                     @endif</p>
                 </div>
              </li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              @endforeach
              
             
              <li class="dropdown-footer">
                 <a href="{{route('notifications.index',['isviewed=1'])}}">Show all notifications</a>
              </li>
           </ul>
           <!-- End Notification Dropdown Items -->
        </li>
        <!-- End Notification Nav -->
        <li class="nav-item dropdown">
           <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
           <i class="bi bi-chat-left-text"></i>
           <span class="badge edit-profile-color bg-success badge-number">{{$unread}}</span>
           </a><!-- End Messages Icon -->
           <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
              <li class="dropdown-header">
                 You have {{$unread}} new messages
                 <a href="/messages" target="_blank"><span class="badge rounded-pill bg-primary p-2 ms-2">View
                 all</span></a>
              </li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              @if($messages)
              @foreach($messages as $_message)
              <li class="message-item">
               @php 
               if($_message->from_id==Auth::user()->id){
                  if($_message->receiver->logo && (File::exists(public_path($_message->receiver->logo)))){
                     $url = asset($_message->receiver->logo);
                  }else if($_message->receiver->profile_picture && (File::exists(public_path($_message->receiver->profile_picture)))){
                     $url = asset($_message->receiver->profile_picture);
                  }else{
                  $url = url('/').'/images/icons/Profile.svg';
                  }
               }else{
                  if($_message->sender->logo && (File::exists(public_path($_message->sender->logo)))){
                     $url = asset($_message->sender->logo);
                  }else if($_message->sender->profile_picture && (File::exists(public_path($_message->sender->profile_picture)))){
                        $url = asset($_message->sender->profile_picture);
                  }else{
                     $url = url('/').'/images/icons/Profile.svg';}
               }
               @endphp
              
                 <a href="messages/{{$_message->from_id==Auth::user()->id?$_message->receiver->id:$_message->sender->id}}" target="_blank">
                    <img src="{{ $url }}" alt="" class="rounded-circle profile-image">
                    <div>
                       <h4>{{$_message->from_id==Auth::user()->id?$_message->receiver->first_name:$_message->sender->first_name}}</h4>
                       <p>{{$_message->body}}
                       </p>
                       <p>@if(date('Y-m-d') == Carbon\Carbon::parse($_message->created_at)->format('Y-m-d'))
                       @if(floor(round(abs(strtotime(now()) - strtotime($_message->created_at)) / 60) / 60) == 1)
                     {{floor(round(abs(strtotime(now()) - strtotime($_message->created_at)) / 60) / 60)}} hour ago
                     @elseif(floor(round(abs(strtotime(now()) - strtotime($_message->created_at)) / 60) / 60) > 1)
                     {{floor(round(abs(strtotime(now()) - strtotime($_message->created_at)) / 60) / 60)}} hours ago
                     @elseif(round(abs(strtotime(now()) - strtotime($_message->created_at)) / 60) <= 1)
                     {{round(abs(strtotime(now()) - strtotime($_message->created_at)) / 60)}}
                     min ago
                     @else
                     {{round(abs(strtotime(now()) - strtotime($_message->created_at)) / 60)}}
                     mins ago
                     @endif
                     @else
                        {{$days = round(floor(floor((strtotime(now())-strtotime($_message->created_at)) / 60) / 60) / 24)}} {{($days == 1)?"day":"days"}} ago
                        @endif
                       </p>
                    </div>
                 </a>
              </li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              
              @endforeach
              @endif
              
              
              <li class="dropdown-footer">
                 <a href="/messages" target="_blank">Show all messages</a>
              </li>
           </ul>
        </li>
        <li class="nav-item dropdown pe-3">
           <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
              data-bs-toggle="dropdown" aria-expanded="false">
              @php               
                           if(Auth::user()->profile_picture && (File::exists(public_path(Auth::user()->profile_picture)))){
                              $thumbnail = asset(Auth::user()->profile_picture);
                           }else{
                              $thumbnail = url('/').'/images/icons/Profile.svg';
                           }                           
            @endphp
           <img src="{{ $thumbnail }}" alt="Profile" class="rounded-circle">
           <span class="d-none d-md-block bi bi-three-dots ps-2"></span>
           </a><!-- End Profile Iamge Icon -->
           <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
              data-popper-placement="bottom-end"
              style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-16px, 38px);">
              <li class="dropdown-header">
                 <h6>{{ Auth::user() ? Auth::user()->first_name : "Kevin Anderson" }}</h6>
              </li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              <li>
                 <a class="dropdown-item d-flex align-items-center" href="{{ route('showprofile') }}">
                 <i class="bi bi-person"></i>
                 <span>My Profile</span>
                 </a>
              </li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              @hasrole('admin')
              <li>
                 <a class="dropdown-item d-flex align-items-center" href="{{ route('cacheRemove') }}">
                  <img src="{{asset('/images/icons/cache.svg')}}" alt="">
                 <span>Clear Cache</span>
                 </a>
              </li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              @endhasrole
              <li>
                 <a class="dropdown-item d-flex align-items-center" href="/contact" target="_blank">
                 <i class="bi bi-question-circle"></i>
                 <span>Need Help?</span>
                 </a>
              </li>
              <li>
                 <hr class="dropdown-divider">
              </li>
              <li>
                 <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                 <i class="bi bi-box-arrow-right"></i>
                 <span>Sign Out</span>
                 </a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
              </li>
           </ul>               
        </li>
     </ul>
  </nav>
</div>