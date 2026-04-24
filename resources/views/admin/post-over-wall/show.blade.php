@extends('admin.layouts.master')
@section('title')
 Post Over Wall Detail
@endsection
@section('content')

<div class="container-fluid middle-content dashboard-content">
                <div class="page-title post-wall">
                    <h2 class="desktop-content"><i class="newjob-black"></i>Post Over Wall Detail</h2>

                    <h2 class="mobile-content"><i class="newjob-black"></i>Post Over Wall Detail</h2>
                    
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
                                    <div class="col-md-6 col-sm-6">
                                        <b>Job Address</b>
                                        <p>{{$model->location}}</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    
                                    <div class="col-md-12">
                                    <b>Post Address</b>
                                    <p>{{$model->location}}</p>
                                    </div>
                                </div>
                                
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
    <div class="row" style="margin-top:10px; border-top:1px #f2f3f8 solid; padding-top:20px;">
       
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row bg-white border border-neutral-200 rounded-lg lg:rounded-2xl p-4 mb-8 image_size">
                @foreach($model->gallery as $_gallery)
                    <div data-swg data-swg-page class="col-md-3 gap-4 m-auto mt-2">
                        @php 
                            if($_gallery->type == 2){
                        @endphp
                            <video class="aspect-square object-cover w-full cursor-pointer" width="640" height="360" controls>
                                <source src="{{asset($_gallery->path)}}"  type="video/mp4">
                            </video>
                        @php 
                            }else{
                        @endphp
                            <div data-swg-item >
                                <img  src="{{asset($_gallery->path)}}"  class="aspect-square object-cover w-full cursor-pointer" alt="..."/>
                            </div>
                                               
                        @php
                            }
                        @endphp 
                    </div>
                @endforeach
            </div><!-- End Slides with indicators -->
        </div>
        <div class="col-md-2"></div>        
     </div>
    </div>
@endsection
<script src="{{ asset('js/tailwind.js') }}"></script>