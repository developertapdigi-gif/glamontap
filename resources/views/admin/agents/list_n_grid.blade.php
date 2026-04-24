@extends('admin.layouts.master')
@section('title','Sub Users')
@php 
use Illuminate\Support\Facades\Auth;
use App\Models\User;
$usertype = Auth::user()->user_type;
$userrole = User::ROLE['agency'];
@endphp
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title">
        <h2 class="desktop-content"><i class="traders-black"></i>Sub Users</h2>
        <div class="middle-title job-middle-title">
        <input type="hidden" id="usertype" name="usertype" value="{{$usertype}}">
        <input type="hidden" id="role" name="role" value="{{$userrole}}">
        </div>
        <h2 class="mobile-content"><i class="traders-black"></i>Sub Users</h2>
        @if(Auth::user()->user_type == User::ROLE['agency'])
        <div class="right-title  me-0">
        <a href="{{ route('agent.create') }}" class="btn-primary">
                <i class="bi bi-plus-lg"></i>New Sub User
            </a>
            
        </div>
        @endif
        
    </div>
        <div class="d-flex justify-content-end pb-2">
        <div class="page-view">
          
        </div> <span id="job_count">&nbsp; Showing <span id="agent_count_value"> {{$agents->total()}}</span> Sub Users Results </span>
            
        </div>
   
@if(!request()->mode || request()->mode=='list')
    <div class="skill-table-heading ps-4">Sub Users</div>
    <div class="table-responsive-lg">
        <table class="table skill-table-list job_completed" id="ajax_table">
            <thead>
                <tr>
                <th>SR no.</th>
                    <th></th>
                    
                    <th>Name</th>
                    <th>Location</th>
                    <th>Company</th>
                    <th>Created On</th>
                    <th>Email Address</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            
        </table>
    </div>
@else
	<div class="row">
	    @foreach($agents as $_agent)
	        <div class="col-md-6 col-lg-4 col-xl-3">
	            <div class="job-listing">
	                <div class="d-flex justify-content-between align-items-start">
	                    <div>
	                        <h3>{{ ucfirst(($_agent->agency_name)?$_agent->agency_name:$_agent->first_name) }}</h3>
	                        <p>Job Completed - <b>{{ ($_agent->no_of_jobs)?$_agent->no_of_jobs:'10'}}</b></p>
	                    </div>
                        @php               
                           if($_agent->logo && (File::exists(public_path($_agent->logo)))){
                              $thumbnail = asset($_agent->logo);
                           }else{
                              $thumbnail = url('/').'/images/company-name.png';
                           }                           
                        @endphp
	                    <img title="job logo" src="{{$thumbnail}}" height="50px" class="profile-image"/>
	                </div>
	                <div class="amount"></div>
	                <p>Skill - <b>{{ ($_agent->hired_employees)?$_agent->hired_employees:'Painter'}}</b></p>
                    <p>Badge - <b>{{ ($_agent->hired_employees)?$_agent->hired_employees:'Experience'}}</b></p>
	                <div class="address">
	                    <img src="../images/icons/address.png" />{{ ucfirst($_agent->address) }}
	                </div>
	                <p class="job-rating">Rating - &nbsp;
	                    <div id="full-stars-example" class="d-inline-block">
	                        <div class="rating-group">
	                            <label aria-label="1 star" class="rating__label" for="rating-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>          
	                            <label aria-label="2 stars" class="rating__label" for="rating-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>           
	                            <label aria-label="3 stars" class="rating__label" for="rating-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>       
	                            <label aria-label="4 stars" class="rating__label" for="rating-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>        
	                            <label aria-label="5 stars" class="rating__label" for="rating-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
	                        </div>
	                    </div>
	                </p>
	                <hr />
	                <div class="d-flex justify-content-between align-items-center view-detail">
                    @if($_agent->status == 1)
	                    <button type="button" class="btn btn-icon btn-sm btn-color-dark decline-{{$_agent->id}}" onclick="activateRecord({{$_agent->id}},{{$_agent->status}})">
                       
                        <i class="skill-table-action bi bi-x-lg"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm btn-color-dark approve-{{$_agent->id}} d-none" onclick="activateRecord({{$_agent->id}},0)">
                       
                        <i class="skill-table-action bi bi-check skill-tooltip"></i>
                        </button>
                        @else
                        <button type="button" class="btn btn-icon btn-sm btn-color-dark approve-{{$_agent->id}}" onclick="activateRecord({{$_agent->id}},{{$_agent->status}})">
                       
                        <i class="skill-table-action bi bi-check skill-tooltip"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm btn-color-dark decline-{{$_agent->id}} d-none" onclick="activateRecord({{$_agent->id}},1)">
                       
                        <i class="skill-table-action bi bi-x-lg"></i>
                        </button>
                        @endif
                        
                    
	                <a href="{{ route('agent.show',$_agent->id) }}"><i class="bi bi-arrow-down-right-circle-fill"></i></a>
	                </div>
	            </div>
	        </div>
	    @endforeach
    </div>       
    <div class="row">
        <div class="col-auto">
            {{ $agents->links() }}
        </div>         
    </div>
@endif     
</div>
@endsection
@section('script')
<script type="text/javascript">
    var ajax_table;
$(document).ready(function() {
    ajax_table = $('#ajax_table').on('xhr.dt', function (e, settings, json, xhr) {
         $('#agent_count_value').html('');
        $('#agent_count_value').append(JSON.parse(xhr.responseText).iTotalDisplayRecords); 
    }).DataTable({
        "columnDefs": [
                {"className": "text-center", "targets": [6,7]},
                {"targets": [1,6,8],"orderable": false},
                //{"className":"d-none", "targets": [1]},
            ],
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
            url:"{{route('fetch.agents')}}",
            data: function(data){   
                data.filter_skill  = $('#filter_skill').val();              
            }
          },
          columns: [
            { data: 'id' },
            { data: "logo" },
            
            { data: 'first_name' },
            { data: 'address' },
            { data: 'agency_id' },
            
            { data: 'created_at' },
            { data: 'email' },          
            { data: 'status' },
            { data: 'buttons' }
        ]
    });
    ajax_table.column( 0 ).visible( false );
    $('#filter_skill').change(function(){
      ajax_table.draw();
    });
    if($('#usertype').val() == $('#role').val()){
    ajax_table.column(4 ).visible( false );
}
});

$(function(){
    $(".mode_radio").change(function(){
	    $('#form_check').submit();
    });
});
function activateRecord(id,status){
    if(id){
    if(status == 1){
        popMessage = "Do you want to block this account?";
    }else{
        popMessage = "Do you want to approve this account?";
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
                $('.loader').show();
                var url = "{{ route('agent.changestatus', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    success: function(response) {
                        if(status == 1){
                                $('.approve-'+id).removeClass('d-none');
                                $('.decline-'+id).addClass('d-none');                                
                            }else{
                                $('.approve-'+id).addClass('d-none');
                                $('.decline-'+id).removeClass('d-none');
                            }
                            $('.loader').hide();
                        ajax_table.ajax.reload();
                        if (response.data) {
                            Swal.fire("Done!", "Changed Successfully.", "success");
                        } else {
                            Swal.fire("Error!", "This row cannot be chnaged",
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
                $('.loader').show();
                var url = "{{ route('agent.destroy', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "DELETE",
                    success: function(response) {
                        $('.loader').hide();
                        ajax_table.ajax.reload();
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
</script>
@endsection