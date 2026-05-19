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


