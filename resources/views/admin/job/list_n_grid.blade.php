@extends('admin.layouts.master')
@php 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
@endphp
@section('title','Jobs')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title">
        <h2 class="desktop-content"><i class="jobs-black"></i>Jobs</h2>
        <div class="middle-title job-middle-title">
            @if(request()->mode=='grid')
                <a href="{{request()->fullUrlWithQuery(['type' => $text[5]])}}" class="jobtab primary-btn @if(request()->type==$text[5] || !request()->type) blue-button @else white-button @endif">{{$text[5]}}</a>
                <a href="{{request()->fullUrlWithQuery(['type' => $text[1]])}}" class="jobtab primary-btn @if(request()->type==$text[1]) blue-button @else white-button @endif ">{{$text[1]}}</a>
                <a href="{{request()->fullUrlWithQuery(['type' => $text[2]])}}" class="jobtab primary-btn @if(request()->type==$text[2]) blue-button @else white-button @endif ">{{$text[2]}}</a> 
                <a href="{{request()->fullUrlWithQuery(['type' => $text[3]])}}" class="jobtab primary-btn @if(request()->type==$text[3]) blue-button  @else white-button @endif">{{$text[3]}}</a>                           
                <a href="{{request()->fullUrlWithQuery(['type' => $text[4]])}}" class="jobtab primary-btn @if(request()->type==$text[4]) blue-button @else white-button @endif">{{$text[4]}}</a>
                @if(User::ROLE['admin'] == Auth::user()->user_type)
                <a href="{{request()->fullUrlWithQuery(['type' => $text[6]])}}" class="jobtab primary-btn @if(request()->type==$text[6]) blue-button @else white-button @endif">{{$text[6]}}</a>
                @endif
         
            @else
                <a href="#" class="jobtab primary-btn blue-button {{$text[5]}}" data-status="{{$text[5]}}">{{$text[5]}}</a>
                <a href="#" class="jobtab primary-btn white-button {{$text[1]}}" data-status="{{$text[1]}}">{{$text[1]}}</a>
                <a href="#" class="jobtab primary-btn white-button {{$text[2]}}" data-status="{{$text[2]}}">{{$text[2]}}</a>
                <a href="#" class="jobtab primary-btn white-button {{$text[3]}}" data-status="{{$text[3]}}">{{$text[3]}}</a>
                <a href="#" class="jobtab primary-btn white-button {{$text[4]}}" data-status="{{$text[4]}}">{{$text[4]}}</a>
                @if(User::ROLE['admin'] == Auth::user()->user_type)
                <a href="#" class="jobtab primary-btn white-button {{$text[6]}}" data-status="{{$text[6]}}">{{$text[6]}}</a>
                @endif
            <input type="hidden" name="job_status" id="job_status" value="$text[5]d">  
            @endif          
        </div>
        <h2 class="mobile-content">
        <i class="jobs-black"></i>Jobs</h2>
        <div class="right-filter job-right-filter">
        
        <div class="page-view">
        
            <a href="{{request()->fullUrlWithQuery(['mode' => 'list'])}}"><i class="fa fa-list  @if(!request()->mode || request()->mode=='list') view-active @else  @endif"></i></a>
            <a href="{{request()->fullUrlWithQuery(['mode' => 'grid'])}}"><i class="fa fa-th-large @if(request()->mode=='grid') view-active @endif"></i></a>
        </div>
            | <span id="job_count">&nbsp; Showing <span id="job_count_value">{{$jobs->total()}}</span> Jobs Results</span>

            
        </div>
    </div>
    @if(request()->mode=='grid')
    <div class="row">
    <form method="GET" action="{{ request()->fullUrl() }}" id="form_grid">
    <input type="hidden" name="type" value="{{request()->type}}">
    <input type="hidden" name="mode" value="grid">
    <div class="form-check filter-block filter-grid search-grid">
        <div class="col-md-3">
	                        <input id="title_search" name="title" class="form-control  @error('title') is-invalid @enderror" type="text" value="{{ request()->title??'' }}" placeholder="Search">
	                    
                        </div>
                        <div class ="col-md-9 d-flex justify-content-end">
                        <div class="skill_filter_category">
                        <i class="bi person-gear filter_icon"></i>
        <select class="no-border" id="filter_skill" name="skill_id">
                        <option value="-1">Skill Category</option>
                        @foreach($skill_categories as $_cat)
                            <option value="{{ $_cat->id}}" @if($_cat->id == request()->skill_id) {{ 'selected' }} @endif>{{ $_cat->name }}</option>
                        @endforeach
                    </select>
                    </div>
                    </div>
                    </div>
    </form>
    </div>
    @endif
@if(!request()->mode || request()->mode=='list')
    <div class="skill-table-heading ps-3 d-flex" id="acc_button">              
        <span>{{$text[5]}}</span>
        <div class="filteroptions">
            <div class="sort-btns ms-auto">
                <button class="primary-btn white-grey-btn"> 
                <i class="bi person-gear"></i>
                    <select class="no-border" id="filter_skill">
                        <option value="-1">Skill Category</option>
                        @foreach($skill_categories as $_cat)
                            <option value="{{ $_cat->id}}">{{ $_cat->name }}</option>
                        @endforeach
                    </select>
                </button>
            </div>
        </div>
    </div>
    <div class="table-responsive-lg">    
        <table class="table skill-table-list job_completed" id="ajax_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Select</th>
                    <th>Job Name</th>
                    <th>Start Date</th> 
                    <th>End Date</th>
                    <th>Location</th>
                    <th class="text-center">Tradies on Job</th>
                    <th class="text-center">Skill Category</th>
                    <th class="text-center">Payment</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>       
        </table>
    </div>      
@else
    
    <div class="row">
        @if(count($jobs) > 0)
        @foreach($jobs as $_job)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="job-listing">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3>{{ ucfirst($_job->title) }}</h3>
                            <p>Start Date - <b>{{ date('d M Y',strtotime($_job->start_date)) }}</b></p>
                            <p>End Date - <b>{{ date('d M Y',strtotime($_job->end_date)) }}</b></p>
                        </div>
                        @php
                        if($_job->image && (File::exists(public_path($_job->image)))){
                            $url = asset($_job->image);
                        }elseif($_job->agency->logo && (File::exists(public_path($_job->agency->logo)))){
                            $url = asset($_job->agency->logo);
                        }else{
                            $url = asset('images/company-name.png');
                        } 
                        @endphp
                        <img title="job logo" src="{{ $url }}" class="profile-image"/>
                    </div>
                    <div class="amount">${{$_job->minimum_price}} - ${{$_job->maximum_price}}</div>
                    <p>No of employees - <b>{{ $_job->number_of_employees}} employess</b></p>
                    <div class="address">
                        <img src="../images/icons/address.png" />{{ ucfirst($_job->location) }}
                    </div>
                    
                    <hr />
                    <div class="d-flex justify-content-between align-items-center view-detail">
                    <div><i class="bi bi-map-fill"></i><a target="_blank" href="https://www.google.com/maps?daddr={{($_job->location)}}"> View Map</a></div>
                    <!-- @if($_job->status < 2)
                        <button type="button" id="aprrove-{{$_job->id}}" class="btn btn-icon btn-lg btn-color-dark" onclick="approveJob({{$_job->id}},{{Auth::user()->user_type}})" data="{{$_job->id}}">
                        <i class="bi bi-check-circle-fill"></i>
                    </button>
                    @endif -->
                    
                    <a href="{{ route('job.show',$_job->id) }}"><i class="bi bi-arrow-down-right-circle-fill"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
        @else
        <div class="">{{ $notfound }}</div>
        @endif
    </div>       
    <div class="row">
        <div class="skill-table-pagintion grid-pagintion  d-flex">
            {{ $jobs->links() }}
        </div>         
    </div>
@endif     
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).on('change', '.item-checkbox', function () {
    let itemId = $(this).data('id');
    let isChecked = $(this).is(':checked') ? 1 : 0;
    $.ajax({
        url: '{{route("job.checkbox.seen")}}',
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
var ajax_table;
var token = "{{ csrf_token() }}";
$(document).ready(function() {
    ajax_table = $('#ajax_table').on('xhr.dt', function (e, settings, json, xhr) {
        settings.json = {
        data: json
    };
    settings.json.recordsTotal = settings.json.recordsFiltered = xhr.getResponseHeader("X-Records-Total");
         $('#job_count_value').html('');
        $('#job_count_value').append(JSON.parse(xhr.responseText).iTotalDisplayRecords); 
    }).DataTable({
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
            url:"{{route('fetch.jobs')}}",
            data: function(data){                
                data.job_status  = $('#job_status').val();              
                data.filter_skill  = $('#filter_skill').val();              
            }
        },
        columns: [          
            { data: 'id' },
            { data: 'checkbox' },
            { data: 'title' },
            { data: 'start_date' },
            { data: 'end_date' },
            { data: 'location' },
            { data: 'number_of_employees' },
            { data: 'skill_category'},         
            { data: 'minimum_price'},         
            { data: 'buttons' }
        ],
        columnDefs: [          
        { className: 'text-center', targets: [5,6,7] },
        {"targets": [1,8],"orderable": false}
        ],
    });  
    ajax_table.column( 0 ).visible( false );  
    $('.jobtab').click(function(){       
        $('#job_status').val($(this).attr('data-status'));
        console.log($('#job_status').val());
        if($('#job_status').val() === 'Completed' || $('#job_status').val() === 'Ongoing'){
             ajax_table.column( 1 ).visible( false );  
        }else{
            ajax_table.column( 1 ).visible( true );  
        }
        $('#acc_button span').empty();
        $('#acc_button span').append($('#job_status').val());
        $('.jobtab').addClass('white-button');
        $(this).removeClass('white-button').addClass('blue-button');
        ajax_table.draw(); 
    });
    $(".mode_radio").change(function(){
        $('#form_check').submit();
    }); 
    const parsedUrl = new URLSearchParams(window.location.search);
if(parsedUrl.has('type')){
    let jobClass = parsedUrl.get('type');
    $(".jobtab."+jobClass).trigger("click");
    $('#job_status').val(parsedUrl.get('type'));
}
});



function approveJob(id, user_type) {
    if (id) {
            var message = "Are you sure you want submit for approval this job?";
        if(user_type == 1)
            var message = "Are you sure you want approve this job?";
        Swal.fire({
            text: message,
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, Approve!",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {
            if (result.isConfirmed) { 
                $('.loader').show();
                $.ajax({
                    url: "{{route('job.approve')}}",
                    type: "POST",
                    data: { id: id, _token: token},
                    success: function(response) {
                        $('.loader').hide();
                        ajax_table.ajax.reload();
                        $("#aprrove-"+id).addClass('d-none');
                        if (response.status=200) {
                            Swal.fire("Done!",response.message, "success");
                        } else {
                            Swal.fire("Error!",response.message,"error");
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
@if(request()->mode=='grid')
<script type="text/javascript">
    $('#filter_skill').change(function(){
        $('#skill_id').val($(this).val());
        $('#form_grid').submit();
    });
    $('#title_search').change(function(){
        $('#form_grid').submit();
    }); 
</script>
@else
<script type="text/javascript">
    $('#filter_skill').change(function(){
      ajax_table.draw();
    });
</script>
@endif
@endsection