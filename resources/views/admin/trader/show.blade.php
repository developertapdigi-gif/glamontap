@extends('admin.layouts.master')

@section('title')
    {{ ucfirst($model->first_name) }} {{ ucfirst($model->last_name) }}
@endsection
@section('content')
@php   
use Illuminate\Support\Facades\Auth;
use App\Models\User;
$thumbnail = url('/').'/images/company-name.png';
if($model->profile_picture)            
    if($model->profile_picture && (File::exists(public_path($model->profile_picture)))){
        $thumbnail = asset($model->profile_picture);
    }else{
        $thumbnail = url('/').'/images/company-name.png';
    }                           
@endphp
<div class="container-fluid middle-content dashboard-content">
<input type="hidden" name="trader_id" id="trader_id" value="{{$model->id}}">
                <div class="page-title">
                    <h2 class="desktop-content"><i class="profile-black"></i>Tradies Profile</h2>

                    <h2 class="mobile-content"><i class="profile-black"></i>Tradies Profile</h2>
                    <div class="right-title me-0">
                        @if(Auth::user()->user_type == User::ROLE['admin'])
                        <a href="{{route('trader.edit',$model->id)}}"><button class="primary-btn blue-button"><i class="bi bi-eye bi bi-pencil-square"></i>Edit Profile</button></a>
                        @endif
                        @if(isset($application) && $application)
                            @if($application->status != 1)
                            <button class="primary-btn blue-button" onclick="approveEmployee({{$application->id}},{{$application->status}})"><i class="fas fa-check"></i> Hire</button>
                            @endif
                            @if($application->status != 2)
                            <button class="primary-btn blue-button" onclick="rejectEmployee({{$application->id}},{{$application->status}})"><i class="fas fa-ban"></i> Reject</button>
                            @endif
                            <a href="{{ route('user', $model->id) }}" target="_blank" class="primary-btn blue-button"><i class="bi bi-chat"></i> Message</a>
                        @endif
                    </div>
                </div>
                <div class="post-job">
                    <div class="row ">
                        <div class="col-lg-3 col-md-3">
                            <div class="border-right company-detail profile-detail">
                           
                                <img src="{{ $thumbnail}}" />
                                <h4>{{ucfirst($model->first_name).' '.ucfirst($model->last_name)}}</h4>
                               <!--  <p><a href="#">{{ ($model->user_type == 1)?'Super Admin': 'Construction Company' }}</a></p> -->
                                <div class="row">
                                    <div class="col-md-12 mt-5  mb-4 d-flex center-align">
                                        <i class="bi bi-geo-alt-fill me-1 border-icon "></i> <div class="tradies_profile_text">{{($model->address)?$model->address:'NA'}}</div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12  mt-4  mb-3 d-flex center-align"><i class="bi bi-telephone-fill me-1 border-icon "></i> <div class="tradies_profile_text">{{($model->mobile)?$model->mobile:'NA'}}</div> </div>
                                    <div class="col-md-12  mt-4  mb-4 d-flex center-align"><i class="bi bi-envelope-fill me-1 border-icon "></i><div class="tradies_profile_text">{{ ($model->email)?$model->email:'NA' }}</div></div>
                                </div>
                                
                            </div>


                           
                        </div>


                    <div class="col-md-9">
                        <div class="row profile-detail-desc">
                            <div class="col-md-12 white-background">
                                <div class="company-detail-1 profile-detail-1">
                                    <div class=" info_post">
                                        <h4> Info</h4>
                                        <div class="button_details_trader">
                                        <a href="{{route('get.post',$model->id)}}"><button class="primary-btn blue-button"><i class="bi bi-eye"></i>View Post</button></a>
                                        @if($feedback)
                                        <a href="{{route('get.feedback',$model->id)}}"><button class="primary-btn blue-button"><i class="bi bi-person-vcard"></i>Feedback</button></a>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3">
                                            <b>Skill Category</b>
                                            <p>{{($model->skillCategory)?$model->skillCategory->name:'NA'}}</p>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3">
                                            <b>Badge</b>
                                            <p>{{($model->badge)?$model->badge->name:'NA'}}</p>
                                        </div>
                                        {{-- <div class="col-xl-4 col-lg-6 col-md-6 p-auto p-md-0">
                                            <b>ABN (Australian Business number)</b>
                                            <p>{{($model->abn_acn)?$model->abn_acn:'NA'}}</p>
                                        </div> --}}
                                        <div class="col-xl-2 col-lg-3 col-md-3">
                                            <b>Rating</b>                                            
                                            <p><input class="rating trader-rating trader_star-rating"  max="5"  step="0.05" style="--fill:orange;--value:{{$model->over_all_rating??0}}" type="range" value="{{$model->over_all_rating??0}}"></p>
                                            
                                        </div>
                                    <div>
                                    <div class="row certificate_gap">
                                        @if(count($certificates))
                                        <div class="col-md-3 col-sm-4">
                                            <b>Certificates</b>
                                            @foreach($certificates as $key=>$_certificate)
                                            <p></p>
                                            <a href="{{asset($_certificate->path)}}" target="_blank">Certificate {{$key+1}}</a>
                                            @endforeach
                                        </div>
                                        @endif
                                        @if($model->trader_licence)
                                        
                                        <div class="col-md-3 col-sm-4">
                                        <b>Licence</b>
                                        <p></p>
                                        <a href="{{asset($model->trader_licence)}}" target="_blank">Licence</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-lg-7 col-xl-8 ps-md-0 ps-lg-0 mt-3">
                                <div class="table-responsive dashboard-table">

                                    <div class="table-title">
                                        <b> Recent Jobs</b>
                                        <a class = "ms-auto" href="{{route('job.index')}}"><button class="transparent-button">View All</button></a>
                                    </div>
                                    <table class="table skill-table-list" id="ajax_table">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Job Name</th>
                                                <th scope="col">Start Date</th>
                                                <!-- <th scope="col">Location</th> -->
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
                                    @if($_completed['jobTraderCompleted'])
                                        <div class="listing-item list_items  clearfix">
                                        <i class="tick-check tick_checking"><img  src="{{asset('images/icons/tick.jpg')}}" alt=""></i>
                                            <div style="width:100%">
                                                <h4><a href="{{ route('job.show',$_completed['jobTraderCompleted']->id) }}">{{$_completed['jobTraderCompleted']->title}}</a></h4>
                                                <p>{{$_completed['jobTraderCompleted']->location}}</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @endforeach
                                    @php
                                    $text = '';
                                    if(count($completedJobs) == 0)
                                    $text = 'No Result Found';
                                    @endphp   
                                    <p class="no-result">{{$text}}</p>


                                </div>
                            </div>
                        </div>
                        @if(count($complaint) && Auth::user()->user_type == User::ROLE['admin'])
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
                                                        <td>{{$_complaint->trader->first_name??"NA"}}</td>
                                                        <td>{{date('d-m-Y',strtotime($_complaint->created_at))}}</td>
                                                        <td>{{$_complaint->description}}</td>
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
        language: {
                'paginate': {
                    'previous': '<i class="bi bi-arrow-left"></i>',
                    'next': '<i class="bi bi-arrow-right"></i>'
                }
            },
          processing: true,
          serverSide: true,
          searching: false,
          bLengthChange: false,
          order: [[0, 'desc']],
          ajax: {
            url:"{{route('fetch.recentjobs')}}",
            data: function(data){                
                data.trader_id  = $('#trader_id').val();                    
            }
          },
          columns: [   
            { data: 'id' },      
            { data: 'title' },
            { data: 'start_date' },
            { data: 'status' },         
            
        ],
        columnDefs: [          
            //{ "searchable": false, targets: [1,2,3] },
            { "orderable": false, "targets": [1,2,3] }
        ],
    });  
    ajax_table.column( 0 ).visible( false ); 
});

function approveEmployee(id, status) {
    Swal.fire({
        text: 'Are you sure you want to hire this tradie?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, hire!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: { 'X-CSRF-Token': '{{ csrf_token() }}' },
                url: '{{ route("job.approveemployee") }}',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    if (response.status == true) {
                        Swal.fire('Done!', 'Tradie hired successfully.', 'success').then(() => location.reload());
                    }
                }
            });
        }
    });
}

function rejectEmployee(id, status) {
    Swal.fire({
        text: 'Are you sure you want to reject this tradie?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, reject!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: { 'X-CSRF-Token': '{{ csrf_token() }}' },
                url: '{{ route("job.rejectEmployee") }}',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    if (response.status == true) {
                        Swal.fire('Done!', 'Tradie rejected.', 'success').then(() => location.reload());
                    }
                }
            });
        }
    });
}
</script>
@endsection