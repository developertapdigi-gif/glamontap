@extends('website.layouts.master')
@section('title')
Search Details
@endsection
@section('content')
@php
use App\Models\Setting;
$model = Setting::setting();
$trader = $trader ?? null;
$job = $job ?? null;
@endphp
<br>
<div class="service-section-margin job-detailpage">
  @if($text == 1)
  <div class="container service-section-margin service-detail">
    <div class="row">
      <div class="col-xl-8 col-lg-7 col-12">
        @php
        if($job->image && (File::exists(public_path($job->image)))){
        $thumbnail = asset($job->image);
        }else{
        $thumbnail = "https://cdn.prod.website-files.com/6390e14cc734a931f8327343/679c74b3164f379f7f08c8f3_679c74441827c33928d93627_Inner-image.jpeg";
        }
        @endphp
        <img src="{{$thumbnail}}" width="100%">
        <div class="job-description mt-5">
          <h2>Job Title</h2>
          <p>{{ucfirst($job->title)}}
          </p>
        </div>
        @if($job->note)
        <div class="job-description mt-5">
          <h2>Job Description</h2>
          <p>{{$job->note}}
          </p>
        </div>
        @endif
        <div class="job-description">
          <h2>Skill & Experience</h2>
          <ul>
            <li>
              Skill Category : {{$job->skill?$job->skill->name:"NA"}}
            </li>
            <li>
              Experience : {{$job->badge?$job->badge->name ." (".$job->badge->minimum_range ." to ".$job->badge->maximum_range ."years)" : "NA"}}
            </li>

          </ul>
        </div>
        <hr>
      </div>
      <div class="col-xl-4 col-lg-5 col-12 ps-lg-5 ps-auto">
        <div class="detail-job-result">
          <div class="job-detail-page detail-img align-items-center">
            @if($job->status != 7)
            @php
            if($job->agency->logo && (File::exists(public_path($job->agency->logo )))){
              $thumbnail = asset($job->agency->logo );
            }elseif($job->agency->profile_picture && (File::exists(public_path($job->agency->profile_picture )))){
            $thumbnail = asset($job->agency->profile_picture );
            }else{
            $thumbnail = url('/').'/images/icons/new-profile.svg';
            }
            @endphp
            <img src="https://cdn.prod.website-files.com/6390e14cc734a931f8327343/679c74b3164f379f7f08c8f3_679c74441827c33928d93627_Inner-image.jpeg" width="40" height = "40">
            <div>

              <h4>{{$job->agency->agency_name? $job->agency->agency_name : "NA"}}</h4>
              <span><input class="rating trader-rating trader_star-rating" max="5" step="0.05" style="--fill:orange;--value:{{$job->agency->over_all_rating??0}}" type="range" value="{{$job->agency->over_all_rating??0}}"></span>
            </div>
            @else
            <img src="{{ $model['favicon'] }}" width="40" height = "40">
            <div>

              <h4>{{$job->title}}</h4>
            </div>
            @endif
          </div>
          <h5>{{$job->agency->about_agency}}</h5>
          <div class="applying-job">
            @auth
              @if(Auth::user()->hasRole('trader'))
                @php
                  $alreadyApplied = App\Models\JobApplication::where('task_id', $job->id)
                      ->where('bidder_id', Auth::id())->exists();

                      // Check if the job's skill category matches the tradie's skill category
                $skillMatch = false;
                if (Auth::user()->skill_category_id && $job->skill_category) {
                    $skillMatch = (Auth::user()->skill_category_id == $job->skill_category);
                }
                @endphp
                @if($alreadyApplied)
                  <button class="btn btn-secondary" disabled>Already Applied</button>
                @elseif(in_array($job->status, [1,2]) && $skillMatch)
                  <form action="{{ route('tradie.jobs.apply') }}" method="POST"> 
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    <div class="mb-2">
                      <input type="number" name="bid_amount" class="form-control" placeholder="Enter your bid amount ($)" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Job</button>
                  </form>
                @else
                  <button class="btn btn-secondary" disabled>Job Not Available</button>
                @endif
              @else
                <a class="btn btn-primary" href="{{ route('user.login') }}?redirect={{ urlencode(url()->current()) }}">Apply Job</a>
              @endif
            @else
              <a class="btn btn-primary" href="{{ route('user.login') }}?redirect={{ urlencode(url()->current()) }}">Apply Job</a>
            @endauth
          </div>
          <hr>
          <!-- <div class="job-detail-page">
            <img src="{{ asset('images/job-status.svg') }}" width="26" height="26">
            <div>
              <h4>Job Status</h4>
              <span>{{ ($job->status == 7)?"Approved":$job->getStatusValue($job->status)}}</span>
            </div>
          </div> -->
          <div class="job-detail-page">
            <img src="{{ asset('images/location.svg') }}" width="25" height="25">
            <div>
              <h4>Location</h4>
              <span>{{$job->location}}</span>
            </div>
          </div>
          <div class="job-detail-page">
            <img src="{{ asset('images/salary.svg') }}" width="25" height="25">
            <div>
              <h4>Payment</h4>
              <span>${{$job->minimum_price}} - ${{$job->maximum_price}}</span>
            </div>
          </div>
          <div class="job-detail-page">
            <img src="{{ asset('images/job-start.svg') }}" width="25" height="25">
            <div>
              <h4>Start Date</h4>
              <span>{{date('d M Y',strtotime($job->start_date))}}</span>
            </div>
          </div>
          <div class="job-detail-page">
            <img src="{{ asset('images/job-end.svg') }}" width="25" height="25">
            <div>
              <h4>End date</h4>
              <span>{{date('d M Y',strtotime($job->end_date))}}</span>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="marquee-container marquee-space">
      <div class="row">
        <h3 class="mb-2">Recent jobs</h3>
        @if(count($recent_jobs))
        @foreach($recent_jobs as $_recent_job)
        @php
        if($_recent_job->image && (File::exists(public_path($_recent_job->image)))){
        $thumbnail = asset($_recent_job->image);
        }else{
        $thumbnail = "https://cdn.prod.website-files.com/6390e14cc734a931f8327343/679c74b3164f379f7f08c8f3_679c74441827c33928d93627_Inner-image.jpeg";
        }
        @endphp
        <a href="{{route('get.resultdetail', [$_recent_job->id,$text]) }}" class="col-lg-3 scroll-card search-result job-outer">

          <img src="{{$thumbnail}}" />
          @if($_recent_job->status != 7)
          <div class="job_tag">
            <span>New</span>
          </div>
          @endif
          <div class="job_card">
            <h3>{{$_recent_job->skill?$_recent_job->skill->name:"NA"}}</h3>
             @if($_recent_job->status != 7)
            <h5 class="tradies">{{$_recent_job->agency?$_recent_job->agency->agency_name:"NA"}}</h5>
            @endif
          <h4>${{$_recent_job->minimum_price}} - ${{$_recent_job->maximum_price}}</h4>
          <h5>{{mb_strimwidth($_recent_job->location,0,30,'...')}}</h5>
          </div>
        </a>
        @endforeach
        @else
          <h5>No Result Found</h5>
        @endif

      </div>
    </div>
  </div>
</diV>
@elseif($text == 2)
<div class="container service-section-margin service-detail">
  <div class="row">
    <div class="col-xl-8 col-lg-7 col-12">
      @php
      if($trader->profile_picture && (File::exists(public_path($trader->profile_picture )))){
      $thumbnail = asset($trader->profile_picture );
      }else{
      $thumbnail = url('/').'/images/icons/new-profile.svg';
      }
      @endphp
      
     <!--  <div class="job-description mt-5">
        <h2>{{$trader->first_name . " " . $trader->last_name}}</h2>
        
      </div> -->
      <div class="job-description">
        <h2>Skill & Experience</h2>
        <ul>
          <li>
            Skill Category : {{$trader->skillCategory?$trader->skillCategory->name:"NA"}}
          </li>
          <li>
            Experience : {{$trader->badge?$trader->badge->name ." (".$trader->badge->minimum_range ." to ".$trader->badge->maximum_range ."years)" : "NA"}}
          </li>


        </ul>
      </div>
      <hr>
    </div>
    <div class="col-xl-4 col-lg-5 col-12 ps-lg-5 ps-auto">
      <div class="detail-job-result">
        <div class="job-detail-page">
          <img src="{{$thumbnail}}" width="40" height="40">
          <div>
            <h4>{{$trader->first_name . " " . $trader->last_name}}</h4>
            <span><input class="rating trader-rating trader_star-rating" max="5" step="0.05" style="--fill:orange;--value:{{$trader->over_all_rating??0}}" type="range" value="{{$trader->over_all_rating??0}}"></span>
          </div>
        </div>
        <div class="w-100">
            @auth
              @if(Auth::user()->hasRole('trader') && Auth::id() != ($trader->id ?? null))
                @php
                  $traderId = $trader->id ?? null;
                  $connection = null;
                  if($traderId){
                      $authId = Auth::id();
                      $connection = App\Models\UserConnection::where(function($q) use ($authId, $traderId){
                          $q->where('user_id', $authId)->where('connection_id', $traderId);
                      })->orWhere(function($q) use ($authId, $traderId){
                          $q->where('user_id', $traderId)->where('connection_id', $authId);
                      })->first();
                  }
                @endphp
                @if($connection && $connection->status == 1)
                  <a href="{{ route('user', $traderId) }}" class="btn btn-primary w-100">Message</a>
                @elseif($connection && $connection->status == 0)
                  <button class="btn btn-secondary w-100" disabled>Request Sent</button>
                @else
                  <form action="{{ route('tradie.connections.send') }}" method="POST">
                    @csrf
                    <input type="hidden" name="connection_id" value="{{ $traderId }}">
                    <button type="submit" class="btn btn-primary w-100">Send Friend Request</button>
                  </form>
                @endif
              @elseif(Auth::user()->hasRole('agency') || Auth::user()->hasRole('agency_sub_user'))
                <a href="{{ route('user', $trader->id ?? '') }}" class="btn btn-primary w-100 mb-2">Message</a>
                <a href="{{ route('job.index') }}" class="btn btn-success w-100">Hire for a Job</a>
              @elseif(!Auth::check())
                <a class="btn btn-primary w-100" href="{{ route('user.login') }}?redirect={{ urlencode(url()->current()) }}">Connect</a>
              @endif
            @else
              <a class="btn btn-primary w-100" href="{{ route('user.login') }}?redirect={{ urlencode(url()->current()) }}">Connect</a>
            @endauth
        </div>
        <hr>
        <div class="job-detail-page">
          <img src="{{ asset('images/location.svg') }}" width="25" height="25">
          <!--  <h5>{{$trader->address}}</h5> -->
         <div>
            @php 
              $split = explode(',',$trader->address);
            @endphp  
            @foreach($split as $_split)
              <h5>{{$_split}}</h5>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="marquee-container marquee-space">
    <div class="row">
      <h3 class="mb-3">Posts</h3>
      @if($trader->posts && $trader->posts->count())
        @foreach($trader->posts as $post)
        @php
          $media = $post->gallery->first();
          $postThumb = "https://cdn.prod.website-files.com/6390e14cc734a931f8327343/679c74b3164f379f7f08c8f3_679c74441827c33928d93627_Inner-image.jpeg";
          if($media && File::exists(public_path($media->path))){
            $postThumb = asset($media->path);
          }
        @endphp
        <div class="col-lg-4 col-md-6 col-12 mb-4">
          <a href="{{ route('get.trader.post.detail', $post->id) }}" class="scroll-card search-result d-block" style="text-decoration:none;color:inherit">
            @if($media && $media->type == 2)
              <video src="{{ $postThumb }}" class="img-fluid" style="width:100%;height:200px;object-fit:cover"></video>
            @else
              <img src="{{ $postThumb }}" style="width:100%;height:200px;object-fit:cover">
            @endif
            <div class="job_card">
              <h3>{{ $post->title }}</h3>
              <p>{{ mb_strimwidth($post->short_description, 0, 80, '...') }}</p>
              <small class="text-muted">{{ $post->created_at->format('d M Y') }}</small>
            </div>
          </a>
        </div>
        @endforeach
      @else
        <p class="text-muted">No posts yet.</p>
      @endif
    </div>
  </div>
  <div class="marquee-container marquee-space">
    <div class="row">
      <h3 class="mb-4">Similar Tradies</h3>
      @if(count($recent_jobs))
        @foreach($recent_jobs as $_recent_job)
          @php
          if($_recent_job->profile_picture && (File::exists(public_path($_recent_job->profile_picture)))){
          $thumbnail = asset($_recent_job->profile_picture);
          }else{
          $thumbnail = "https://cdn.prod.website-files.com/6390e14cc734a931f8327343/679c74b3164f379f7f08c8f3_679c74441827c33928d93627_Inner-image.jpeg";
          }
          @endphp
          <div class ="col-md-3">
        <a href="{{route('get.resultdetail', [$_recent_job->id,$text]) }}" class="scroll-card search-result job-outer">

          <img src="{{$thumbnail}}" />
          <!-- <div class="job_tag">
            <span>New</span>
          </div> -->
          <div class="job_card post-content">
            <h3 class="post-title">{{$_recent_job->first_name ." ". $_recent_job->last_name}}</h3>
            <p class="post-excerpt">{{Str::limit($_recent_job->address,30)}}</p>
          </div>
        </a>
          </div>
        @endforeach
      @else
        <h5>No Result Found</h5>
      @endif

    </div>
  </div>
</div>
    </div>
  @endif


  <section class="about-blue-footer about_skilled_trades mt-3" id="linksection">
    <div class="container">
      <div class="row about-blue-footer-right">
        <div class="col-xl-5 col-lg-4  col-md-0">
          <div class="abt-img-box">
            <img class="abt-mob-img" src="{{url('/')}}/images/psd-images/mobile1.webp" />
            <img class="abt-arrow-img" src="{{url('/')}}/images/psd-images/roll-arrow.png" />
          </div>
        </div>
        <div class="col-xl-7 col-lg-8 col-md-12 abt-blue-desc">
          <h3>Connecting Skilled trades of Australia to their Community</h3>
          <p>We encourage diversity in hiring of women and underrepresented groups </p>


          <div class="d-flex mt-lg-5 mt-4 about-download">
            <a href="#">
              <div class="applestore whitestore social-media-banners d-flex me-3 me-xs-0 mb-xs-3">
                <i class="bi bi-apple blue-icn"></i>
                <div>
                  <p>Download on the</p>
                  <b>Apple Store</b>
                </div>
              </div>

            </a>

            <a href="#">
              <div class="googlestore social-media-banners d-flex">
                <i class="bi bi-google-play white-icn"></i>
                <div>
                  <p>Get it on</p>
                  <b>Google Play</b>
                </div>
              </div>

            </a>

            <!--<a href="#"><img class="me-3 mb-2 social-media-banner" src="../images/googleplay-btn.svg"></a>-->

          </div>
        </div>
      </div>
    </div>

  </section>

  @endsection