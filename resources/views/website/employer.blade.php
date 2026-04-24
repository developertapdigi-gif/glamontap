@extends('website.layouts.master-employer')
@section('title')
Home
@endsection
@section('content')
  </div>
  <div class = "container text-center empower-tools employer-tradies">
    <h2 class = "mid-title dream-job pt-md-5 pt-4">Connect with verified professionals in seconds</h2>
    <form id="createform" class="regular-form search-form" action="{{ route('searchform') }}" method="get">
      <div class = "row justify-content-center">
        <div class ="col-xxl-8 col-xl-9 col-lg-10 col-12 search-outside">
          <div class ="input-group job-search">
            <div class="search_iconbar"> 
              <i class="bi bi-search"></i>
            <input type = "search" class = "form-control search-jobs search-field" placeholder = "Look up professionals near you" name="search_input">
            </div>
            <input type = "search" class = "form-control search-field location-select" placeholder = "Location" name="search_location">
          </div>
            <input type="hidden" id="radio-two" name="search_type" value="2" />
          <button type = "button " class ="btn search-btn">Search</button>
        </div>
      </div>
    </form>
  </div>


  <section class="latest-section" id="latest-posts">
    <div class="section-header">
        <h2>company</h2>
    </div>
    
    <div class="posts-grid">
        @forelse($company as $com)
        <article class="post-card">
            @if($com->profile_picture )
            <div class="post-image">
                <img src="{{ asset($com->profile_picture) }}" alt="{{ $com->first_name }}">

            </div>
             @else
                <img src="{{ asset('uploads/profile/69df4100a8acd_WhatsApp Image 2026-02-09 at 1.12.43 PM.jpeg') }}" alt="{{ $com->first_name }}">
            @endif
            
            <div class="post-content">
                
                 <h3 class="post-title">
                        {{ $com->first_name }}{{ $com->last_name }}
                </h3>
                
                <p class="post-excerpt">{{ Str::limit($com->address ?? $com->address, 150) }}</p>
            </div>
        </article>
        @empty
        <div class="no-posts">
            <i class="fas fa-newspaper"></i>
            <p>No company found. Check back later!</p>
        </div>
        @endforelse
    </div>
  
    </section>
  

@if(count($traders))
<div class ="container-fluid sliderdiv activeclass" id="trader-home">
    <div class = "marquee-container marquee-space swiper">
      <div class="marquee-track marquee-left swiper-wrapper job-card-1">
        
        @foreach($traders as $_trader)
        
        @php   
          if($_trader->profile_picture && (File::exists(public_path($_trader->profile_picture)))){
            $thumbnail = asset($_trader->profile_picture);
          }else{
            $thumbnail =  asset('images/tradiies-job-default.webp');
          }                                                  
              
        @endphp
        <a class = "job-outer swiper-slide" href ="{{route('get.resultdetail', [$_trader->id,2]) }}">
          <div class ="scroll-card">
            <img src="{{$thumbnail}}" />
          <div class = "job_tag">
            <span>{{$_trader->skill_category_id?$_trader->skillCategory->name:''}}</span>
          </div> 
          <div class = "job_card">
            <h3>{{$_trader->first_name . " " . $_trader->last_name}}</h3>
            <!-- <h5 class = "tradies">agency1</h5> -->
            <!-- <h4>${{$_trader->minimum_price}} - ${{$_trader->maximum_price}}</h4> -->
            <h5>{{$_trader->address}}</h5> 
            <!-- <h5>{{mb_strimwidth($_trader->address,0,30,'...')}}</h5> -->
            <h5>{{$_trader->badge?$_trader->badge->name:''}}</h5>
          </div>
        </div>
        </a>
        @endforeach
       

      </div>
    </div>
</div>
 @endif
  

 <section class="slider-section empower-tools skilled-tradepeople">
    <div class = "trade-people-slider">
    <h2 class="mid-title">
    Discover a seamless way to connect with verified household service providers.
    </h2>
    <p class="slider-sub-detail">Hire cleaners, maintenance pros, and repair specialists quickly and manage all your bookings in one place.</p>
</div>
    <div class="container-fluid text-center my-3 slider-home"> 

        <section class="center_slider slider">
          <div>
            <!-- <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
              <source src="{{ asset('images/dashboard.mp4') }}" type="video/mp4">
          </video> -->
          <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
            <source src="https://thecoverhouse.com/images/dashboard.mp4" type="video/mp4">
          </video>
          </div>
          <div>
            <!-- <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
              <source src="{{ asset('images/job.mp4') }}" type="video/mp4">
          </video> -->
          <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
            <source src="https://thecoverhouse.com/images/job.mp4" type="video/mp4">
          </video>
          </div>
          <div>
            <!-- <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
              <source src="{{ asset('images/message.mp4') }}" type="video/mp4">
          </video> -->
          <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
            <source src="https://thecoverhouse.com/images/message.mp4" type="video/mp4">
          </video>
          </div>
          <div>
            <!-- <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
              <source src="{{ asset('images/subscription.mp4') }}" type="video/mp4">
          </video> -->
          <video preload="auto" class="video-control" muted playsinline webkit-playsinline>
            <source src="https://thecoverhouse.com/images/subscription.mp4" type="video/mp4">
          </video>
          </div>
        </section>

      </div>
    </div>

  </section>


  <!-- Latest Posts Section -->
  <section class="latest-section" id="latest-posts">
    <div class="section-header">
        <h2>Posts</h2>
        <p>Stay updated with our newest content</p>
    </div>
    
    <div class="posts-grid">
        @forelse($posts as $post)
        <article class="post-card">
            @if($post->thumb_url)
            <div class="post-image">
                <img src="{{ asset($post->thumb_url) }}" alt="{{ $post->title }}">
            </div>
            @endif
            
            <div class="post-content">
                <div class="post-meta">
                    <span class="post-date">
                        <i class="far fa-calendar"></i> 
                        {{ $post->created_at ? $post->created_at->format('M d, Y') : $post->published_at->format('M d, Y') }}
                    </span>
                    <span class="post-author">
                        <i class="far fa-user"></i> 
                        {{ $post->author->first_name ?? 'Unknown Author' }}
                    </span>
                    <span class="post-views">
                        <i class="far fa-eye"></i> 
                        {{ number_format($post->views) }} views
                    </span>
                </div>
                
                 <h3 class="post-title">
                    <a href="{{ route('post.show', $post->id) }}" onclick="addView({{ $post->id }})">
                        {{ $post->title }}
                    </a>
                </h3>
                
                <p class="post-excerpt">{{ Str::limit($post->content ?? $post->content, 150) }}</p>
                
                <div class="post-footer">
                    <a href="{{ route('post.show', $post->id) }}" onclick="addView({{ $post->id }})" class="btn-read-more">
                        Read Article <i class="fas fa-arrow-right"></i>
                    </a>
                        
                  <button onclick="reactPost({{ $post->id }}, 1)" class="btn-action like-btn">
                      👍 <span id="like-{{ $post->id }}">{{ $post->likes_count ?? 0 }}</span>
                  </button>

                  <button onclick="reactPost({{ $post->id }}, 2)" class="btn-action dislike-btn">
                      👎 <span id="dislike-{{ $post->id }}">{{ $post->dislikes_count ?? 0 }}</span>
                  </button>

                </div>
            </div>
        </article>
        @empty
        <div class="no-posts">
            <i class="fas fa-newspaper"></i>
            <p>No posts found. Check back later!</p>
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    {{-- <div class="pagination-wrapper">
        {{ $posts->links() }}
    </div> --}}
    </section>
      

      <section class="blue-footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-9 col-md-8 col-8">
            <h3>Experience the full power of CoverHouse with a 14-day free trial—</h3>
            <p>all features included, with zero cost.</p>
        </div>
        <div class="col-xl-3 col-md-4 col-4 start-trial">
         <a href="{{ route('user.register') }}"> <button class="skill-primary-btn white-btn strt-now"><text>Start Now </text><p class="blue-circle post-btn"><img
                src="../images/icons/start-now.png" /></p></button></a>

        </div>
      </div>
    </div>

  </section>
    <div class="mid-content grey-background service-plans">
            <section class="skill-subscriptions"> 
                <h4>Find skilled home-service professionals faster and manage tasks smarter.</h4>
                <p>Upgrade your plan to access top-rated helpers, streamline job management, and get more done with ease.</p>
                <div class = "plans">
                <button class="subscription-btn blue-button" id="monthly">Monthly</button>
                <button class="subscription-btn white-btn" id="yearly">Annually</button>
                </div>
                <div class="row equal-height-row  
                d-flex flex-wrap">
                @foreach($plans as $_plan)
                    <div class="col-lg-4 col-md-6">
                        <div class="sub-service">
                            <div class="title"><i class="fas {{$_plan->class_name}}-tag"></i>
                                <h3>{{$_plan->name}}</h3>
                            </div>
                            <div class="package-detail {{$_plan->class_name}}-plan-detail">
                            {!! $_plan->description !!}
                            </div>

                            <div class="package-bottom-detail {{$_plan->class_name}}-plan-desc">
                                <b id="monthly_price" class="">${{$_plan->monthly_price}}</b>
                                <b id="yearly_price" class="d-none">${{$_plan->yearly_price}}</b>
                                    @if($_plan->name == 'Basic Plan Features' || $_plan->name == 'starter plan')
                                    <p class=""><small>Unlock all {{$_plan->name}} for 12 months and save with our annual discount.</small></p>
                                    @elseif($_plan->name == 'Pro Plan Features' || $_plan->name == 'growth plan')
                                    <p class=""><small>Unlock all {{$_plan->name}} for 12 months and save with our annual discount.</small></p>
                                    @elseif($_plan->name == 'Premium Plan Features' || $_plan->name == 'premium plan')
                                    <p class=""><small>Unlock all {{$_plan->name}} for 12 months and save with our annual discount.</small></p>
                                    @endif
                               <a href="/subscription"><button class="btn-primary">Choose Plan</button></a>

                            </div>

                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </section>
    </div>

  @endsection
  @section('script')
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
let mySwiper = null;
let lastSlideIndex = 0;
let lastWindowWidth = window.innerWidth;
let lastOrientation = window.orientation || 0;
let slidesCloned = false;

/* ---------- CACHE ELEMENTS (PERFORMANCE) ---------- */
const activeSliders = document.querySelectorAll('.activeclass');

/* ---------- COUNT SLIDES ---------- */
function countVisibleSlides() {
  let total = 0;
  activeSliders.forEach(slider => {
    total += slider.querySelectorAll('.swiper-slide').length;
  });
  return total;
}

/* ---------- IOS CHECK ---------- */
function isIOS() {
  return /iPad|iPhone|iPod/.test(navigator.userAgent);
}

/* ---------- CLONE ONLY ONE TIME ---------- */
function cloneSlides(){
  if(slidesCloned) return;

  const wrappers = [...activeSliders].map(s =>
    s.querySelector('.swiper-wrapper')
  );

  wrappers.forEach(wrapper=>{
    if(!wrapper) return;
    const children=[...wrapper.children];
    children.forEach(el=>wrapper.appendChild(el.cloneNode(true)));
  });

  slidesCloned = true;
}

/* ---------- INIT SWIPER ---------- */
function initSwiper(initialIndex=0){

  const totalSlides = countVisibleSlides();
  if(!totalSlides) return;

  /* avoid unnecessary rebuild */
  if(mySwiper && totalSlides === mySwiper.params.loopedSlides){
    return;
  }

  if(mySwiper){
    try{ lastSlideIndex=mySwiper.realIndex; }catch(e){}
    mySwiper.destroy(true,true);
    mySwiper=null;
  }

  cloneSlides();

  mySwiper = new Swiper(".activeclass .swiper",{
    speed:6000,
    loop:true,
    loopedSlides:totalSlides,
    slidesPerView:"auto",
    allowTouchMove:false,
    simulateTouch:false,
    initialSlide:initialIndex || lastSlideIndex,

    observer:true,
    observeParents:true,

    autoplay:{
      delay:0,
      disableOnInteraction:false,
      pauseOnMouseEnter:false
    }
  });

  mySwiper.on('slideChange',()=>{
    lastSlideIndex=mySwiper.realIndex;
  });
}

/* ---------- SAFE AUTOPLAY ---------- */
function ensureAutoplay(){
  if(mySwiper?.autoplay && !mySwiper.autoplay.running){
    mySwiper.autoplay.start();
  }
}

/* ---------- INIT ---------- */
window.addEventListener("DOMContentLoaded",()=>{
  initSwiper(0);
});

/* ---------- RESIZE (LIGHT) ---------- */
let resizeTimer;
function checkAndReinit(){
  const w=window.innerWidth;
  const o=window.orientation||0;

  if(w!==lastWindowWidth || o!==lastOrientation){
    clearTimeout(resizeTimer);
    resizeTimer=setTimeout(()=>{
      initSwiper(lastSlideIndex);
      lastWindowWidth=w;
      lastOrientation=o;
    },250);
  }
}

window.addEventListener("resize",checkAndReinit,{passive:true});
window.addEventListener("orientationchange",checkAndReinit,{passive:true});

/* ---------- TAB / PAGE RETURN FIX ---------- */
document.addEventListener("visibilitychange",()=>{
  if(document.visibilityState==="visible"){
    if(isIOS()) initSwiper(lastSlideIndex);
    else ensureAutoplay();
  }
});

window.addEventListener("pageshow",()=>{
  setTimeout(()=>ensureAutoplay(),150);
});

/* ---------- BUTTON CODE (OPTIMIZED SELECTORS) ---------- */
$(function(){

  const $monthly = $('#monthly');
  const $yearly = $('#yearly');

  $monthly.click(function(){
    $monthly.removeClass('white-btn').addClass('blue-button');
    $yearly.removeClass('blue-button').addClass('white-btn');
    $('#yearly_price').addClass('d-none');
    $('#monthly_price').removeClass('d-none');
  });

  $yearly.click(function(){
    $yearly.removeClass('white-btn').addClass('blue-button');
    $monthly.removeClass('blue-button').addClass('white-btn');
    $('#yearly_price').removeClass('d-none');
    $('#monthly_price').addClass('d-none');
  });

});

function addView(id) {
    fetch(`/post/${id}/view`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(() => {
        let el = document.getElementById('view-' + id);
        el.innerText = parseInt(el.innerText) + 1;
    });
}
function reactPost(postId, type) {
    fetch(`/post/${postId}/react`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json' // 🔥 VERY IMPORTANT
        },
        body: JSON.stringify({ type: type })
    })
    .then(async res => {

        // If not logged in → Laravel returns 401 or redirect
        if (res.status === 401 || res.redirected) {
            window.location.href = "/login";
            return;
        }

        return res.json();
    })
    .then(data => {
        if (!data) return;

        document.getElementById('like-' + postId).innerText = data.likes;
        document.getElementById('dislike-' + postId).innerText = data.dislikes;
    })
    .catch(err => console.error(err));
}
</script>
@endsection


