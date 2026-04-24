@extends('admin.layouts.master')
@section('title')
 Job Detail
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2 class="desktop-content"><i class="jobs-black"></i>Job Detail</h2>

        <h2 class="mobile-content"><i class="jobs-black"></i>Job Detail</h2>
        <div class="right-title me-0">
            
        </div>
    </div>
    <div class="post-job">
        <div class="row white-background">
            <div class="col-md-12 col-lg-7 border-right">
                <div class="row">
                    <div class="col-md-12 col-lg-5 border-right company-detail">
                    @php   
                        if($data['image']){
                            $thumbnail = asset($data['image']);
                        }elseif($data['logo'] && (File::exists(public_path($data['logo'])))){
                            $thumbnail = asset($data['logo']);
                        }else{
                            $thumbnail = url('/').'/images/company-name.png';
                        }                       
                    @endphp
                        <img src="{{$thumbnail}}" />
                        <h4>{{$data['agency_name']}}</h4>
                        <p><i class="bi bi-geo-alt-fill me-1"></i>{{$data['address']}}</p>
                        <p><input class="rating left-right-auto"  max="5"  step="0.05" style="--fill:orange;--value:{{$data['over_all_rating']??0}}" type="range" value="{{$data['over_all_rating']??0}}"></p>
                        
                        <div class="skill-sub-footer-icons company-social-icons mt-5">
                        @if($data['facebook'])
                        <p class="blue-circle facebook-icn me-2">
                            <a href="{{$data['facebook'] }}" target="_blank"><i class="bi bi-only-facebook"></i></a>
                        </p>
                        @endif
                        @if($data['twitter'])
                        <p class="twitter-icn">
                            <a href="{{$data['twitter']}}" target="_blank"><i class="bi bi-only-twitter"></i></a>
                        </p>
                        @endif
                        @if($data['linkedin'])
                        <p class="linkdin-icn">
                           <a href="{{$data['linkedin']}}" target="_blank"><i class="bi bi-only-linkdin"></i></a>
                            
                        </p>
                        @endif
                    </div>
                    </div>
                    <div class="col-md-12 col-lg-7 company-detail-1">
                        <h4> Job Detail</h4>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <b>Job Name</b>
                            <p>{{ $data['title'] }}</p>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <b>Job Status</b>
                            <p>{{ $data['status']}}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 col-sm-6">
                            <b>Start Date</b>
                            <p>{{date('d M Y',strtotime($data['start_date']))}}</p>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <b>End Date</b>
                            <p>{{date('d M Y',strtotime($data['end_date']))}}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <b>Address</b>
                            <p>{{ $data['location'] }}</p>
                        </div>
                    </div>
                    <div class="row mt-3 no-border">
                        <div class="col-md-6 col-sm-6">
                            <b>No of employees</b>
                            <p>{{$data['number_of_employees']}}</p>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <b>Payment </b>
                            <p>${{$data['minimum_price']}} - ${{$data['maximum_price']}}</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 job-desc">
                <h4> Job Description</h4>
                <p>{{$data['note']}}</p>
                <div><i class="bi bi-map-fill"></i><a href="http://maps.google.com/maps?q={{urlencode($data['location'])}}" target="_blank"> View Map</a></div>
            </div>
        </div>                    
    </div>
@endsection