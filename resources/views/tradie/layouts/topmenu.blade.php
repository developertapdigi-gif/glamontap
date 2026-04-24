@php
use App\Models\{Notification, ChMessage};
use App\Http\Resources\MessageCollection;
$count = Notification::getNotificationsByRecieverIdCount(Auth::user()->id);
$query = ChMessage::LatestConversations(Auth::user()->id)->paginate(3);
$messages = new MessageCollection($query);
$unread = ChMessage::UnReadConversations(Auth::user()->id)->count();
@endphp
<div class="container-fluid">
    <button type="button" id="sidebarCollapse" class="fa-bars"></button>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            {{-- Notifications --}}
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell bell-icon"></i>
                    <span class="badge edit-profile-color bg-primary badge-number">{{ $count }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        You have {{ $count }} new notifications
                        <a href="{{ route('tradie.notifications.index') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
              @foreach(Notification::getNotificationsByRecieverId(Auth::user()->id) as $notify)
              <li class="notification-item">
                  <i class="{{ ($notify->type == 1) ? 'bi bi-check-circle text-success' : 'bi bi-info-circle text-primary' }} me-3 mt-1"></i>
                  <div>
                      <h4>{{ $notify->sender ? $notify->sender->first_name : '' }}</h4>
                      <p>{{ mb_strimwidth($notify->message, 0, 30, '...') }}</p>
                      <p>{{ $notify->created_at->diffForHumans() }}</p>
                  </div>
              </li>
              <li><hr class="dropdown-divider"></li>
              @endforeach
                    <li class="dropdown-footer">
                        <a href="{{ route('tradie.notifications.index') }}">Show all notifications</a>
                    </li>
                </ul>
            </li>
            {{-- Messages --}}
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge edit-profile-color bg-success badge-number">{{ $unread }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                    <li class="dropdown-header">
                        You have {{ $unread }} new messages
                        <a href="/messages" target="_blank"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @foreach($messages as $_message)
                    <li class="message-item">
                        @php
                        $url = url('/').'/images/icons/Profile.svg';
                        $otherUser = $_message->from_id == Auth::user()->id ? $_message->receiver : $_message->sender;
                        if($otherUser->profile_picture && File::exists(public_path($otherUser->profile_picture))){
                            $url = asset($otherUser->profile_picture);
                        }
                        @endphp
                        <a href="{{ route('user', $otherUser->id) }}" target="_blank">
                            <img src="{{ $url }}" alt="" class="rounded-circle profile-image">
                            <div>
                                <h4>{{ $otherUser->first_name }}</h4>
                                <p>{{ $_message->body }}</p>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @endforeach
                    <li class="dropdown-footer"><a href="/messages" target="_blank">Show all messages</a></li>
                </ul>
            </li>
            {{-- Profile --}}
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @php
                    $thumbnail = url('/').'/images/icons/Profile.svg';
                    if(Auth::user()->profile_picture && File::exists(public_path(Auth::user()->profile_picture))){
                        $thumbnail = asset(Auth::user()->profile_picture);
                    }
                    @endphp
                    <img src="{{ $thumbnail }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block bi bi-three-dots ps-2"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h6>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('tradie.profile.index') }}">
                            <i class="bi bi-person"></i><span>My Profile</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/contact" target="_blank">
                            <i class="bi bi-question-circle"></i><span>Need Help?</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"
                            onclick="event.preventDefault(); document.getElementById('tradie-logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i><span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
