@extends('admin.layouts.master')
@section('title','Endorsement Post')
@section('content')
<div class="container-fluid middle-content dashboard-content">
                <div class="page-title">
                    <h2 class="mobile-hide"><i class="endorsments-black"></i>Endorsement Post</h2>
                    
                </div>
                <div class="current-notifications">
                    <h3>   <a href=""><button class="primary-btn blue-button"><i class="bi bi-arrow-clockwise"></i>Refresh</button></h3></a>
                    <ul class="notification-list post_overall_list">
                    @foreach($endrosementposts as $_postendrose)
                        <li id="delete-{{$_postendrose->id}}">
                            <img class="" src="{{($_postendrose->post->author->profile_picture)?asset($_postendrose->post->author->profile_picture):asset('/images/icons/user.svg')}}"/>
                            <div>                               
                                 <b>{{$_postendrose->post->author->first_name}} {{$_postendrose->post->author->last_name}} sent a endorsement request to {{ ucwords(Auth::user()->agency_name ?? Auth::user()->first_name)}}. Please review the request. Thank you!</b>
                                <p> {{$_postendrose->post->location}}</p>
                                <p>
                                @if(date('Y-m-d') == Carbon\Carbon::parse($_postendrose->post->updated_at)->format('Y-m-d'))
                                Today
                                @elseif(round(floor(floor((strtotime(now())-strtotime($_postendrose->post->updated_at)) / 60) / 60) / 24) > 0)
                                {{$days = round(floor(floor((strtotime(now())-strtotime($_postendrose->post->updated_at)) / 60) / 60) / 24)}} {{($days == 1)?"day":"days"}} ago
                                @endif    
                            </p>
                            </div> 
                            <div class="not-time comment-buttons endorsement_posts">
                            <a href="{{route('endrosement-post.show',$_postendrose->post_id)}}"><button class="blue-border-btn primary-btn"><i class="bi bi-eye-fill"></i>View</button></a>
                                @if($_postendrose->like && $_postendrose->like->user_id == Auth::user()->id)
                                    @if($_postendrose->like->endorsement_id == $_postendrose->id)
                                    <form method="POST" action="{{ route('endrosement-post.destroy', $_postendrose->id) }}">
                                    @csrf
                                    @method("DELETE")
                                    <button class="blue-border-btn primary-btn"><i class="bi bi bi-hand-thumbs-up-fill" type="submit"></i>Like</button>
                                    </form>
                                    
                                    @endif
                                    @else
                                    <a href="{{route('like-endorse',$_postendrose->id)}}"><button class="grey-border-btn primary-btn"><i class="bi bi bi-hand-thumbs-up"></i>Like</button></a>
                                @endif
                                
                                <a href="{{Route('comment',$_postendrose->post_id)}}"><button class="grey-border-btn primary-btn"><i class="bi  bi-chat-fill"></i>Comment </button></a>
                                
                            </div>   
                        </li>
                        @endforeach
                       
                    </ul>  
                </div>
                
                                 
          
                </div> 
@endsection
