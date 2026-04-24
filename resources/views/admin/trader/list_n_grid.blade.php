@extends('admin.layouts.master')
@php 
use App\Models\User;
@endphp
@section('title','Tradies')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title">
        <h2 class="desktop-content"><i class="traders-black"></i>Tradies</h2>
        <div class="middle-title job-middle-title">
        
        </div>
        <h2 class="mobile-content"><i class="traders-black"></i>Tradies</h2>
        <div class="right-title  me-0"> </div>        
    </div>
    <div class="d-flex justify-content-end pb-2">
    <div class="page-view">
          
          <a href="{{request()->fullUrlWithQuery(['mode' => 'list'])}}"><i class="fa fa-list  @if(!request()->mode || request()->mode=='list') view-active @else  @endif"></i></a>
          <a href="{{request()->fullUrlWithQuery(['mode' => 'grid'])}}"><i class="fa fa-th-large @if(request()->mode=='grid') view-active @endif"></i></a>
      </div> &nbsp;  | &nbsp; <span id="job_count">Showing <span id="trader_count_value">{{$traders->total()}}</span> Tradies Results</span>
   
</div>
@if(!request()->mode || request()->mode=='list')
    <div class="skill-table-heading ps-4">   
        <div class="sort-btns ms-auto">
            @if(User::ROLE['admin'])
                 <a href="#" class="tradertab primary-btn white-button features-tradies" data-status="0">Featured Tradies</a>
                <input type="hidden" name="trader_status" id="trader_status" value="0">
            @endif
            <button class="primary-btn white-grey-btn"> 
            <i class="bi person-gear"></i>
                <select class="no-border" id="filter_skill">
                    <option value="-1">Skill Category</option>
                    @foreach($skill_categories as $_cat)
                        <option value="{{ $_cat->id}}">{{ $_cat->name }}</option>
                    @endforeach
                </select>
            </button>
            <button class="primary-btn white-grey-btn"> 
                <i class="bi bi-star"></i> 
                <select class="no-border" id="select_rating">
                    <option value="-1">Rating</option>
                    <option value="1">1 star</option>
                    <option value="2">2 star</option>
                    <option value="3">3 star</option>
                    <option value="4">4 star</option>
                    <option value="5">5 star</option>
                </select> 
            </button>
            <button class="primary-btn white-grey-btn"> 
                <i class="bi bi-flag-fill"></i> 
                <select class="no-border" id="select_reports">
                    <option value="-1">Reports</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </button>
            <button class="primary-btn white-grey-btn"> 
                <i  class="bi bi-award"></i> 
                <select class="no-border" id="select_badge">
                    <option value="-1">Badge</option>
                    @foreach ($badges as $badge)
                        <option value="{{ $badge->id}}">{{ $badge->name }}</option>
                    @endforeach
                </select>
            </button>
        </div>
    <div class="table-responsive-lg">
              <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list job_completed" id="ajax_table">
                  <thead>
                      <tr>
                          <!-- <th><input type="checkbox" id="selectAll"></th> -->
                          <th>Select</th>
                          <th></th>
                          <th>Name</th>
                          <th>Skill Category</th>
                          <th>Job Completed</th>
                          <th>Location</th>
                          <th>Created On</th>
                          <th>Badge</th> 
                          <th>Rating</th>                          
                          <th>Actions</th>
                      </tr>
                  </thead>
              </table>
          </div>
     
@else
	<div class="row">
	    @foreach($traders as $_trader)
	        <div class="col-md-6 col-lg-4 col-xl-3">
	            <div class="job-listing">
	                <div class="d-flex justify-content-between align-items-start">
	                    <div>
	                        <h3>{{ ucfirst(($_trader->agency_name)?$_trader->agency_name:$_trader->first_name) }} {{ ucfirst(($_trader->agency_name)?'':$_trader->last_name) }}</h3>
	                        <p>Job Completed - <b>{{ ($_trader->no_of_jobs)?$_trader->no_of_jobs:'10'}}</b></p>
	                    </div>
                            @php               
                                if($_trader->profile_picture && (File::exists(public_path($_trader->profile_picture)))){
                                    $thumbnail = asset($_trader->profile_picture);
                                }else{
                                    $thumbnail = url('/').'/images/company-name.png';
                                }  
                                if($_trader->badge){
                                    $class = 'skill-yellow-warning';
                                        if($_trader->badge->name == 'Experience' || $_trader->badge->name == 'experience'){
                                            $class = 'skill-activate';
                                        }elseif($_trader->badge->name == 'Intermediate' || $_trader->badge->name == 'intermediate'){
                                            $class = 'skill-deactivate skill-grey-warninng';
                                        }elseif($_trader->badge->name == 'Expert' || $_trader->badge->name == 'expert'){
                                            $class = 'skill-red-warning';
                                        }else{
                                            $class = 'skill-yellow-warning';
                                        }
                                        $badge = '<a class="'.$class.'">'.$_trader->badge->name.'</a>';
                                }else{
                                    $badge = '<a class="skill-activate">Experience</a>';
                                }                         
                            @endphp
	                    <img title="job logo" src="{{$thumbnail}}" height="50px" class="profile-image" />
	                </div>
	                <div class="amount"></div>
	                <p>Skill - <b>{{ ($_trader->skillCategory)?$_trader->skillCategory->name:'NA'}}</b></p>
                    <p>Badge - <b>{{ ($_trader->badge)?$_trader->badge->name:'Experience'}}</b></p>
	                <div class="address">
	                    <img src="../images/icons/address.png" />{{ ucfirst($_trader->address) }}
	                </div>
	                <p class="job-rating">Rating - &nbsp;
                    <input class="rating trader-rating"  max="5"  step="0.05" style="--fill:orange;--value:{{$_trader->over_all_rating??0}}" type="range" value="{{$_trader->over_all_rating??0}}">
	                </p>
	                <hr />
	                <div class="d-flex justify-content-between align-items-center view-detail">
                    @if($_trader->status == 1)
                        <button type="button" class="btn btn-icon btn-sm btn-color-dark decline-{{$_trader->id}}" onclick="activateRecord({{$_trader->id}},{{$_trader->status}})">
                        <i class="skill-table-action bi bi-x-lg {{($_trader->status == 0? 'd-none' : '')}}" id="close" ></i>
                            <!-- <i class="fas fa-check"></i> -->
                        </button>
                        <button type="button" class="btn btn-icon btn-sm btn-color-dark approve-{{$_trader->id}} d-none" onclick="activateRecord({{$_trader->id}},0)">
                        <i class="skill-table-action bi bi-check skill-tooltip" id="check"></i>
                        <!-- <i class="fas fa-window-close"></i> -->
                        </button>
                        @else
                        <button type="button" class="btn btn-icon btn-sm btn-color-dark approve-{{$_trader->id}}" onclick="activateRecord({{$_trader->id}},{{$_trader->status}})">
                        <i class="skill-table-action bi bi-check skill-tooltip {{($_trader->status == 1? 'd-none' : '')}}" id="check"></i>
                        <!-- <i class="fas fa-window-close"></i> -->
                        </button>
                        <button type="button" class="btn btn-icon btn-sm btn-color-dark decline-{{$_trader->id}} d-none" onclick="activateRecord({{$_trader->id}},1)">
                        <i class="skill-table-action bi bi-x-lg" id="close" ></i>
                            <!-- <i class="fas fa-check"></i> -->
                        </button>
                        @endif
                        
                    
	                <a href="{{ route('trader.show',$_trader->id) }}"><i class="bi bi-arrow-down-right-circle-fill"></i></a>
	                </div>
	            </div>
	        </div>
	    @endforeach
    </div>       
    <div class="row">
        <div class="skill-table-pagintion grid-pagintion  d-flex">
            {{ $traders->links() }}
        </div>         
    </div>
@endif     
</div>
@endsection
@section('script')
<script type="text/javascript">
$(function(){
    $(".mode_radio").change(function(){
	    $('#form_check').submit();
    });
});
$(document).on('change', '.item-checkbox', function () {
    let itemId = $(this).data('id');
    let isChecked = $(this).is(':checked') ? 1 : 0;
    $.ajax({
        url: '{{route("checkbox.seen")}}',
        method:'POST',
        data:{
            _token: '{{ csrf_token() }}',
            id: itemId,
            checked: isChecked
        },
        success: function(response){
            console.log(response);
        },
        error: function (xhr){
            Swal.fire("Error!", "Something Went Wrong","error");
        }
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
                var url = "{{ route('trader.changestatus', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    success: function(response) {
                        ajax_table.ajax.reload();
                        if (response.data) {
                            if(status == 1){
                                $('.approve-'+id).removeClass('d-none');
                                $('.decline-'+id).addClass('d-none');                                
                            }else{
                                $('.approve-'+id).addClass('d-none');
                                $('.decline-'+id).removeClass('d-none');
                            }
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
var ajax_table;
$(document).ready(function() {
    ajax_table = $('#ajax_table').on('xhr.dt', function (e, settings, json, xhr) {
         $('#trader_count_value').html('');
        $('#trader_count_value').append(JSON.parse(xhr.responseText).iTotalDisplayRecords); 
    }).DataTable({
        "columnDefs": [
                {"className": "text-center", "targets": [2,3,5,6,7]},
                {"targets": [0,1,9],"orderable": false}
            ],
         language: {
                'paginate': {
                    'previous': '<i class="bi bi-arrow-left"></i>',
                    'next': '<i class="bi bi-arrow-right"></i>'
                }
            },
          processing: true,
          serverSide: true,
          order: [[6, 'desc']],
          ajax: {
            url:"{{route('fetch.traders')}}",
            data: function(data){   
                data.filter_skill  = $('#filter_skill').val();              
                data.over_all_rating  = $('#select_rating').val();              
                data.has_complain  = $('#select_reports').val();              
                data.badge_id  = $('#select_badge').val();  
                data.trader_status = $('#trader_status').val();            
            }
          },
          columns: [
            { data: "checkbox" },        
            { data: "logo" },        
            { data: 'first_name' },
            { data: 'skill_category_id'},
            { data: 'completed_jobs'},
            { data: 'address' },
            { data: 'created_at' },
            { data: 'badge_id' },
            { data: 'over_all_rating'},
            { data: 'buttons' }
        ]
    });
    $('.tradertab').click(function(){    
        if($(this).attr('data-status') == 0){
            $('#trader_status').val(1);
            $(this).attr('data-status', 1);
            $(this).removeClass('white-button').addClass('blue-button');
        } else{
            $('#trader_status').val(0);
            $(this).attr('data-status', 0);
            $('.tradertab').addClass('white-button');
        }
        ajax_table.draw(); 
    });
    $('#filter_skill,#select_rating,#select_reports,#select_badge').change(function(){
      ajax_table.draw();
    });
});
</script>
@endsection