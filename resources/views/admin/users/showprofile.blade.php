@extends('admin.layouts.master')
@section('title')
   My Profile
@endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
                <div class="page-title">
                    <h2 class="desktop-content"><i class="profile-black"></i>Profile</h2>

                    <h2 class="mobile-content"><i class="profile-black"></i>Profile</h2>
                    <div class="right-title me-0">
                        <a href="{{route('profile')}}"><button class="primary-btn blue-button"><i class="bi bi-eye bi bi-pencil-square"></i>Edit Profile</button></a>

                    </div>
                </div>
                <div class="post-job">
                    <div class="row ">
                        <div class="col-lg-3 col-md-3">
                            <div class="border-right company-detail profile-detail">
                            @php               
                           if($model->profile_picture && (File::exists(public_path($model->profile_picture)))){
                              $thumbnail = asset($model->profile_picture);
                           }else{
                              $thumbnail = url('/').'/images/company-name.png';
                           }                           
                        @endphp
                                <img src="{{ $thumbnail}}" />
                                <h4>{{$model->first_name}}</h4>
                                <p><a href="#">{{ ($model->user_type == 1)?'Super Admin': 'Agency' }}</a></p>
                                @if($model->address)
                                <div class="row">
                                    <div class="col-md-12 mt-5  mb-4 d-flex center-align">
                                        <i class="bi bi-geo-alt-fill me-1 border-icon "></i> <div class="tradies_profile_text">{{$model->address}}</div>
                                    </div>
                                </div>
                                @endif
                                <div class="row mt-3">
                                    <div class="col-md-12  mt-4  mb-3 d-flex center-align"><i class="bi bi-telephone-fill me-1 border-icon "></i> <div class="tradies_profile_text">{{$model->mobile}}</div></div>
                                    <div class="col-md-12  mt-4  mb-4 d-flex center-align"><i class="bi bi-envelope-fill me-1 border-icon "></i><div class="tradies_profile_text">{{ $model->email }}</div></div>
                                </div>
                                <div class="mt-5 profile_logout">
                                 <a class="primary-btn blue-button mt-5 ms-auto me-auto text-white" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            
                                    <i class="bi bi-box-arrow-left"></i>Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>


                           
                        </div>


                    <div class="col-md-9">
                        <div class="row profile-detail-desc">
                            <div class="col-md-12 white-background">
                                <div class="company-detail-1 profile-detail-1">
                                    <h4> Info</h4>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-4">
                                            <b>First Name</b>
                                            <p>{{$model->first_name}}</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <b>Last Name</b>
                                            <p>{{$model->last_name}}</p>
                                        </div>
                                        @if($model->address)
                                        <div class="col-md-4 col-sm-4">
                                            <b>Address</b>
                                            <p>{{$model->address}}</p>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-lg-7 col-xl-8 ps-md-0 ps-lg-0 mt-3">
                                <div class="table-responsive dashboard-table">

                                    <div class="table-title">
                                        <b> Recent Subscription</b>
                                        <a class = "ms-auto" href="{{ route('subscriber.view',['status'=>'5']) }}" ><button class="transparent-button">View All</button></a>
                                    </div>
                                    <table class="table mb-0 skill-table-list"  id="ajax_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col"></th>
                                                <th scope="col">Agency Name</th>
                                                <th scope="col">Renewal Date</th>
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
                                    <b>New Registered Agencies</b>
                                    <a class = "ms-auto" href="{{ route('agency.index') }}"><button class="transparent-button">View All</button></a>
                                    </div>
                                    @foreach($agencies as $_agency)
                                    @php 
                                    if($_agency->logo && (File::exists(public_path($_agency->logo)))){
                                        $thumbnail = asset($_agency->logo);
                                    }else{
                                        $thumbnail = url('/').'/images/icons/brand-logo3.png';
                                    }
                                    @endphp
                                    <div class="listing-item  clearfix">
                                        <img src="{{ $thumbnail}}" alt="" class="profile-image">
                                        <div>
                                            <h4><a href="#">{{$_agency->agency_name}}</a></h4>
                                            <p>{{$_agency->address}}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    


                                </div>
                            </div>
                        </div>

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
                url:"{{route('showprofile.subscriberlist')}}",
              },
              columns: [         
            { data: 'id' },
            { data: "logo" },
            { data: 'agency_id' },
            { data: 'start_date' },
            { data: 'address' },
            { data: 'status'},   
            ],
            columnDefs: [          
            { "orderable": false, "targets": [1,2,3,4,5] }
        ],
    }); 
    ajax_table.column( 0 ).visible( false );
      
});


</script>
@endsection