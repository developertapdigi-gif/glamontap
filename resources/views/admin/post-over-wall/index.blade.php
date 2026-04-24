@extends('admin.layouts.master')
@section('title','Post Over Wall')
@section('content')
<div class="container-fluid middle-content dashboard-content">
                <div class="page-title">
                    <h2 class="mobile-hide"><i class="newjob-black"></i>Post Over Wall</h2>
                    
                </div>
                <div class="current-notifications">
                    <h3>   <a href=""><button class="primary-btn blue-button"><i class="bi bi-arrow-clockwise"></i>Refresh</button></h3></a>
                    <ul class="notification-list post_overall_list">
                    @foreach($postwalls as $_postwall)
                        @if($_postwall->type == 1)
                       
                        <li id="delete-{{$_postwall->id}}">
                            <img class="" src="{{($_postwall->job->image)?asset($_postwall->job->image):($_postwall->job->agency->logo?asset($_postwall->job->agency->logo):asset('/images/icons/user.svg'))}}"/>
                            <div>
                                <b>{{ucfirst($_postwall->job->agency->agency_name)}} Agency posted a job opening for {{$_postwall->job->number_of_employees}} {{$_postwall->job->skill_category>0 ? $_postwall->job->SkillCategory->name : ''}} with experience range from {{$_postwall->job->badge->minimum_range}} to {{$_postwall->job->badge->maximum_range}} years.</b>
                                <p> {{$_postwall->job->location}}</p>
                                <p>
                                @if(date('Y-m-d') == Carbon\Carbon::parse($_postwall->created_at)->format('Y-m-d'))
                                Today
                                @elseif(round(floor(floor((strtotime(now())-strtotime($_postwall->created_at)) / 60) / 60) / 24) > 0)
                                {{$days = round(floor(floor((strtotime(now())-strtotime($_postwall->created_at)) / 60) / 60) / 24)}} {{($days == 1)?"day":"days"}} ago
                                @endif    
                            </p>
                            </div> 
                            <div class="not-time">
                            <a href="{{route('job.show',$_postwall->job_id)}}"><button class="blue-border-btn primary-btn"><i class="bi bi-eye-fill"></i>View</button></a>
                                @if($_postwall->status == 2)
                                <button class="grey-border-btn primary-btn" onclick="changeStatus({{$_postwall->id}},{{$_postwall->status}})"><i class="bi bi-ban bi-bold"></i>Blocked</button>
                                @else
                                
                                @endif
                                
                                <button class="blue-border-btn primary-btn" onclick="deleteRecord({{$_postwall->id}})"><i class="bi-trash3-fill"></i>Delete</button>
                            </div>   
                        </li>
                    @else
                    @if(count($_postwall->post->endorsements))
                        @php 
                        if(count($_postwall->post->endorsements)>1){
                            $count = count($_postwall->post->endorsements) - 1;
                        }else{
                            $count = 0;
                        }
                        @endphp
                                
                                <li id="delete-{{$_postwall->id}}">
                                <img class="" src="{{($_postwall->post->author->profile_picture)?asset($_postwall->post->author->profile_picture):asset('/images/person1.png')}}"/>
                                <div>
                                <b>{{($_postwall->post->author)?($_postwall->post->author->first_name??''):''}} {{$_postwall->post->author->last_name??''}} sent a endorsement request to {{$_postwall->post->endorsements[0]->agency->agency_name?$_postwall->post->endorsements[0]->agency->agency_name:($_postwall->post->endorsements[0]->agency->first_name??'')}} {{$count?'and '. $count.' others':''}}. Please review and consider his request. Thank you!</b>
                                <p> {{$_postwall->post->location}}</p>
                                <p>
                                @if(date('Y-m-d') == Carbon\Carbon::parse($_postwall->created_at)->format('Y-m-d'))
                                Today
                                @elseif(round(floor(floor((strtotime(now())-strtotime($_postwall->created_at)) / 60) / 60) / 24) > 0)
                                {{$days = round(floor(floor((strtotime(now())-strtotime($_postwall->created_at)) / 60) / 60) / 24)}} {{($days == 1)?"day":"days"}} ago
                                @endif    
                            </p>
                                </div>
                                <div class="not-time">
                            <a href="{{route('post-over-wall.show',$_postwall->post->id)}}"><button class="blue-border-btn primary-btn"><i class="bi bi-eye-fill"></i>View</button></a>
                            
                                <button class="blue-border-btn primary-btn" onclick="deleteRecord({{$_postwall->id}})"><i class="bi-trash3-fill"></i>Delete</button>
                            </div>
                               
                                @else
                                <li id="delete-{{$_postwall->id}}">
                            <img class="" src="{{($_postwall->post->author->profile_picture)?asset($_postwall->post->author->profile_picture):asset('/images/person1.png')}}"/>
                            <div>
                                <b>{{($_postwall->post->author)?($_postwall->post->author->first_name??''):''}} added showcasing his skills on his post wall. Please take a look!</b>
                                <p> {{$_postwall->post->location}}</p>
                                <p>
                                @if(date('Y-m-d') == Carbon\Carbon::parse($_postwall->created_at)->format('Y-m-d'))
                                Today
                                @elseif(round(floor(floor((strtotime(now())-strtotime($_postwall->created_at)) / 60) / 60) / 24) > 0)
                                {{$days = round(floor(floor((strtotime(now())-strtotime($_postwall->created_at)) / 60) / 60) / 24)}} {{($days == 1)?"day":"days"}} ago
                                @endif    
                            </p>
                            </div> 
                            <div class="not-time">
                            <a href="{{route('post-over-wall.show',$_postwall->post->id)}}"><button class="blue-border-btn primary-btn"><i class="bi bi-eye-fill"></i>View</button></a>
                            
                                
                                <button class="blue-border-btn primary-btn" onclick="deleteRecord({{$_postwall->id}})"><i class="bi-trash3-fill"></i>Delete</button>
                            </div>   
                        </li>
                        @endif
                    @endif
                        
                        @endforeach
                       
                    </ul>  
                </div>
                
                <div class="row">
            <div class="skill-table-pagintion grid-pagintion  d-flex">
                {{ $postwalls->links() }}
            </div>         
    </div>               
          
                </div> 
@endsection
@section('script')
<script type="text/javascript">

function deleteRecord(id) {
    if (id) {
        Swal.fire({
            text: "{{ __('Are you sure you want to delete ?') }}",
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, Delete!",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('post-over-wall.destroy', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "DELETE",
                    success: function(response) {
                        $('#delete-'+id).remove();
                        //ajax_table.ajax.reload();
                        //console.log(('#delete-'+id))
                        if (response.data) {
                            Swal.fire("Done!", "Deleted Successfully.", "success");
                           
                        } else {
                            Swal.fire("Error Deleting!", "This row cannot be deleted",
                                "error");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error Deleting!", "Error, Please Try Again", "error");
                    }
                });
            }
        });
    }
}


function changeStatus(id,status){
    if(id){
    if(status == 1 || status == 0){
        popMessage = "Do you want to block this account?";
    }else{
        popMessage = "Do you want to unblock this account?";
    }
        Swal.fire({
            text:  popMessage,
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, Change!",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('post-over-wall.changestatus', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    success: function(response) {
                        location.reload();
                        if (response.data) {
                            Swal.fire("Done!", "Changed Successfully.", "success");
                        } else {
                            Swal.fire("Error!", "This row cannot be changed",
                                "error");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error!", "Error, Please Try Again", "error");
                    }
                });
            }
        });
    }
}
</script>
@endsection
