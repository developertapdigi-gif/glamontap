@extends('admin.layouts.master')
@section('title')
 Post Detail
@endsection
@section('content')

<div class="container-fluid middle-content dashboard-content">
                <div class="page-title">
                <h2 class="mobile-hide all_post"><img src="{{(asset('/images/icons/svg/view-post.svg'))}}"> Post Detail</h2>
                    
                </div>
                <div class="post-job">
                    <div class="row white-background">
                        <div class="col-md-12 col-lg-7 border-right">
                            <div class="row">
                                <div class="col-md-12 col-lg-5 border-right company-detail">
                                @php   
                                    if($model->author->profile_picture){
                                        $thumbnail = asset($model->author->profile_picture);
                                    }else{
                                        $thumbnail = asset('/images/icons/user.svg');
                                    }                       
                                @endphp
                                    <img class="m-auto" src="{{$thumbnail}}" />
                                    <h4>{{$model->author->first_name}}</h4>
                                    <p><i class="bi bi-geo-alt-fill me-1"></i>{{$model->author->address}}</p>
                                    
                                </div>
                                <div class="col-md-12 col-lg-7 company-detail-1">
                                    <h4> Detail</h4>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <b>Post Title</b>
                                        <p>{{ $model->title }}</p>
                                    </div>
                                    
                                </div>
                                @if($model->location)
                                <div class="row mt-3">
                                    
                                    <div class="col-md-12">
                                    <b>Post Address</b>
                                    <p>{{$model->location}}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-5 job-desc">
                            <h4> Post Description</h4>
                            <p>{{$model->content}}</p>
                        </div>
                    </div>
                    <div class="row white-background">

   <!-- Slides with indicators -->
    <div class="row" style="margin: 10px 0px;
    border-top: 1px #f2f3f8 solid;
    padding: 20px 0px;">
    
        <div class="col-md-8 mx-auto">
            <div class="row bg-white border border-neutral-200 rounded-lg lg:rounded-2xl p-4 mb-8 image_size">
                
                        @foreach($model->gallery as $_gallery)
                            <div class="col-lg-3 col-md-4 col-sm-4">
                                <div class="spacer">
                                    @if($_gallery->type == 2)
                                        <a href="{{asset($_gallery->path)}}" data-fancybox="video-gallery"><img alt="" width="100%" src="{{asset('/images/play-button.png')}}"></a>
                                        
                                    @else
                                    <a href="{{asset($_gallery->path)}}" data-fancybox="video-gallery"><img alt="" width="100%" src="{{asset($_gallery->path)}}"></a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    
            </div>
        </div>
    
               
     </div>
</div>
@endsection
@section('script')
<style>
    .spacer {   
    margin: 20px 5px;
}
</style>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
/>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
      Fancybox.bind('[data-fancybox]', {
        // Custom options
      });    
    </script>

@endsection