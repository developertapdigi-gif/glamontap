@extends('website.layouts.master')
@section('title')
Search Results
@endsection
@section('content')
@php 
$textvalue = $text??'';
$locationsearch = '';
if((isset($_GET['search_input']) && empty($_GET['search_input'])) && (isset($_GET['search_location']) && !empty($_GET['search_location']))){
  $locationsearch = 'for '.$_GET['search_location'];
}elseif(isset($_GET['search_location']) && !empty($_GET['search_location'])){
  $locationsearch = 'in '.$_GET['search_location'];
}
if($textvalue == 1){
$placeholder = "Look up jobs near you";
}elseif($textvalue == 2){
$placeholder = "Look up tradies near you";
}else{
$placeholder = "";
}
@endphp


<div class="top-content banner-outer">
  <!-- <div class="row skill-title text-center">
    <h1>
      Search Results
    </h1>


    <ul class="skill-breadcrumbs d-flex justify-content-center">
      <li><a href='/'>Home</a> <i class="bi bi-arrow-right"></i></li>
      <li>Search Results</li>
    </ul>
  </div> -->
  <div class="container text-center search-result1">
    <form id="createform" class="regular-form search-form" action="{{ route('searchform') }}" method="get">
      <div class = "row justify-content-center">
        <div class ="col-xxl-8 col-xl-9 col-lg-10 col-12 search-outside search-rslt-pg">
          <div class ="input-group job-search">
            <div class="search_iconbar"> 
              <i class="bi bi-search"></i>
            <input type = "search" class = "form-control search-jobs search-field" placeholder = "{{$placeholder}}" name="search_input" value="{{$_GET['search_input']??''}}">
            </div>
            <input type = "search" class = "form-control search-field location-select" placeholder = "location" name="search_location"  value="{{$_GET['search_location']??''}}">
          </div>
              <input type="hidden" id="radio-one" name="search_type" value="{{$text}}"/>
            
          <button type = "button " class ="btn search-btn">Search</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="container job-detailpage">
  <h3 class="job-search-result">Search results {{(isset($_GET['search_input'])&& !empty($_GET['search_input'])) ? 'for '.$_GET['search_input']:''}} {{$locationsearch}}</h3>
  
  @if($results->total() > 0)
    <div class="marquee-container pt-0 pb-0">
      <div class="row">
        @foreach($results as $item)
          @php
          $thumbnail = "https://cdn.prod.website-files.com/6390e14cc734a931f8327343/679c74b3164f379f7f08c8f3_679c74441827c33928d93627_Inner-image.jpeg";
          $textvalue = $text;
          if($item->type === "job"){
            $textvalue = 1;
            if($item->image && (File::exists(public_path($item->image)))){
            $thumbnail = asset($item->image);
            }
          }elseif($item->type === "trader"){
            $textvalue = 2;
            if($item->profile_picture && (File::exists(public_path($item->profile_picture)))){
              $thumbnail = asset($item->profile_picture);
            }
          }else{
            if($item->image && (File::exists(public_path($item->image)))){
            $thumbnail = asset($item->image);
            }elseif($item->profile_picture && (File::exists(public_path($item->profile_picture)))){
              $thumbnail = asset($item->profile_picture);
            }else{
            $thumbnail = "https://cdn.prod.website-files.com/6390e14cc734a931f8327343/679c74b3164f379f7f08c8f3_679c74441827c33928d93627_Inner-image.jpeg";
            }
          }
          
      @endphp
          <a href="{{ route('get.resultdetail', [$item->id, $textvalue]) }}" 
             class="col-xl-3 col-lg-4 col-md-6 col-12 scroll-card search-result job-outer">
            <img src="{{ $thumbnail }}">
            @if($item->type != 'trader' && $textvalue == 2)
            <div class="job_tag"><span>{{$item->skillCategory?$item->skillCategory->name:''}}</span></div>
            @endif
            @if($item->type === 'job' && $item->status != 7)
              <!-- <div class="job_tag"><span>New</span></div> -->
            @elseif($item->type === 'job')
            <!-- <div class="job_tag"><span>Job</span></div> -->
             @elseif($item->type === 'trader')
             <div class="job_tag"><span>{{$item->skill_category}}</span></div>
            @endif
            
            <div class="job_card">
              <h3>
                @if($item->type === 'job')
                {{$item->title}}
                @elseif($item->type === 'trader')
                {{$item->name}}
                @else
                {{ $text == 1 ? $item->title : $item->first_name. ' ' . $item->last_name }}
                <h4>{{ $text == 1 ?('$'.$item->minimum_price. ' - $' . $item->maximum_price) : '' }}</h4>
                
                @endif</h3>
                @if($item->type === 'job' && empty($text))
                <h4>{{ $item->price_range }}</h4>
                @endif
              @if($text === 1)
                @if( $item->status != 7)
                  <h5 class="tradies">{{ $item->agency->agency_name }}</h5>
                  @endif
                <h4>${{ $item->minimum_price }} - ${{ $item->maximum_price }}</h4>
              @endif
              
              <h5>{{  $text == 1?(Str::limit($item->location, 30)) : (Str::limit($item->location, 30)) }}</h5>
              <h5>{{  $text == 2?(Str::limit($item->address, 30)) :''}}</h5>
              @if($text == 1)
              @else
                <h5>{{$text == 2 ? ($item->badge->name ?? '') : ($item->badge ?? '')}}</h5>
              @endif
              
            </div>
          </a>
        @endforeach
      </div>
    </div>
    
    <!-- Pagination -->
    <div class="container mt-4">
      <div class="row">
        <div class="col-12 col-md-12">
          <div class="pagination__row search-pagination">
            {{ $results->onEachSide(5)->withQueryString()->links() }}
          </div>
        </div>
      </div>
    </div>
  @else
    <div class="no-result-found">No results found "{{isset($_GET['search_input']) ? $_GET['search_input']:''}} {{$locationsearch}}"</div>
    <div class="marquee-container pt-0 pb-0">
      <div class="row">
        @if($merged)
          @foreach ($merged as $item)
            @php
              $thumbnail = "https://cdn.prod.website-files.com/6390e14cc734a931f8327343/679c74b3164f379f7f08c8f3_679c74441827c33928d93627_Inner-image.jpeg";
              if($item->type === "job"){
                $textvalue = 1;
                if($item->image && (File::exists(public_path($item->image)))){
                $thumbnail = asset($item->image);
                }
              }elseif($item->type === "trader"){
                $textvalue = 2;
                if($item->profile_picture && (File::exists(public_path($item->profile_picture)))){
                  $thumbnail = asset($item->profile_picture);
                }
              }else{
                if($item->image && (File::exists(public_path($item->image)))){
                $thumbnail = asset($item->image);
                }elseif($item->profile_picture && (File::exists(public_path($item->profile_picture)))){
                  $thumbnail = asset($item->profile_picture);
                }else{
                $thumbnail = "https://cdn.prod.website-files.com/6390e14cc734a931f8327343/679c74b3164f379f7f08c8f3_679c74441827c33928d93627_Inner-image.jpeg";
                }
              }
            @endphp
            <a href="{{ route('get.resultdetail', [$item->id, $textvalue]) }}" 
             class="col-xl-3 col-lg-4 col-md-6 col-12 scroll-card search-result job-outer">
            <img src="{{ $thumbnail }}">
            
            @if($item->type === 'trader')
             <div class="job_tag"><span>{{$item->skill_category}}</span></div>
            @endif
            @if($text == 2)
            <div class="job_tag"><span>{{$item->skillCategory?$item->skillCategory->name:''}}</span></div>
            @endif
            <div class="job_card">
              <h3>
                @if($item->type === 'job')
                {{$item->title}}
                @elseif($item->type === 'trader')
                {{$item->name}}
                @else
                {{ $text == 1 ? $item->title : $item->first_name. ' ' . $item->last_name }}
                <h4>{{ $text == 1 ?('$'.$item->minimum_price. ' - $' . $item->maximum_price) : '' }}</h4>
                
                @endif</h3>
                @if($item->type === 'job' && empty($text))
                <h4>{{ $item->price_range }}</h4>
                @endif
              @if($text === 1)
                @if( $item->status != 7)
                  <h5 class="tradies">{{ $item->agency->agency_name }}</h5>
                  @endif
                <h4>${{ $item->minimum_price }} - ${{ $item->maximum_price }}</h4>
              @endif
              
              <h5>{{  $text == 1?(Str::limit($item->location, 30)) : (Str::limit($item->location, 30)) }}</h5>
              <h5>{{  $text == 2?(Str::limit($item->address, 30)) :''}}</h5>
              
              @if($item->type === 'trader' && $item->rating)
                <div class="rating">
                  @for($i = 1; $i <= 5; $i++)
                    <span class="star {{ $i <= round($item->rating) ? 'filled' : '' }}">★</span>
                  @endfor
                  <!-- <span>({{ number_format($item->rating, 1) }})</span> -->
                </div>
              @endif
            </div>
          </a>
          @endforeach
        @endif
      </div>
    </div>
    @if($merged)
      <div class="container mt-4">
        <div class="row">
          <div class="col-12 col-md-12">
            <div class="pagination__row search-pagination">
              {{ $merged->onEachSide(5)->withQueryString()->links() }}
            </div>
          </div>
        </div>
      </div>
    @endif
  @endif
</div>

<style>
.rating { margin-top: 8px; }
.star { color: #ccc; font-size: 18px; }
.star.filled { color: #ffc107; }
</style>


<section class="about-blue-footer about_skilled_trades mt-3">
  <div class="container">
    <div class="row about-blue-footer-right">
      <div class="col-xl-5 col-lg-4  col-md-0">
        <div class="abt-img-box">
          <img class="abt-mob-img" src="../images/psd-images/mobile1.png" />
          <img class="abt-arrow-img" src="../images/psd-images/roll-arrow.png" />
        </div>
      </div>
      <div class="col-xl-7 col-lg-8 col-md-12 abt-blue-desc">
        <h3>Connecting Skilled trades of Australia to their Community</h3>
        <p>We encourage diversity in hiring of women and underrepresented groups </p>


        <div class="d-flex mt-lg-5 mt-4 about-download">
          <a href="https://apps.apple.com/us/app/tradehook/id6739918480?platform=iphone">
            <div class="applestore whitestore social-media-banners d-flex me-3 me-xs-0 mb-xs-3">
              <i class="bi bi-apple blue-icn"></i>
              <div>
                <p>Download on the</p>
                <b>Apple Store</b>
              </div>
            </div>

          </a>

          <a href="https://play.google.com/store/apps/details?id=au.com.tradehook.tradehookapp">
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
@section('script')
<script type="text/javascript">
  const selectedTypes = document.querySelectorAll('input[name="search_type"]');
  selectedTypes.forEach(selectedType => {
    selectedType.addEventListener('change', () => {
      document.getElementById('createform').submit();
    });
  });
    document.addEventListener("DOMContentLoaded", function () {
    const marqueeTrack = document.querySelector(".marquee-track");
    const jobCount = document.querySelectorAll(".marquee-track .job-outer").length;

    if (jobCount <= 5) {
        marqueeTrack.classList.add("no-scroll");
    }
});
</script>
@endsection