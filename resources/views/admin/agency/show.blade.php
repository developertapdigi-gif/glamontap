@extends('admin.layouts.master')

@section('title')
    {{ $model->first_name }} {{ $model->last_name }}
@endsection
@section('content')
@php   
use App\Models\User;            
    if($model->logo && (File::exists(public_path($model->logo)))){
        $thumbnail = asset($model->logo);
    }else{
        $thumbnail = url('/').'/images/company-name.png';
    }                           
@endphp
<div class="container-fluid middle-content dashboard-content">
<input type="hidden" name="agency_id" id="agency_id" value="{{$model->id}}">
                <div class="page-title">
                    <h2 class="desktop-content"><i class="profile-black"></i>Company Profile</h2>

                    <h2 class="mobile-content"><i class="profile-black"></i>Company Profile</h2>
                    <div class="right-title me-0">
                        <a href="{{route('agency.edit',$model->id)}}"><button class="primary-btn blue-button"><i class="bi bi-eye bi bi-pencil-square"></i>Edit Company Profile</button></a>

                    </div>
                </div>
                <div class="post-job">
                    <div class="row ">
                        <div class="col-lg-3 col-md-3">
                            <div class="border-right company-detail profile-detail">
                           
                                <img src="{{ $thumbnail}}" />
                                <h4>{{$model->first_name}}</h4>
                               <!--  <p><a href="#">{{ 'Construction Company' }}</a></p> -->
                                <div class="row">
                                    <div class="col-md-12 mt-5  mb-4 d-flex center-align">
                                        <i class="bi bi-geo-alt-fill me-1 border-icon "></i> {{$model->address}}
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    @if($model->mobile)
                                    <div class="col-md-12  mt-4  mb-3 d-flex center-align"><i class="bi bi-telephone-fill me-1 border-icon "></i> {{$model->mobile}}</div>
                                    @endif
                                    <div class="col-md-12  mt-4  mb-4 d-flex center-align"><i class="bi bi-envelope-fill me-1 border-icon "></i>{{ $model->email }}</div>
                                </div>
                                <div class="skill-sub-footer-icons company-social-icons mt-5">
                                    @if($model->facebook_url)
                                    <p class="blue-circle facebook-icn me-2">
                                        <a href="{{$model->facebook_url }}" target="_blank"><i class="bi bi-only-facebook"></i></a>
                                    </p>
                                    @endif
                                    @if($model->twitter_url)
                                    <p class="twitter-icn me-2">
                                        <a href="{{$model->twitter_url}}" target="_blank"><i class="bi bi-only-twitter"></i></a>
                                    </p>
                                    @endif
                                    @if($model->linkedin_url)
                                    <p class="linkdin-icn">
                                       <a href="{{$model->linkedin_url}}" target="_blank"><i class="bi bi-only-linkdin"></i></a>
                                        
                                    </p>
                                    @endif
                                </div>
                            </div>


                           
                        </div>


                    <div class="col-md-9">
                        <div class="row profile-detail-desc white-background">
                            <div class="col-md-6 white-background">
                                <div class="company-detail-1 profile-detail-1 border-right">
                                    <h4> Info</h4>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-4">
                                            <b>First Name</b>
                                            <p>{{$model->first_name}}</p>
                                        </div>
                                        <div class="col-md-6 col-sm-4">
                                            <b>Last Name</b>
                                            <p>{{$model->last_name}}</p>
                                        </div>
                                        <!-- <div class="col-md-4 col-sm-4">
                                            <b>Address</b>
                                            <p>{{$model->address}}</p>
                                        </div> -->
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <b>Address</b>
                                            <p>{{$model->address}}</p>
                                        </div>
                                        
                                    </div>
                                    <div class="row mt-3 no-border">
                                        
                                        <div class="col-md-4 col-sm-4">
                                        <b>ACN Details</b>
                                        <p>{{$model->abn_acn}}</p>
                                        </div>
                             
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-6 job-desc ">
                                <h4> About Company</h4>
                                <p>{{$model->about_agency}}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-lg-7 col-xl-8 ps-md-0 ps-lg-0 mt-3 pe-0">
                                <div class="table-responsive dashboard-table">

                                    <div class="table-title">
                                        <b> Recent Job Posts</b>
                                        <a class = "ms-auto" href="{{route('job.index')}}"><button class="transparent-button">View All</button></a>
                                    </div>
                                    <table class="table skill-table-list" id="ajax_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Job Name</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                   
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-5 col-xl-4 mt-3 pe-md-0 pe-lg-0">
                                <div class="dashboard-listing">
                                    <div class="listing-title">
                                        <b>Completed Jobs</b>
                                        <a class = "ms-auto" href="{{route('job.index',['type' => 'Completed'])}}"><button class="transparent-button">View All</button></a>
                                    </div>
                                    @foreach($completedJobs as $_completed)
                                    <div class="listing-item list_items clearfix">
                                    <i class="tick-check tick_checking"><img  src="{{asset('images/icons/tick.jpg')}}" alt=""></i>
                                        <div style="width:100%">
                                            <h4><a href="{{ route('job.show',$_completed->id) }}">{{$_completed->title}}</a></h4>
                                            <p>{{$_completed->location}}</p>
                                        </div>
                                    </div>
                                    @endforeach 
                                    @php
                                    $text = '';
                                    if($completedJobs->total() == 0)
                                    $text = 'No Result Found';
                                    @endphp   
                                    <p class="no-result">{{$text}}</p>

                                </div>
                            </div>
                        </div>
                        @if(count($complaint))
                        <div class="row" id = "report_complaint">
                                <div class="col-md-12 col-lg-12 col-xl-12 p-0">
                                    <div class="dashboard-listing report_complaint">
                                        <div class="clearfix">
                                           <h5> Report </h5>
                                            <table>
                                            <thead>
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Description</th>                                                
                                                </tr>
                                            </thead>
                                                <tbody>
                                                @foreach($complaint as $_complaint)
                                                    <tr>
                                                        <td>{{$_complaint->reported_by?(User::find($_complaint->reported_by)->first_name):"NA"}}</td>
                                                        <td>{{date('d-m-Y',strtotime($_complaint->created_at))}}</td>
                                                        <td>{{$_complaint->comment}}</td>
                                                    </tr>
                                                    @endforeach
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
    @endif
                    </div>
                </div>
          
</div>   

@endsection
@section('script')
<script type="text/javascript">
     var ajax_table;
    $(document).ready(function() {
        ajax_table = $('#ajax_table').DataTable({
            "bLengthChange" : false, //thought this line could hide the LengthMenu
            searching: false,    
             language: {
                'paginate': {
                    'previous': '<i class="bi bi-arrow-left"></i>',
                    'next': '<i class="bi bi-arrow-right"></i>'
                }
            },
              processing: true,
              serverSide: true,            
              order: [[0, 'desc']],
              ajax: {
                url:"{{route('fetch.recentagencyjobs')}}",
                data: function(data){                
                data.agency_id  = $('#agency_id').val();                    
            }
              },
              columns: [         
            { data: 'title' },
            { data: 'start_date' },
            { data: 'location' },
            { data: 'status'},   
            ],
            columnDefs: [          
            //{ "searchable": false, targets: [1,2,3] },
            { "orderable": false, "targets": [1,2,3] }
        ],
    }); 
    
      
});


</script>
@endsection