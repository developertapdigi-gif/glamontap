@extends('admin.layouts.master')
@section('title')
 Job Detail
@endsection
@php 
use Illuminate\Support\Facades\Auth;
use App\Models\User;
@endphp
@section('content')
<div class="container-fluid middle-content dashboard-content">
                <input type="hidden" name="job_id" id="job_id" value="{{$model->id}}">
                <div class="page-title">
                    <h2 class="desktop-content"><i class="jobs-black"></i>Job Detail</h2>

                    <h2 class="mobile-content"><i class="jobs-black"></i>Job Detail</h2>
                    <div class="right-title me-0">
                        @php
                        $style= "";
                        $endDate = strtotime($model['end_date']);
                        $hrsDiff = ((time()-$endDate) / 60)/60;
                        if(strtotime($model->end_date) >= strtotime(date('Y-m-d'))){
                            $style= "";
                        }else{
                            $style= "pointer-events: none;";
                        }
                        if(Auth::user()->user_type == User::ROLE['agency'] || Auth::user()->user_type== User::ROLE['agency_sub_user'] || Auth::user()->user_type == User::ROLE['admin']){
                        
                        if($model->is_hired == 1 && $model->start_date > $today && $model->status != 3 && $model->status != 6){   
                        @endphp
                        <button class="primary-btn blue-button" onclick="cancelJob({{$model->id}})"><i class="fas fa-times"></i>Cancel Job</button>
                        @php 
                        }
                        if($model->is_hired == 1 && $model->status == 4){
                        $completeDisabled = now()->gt(\Carbon\Carbon::parse($model->end_date)->addHours(48)) ? '' : 'disabled';
                        @endphp
                        <button class="primary-btn blue-button" onclick="if(!this.disabled) completeJob({{$model->id}})" {{ $completeDisabled }} id="completeJobBtn" data-enable-at="{{ \Carbon\Carbon::parse($model->end_date)->addHours(48)->toIso8601String() }}"><i class="fas fa-check"></i>Complete Job</button>
                        @php
                        }
                        if(count($model->applications) < 1){
                        @endphp
                        <a href="{{ route('job.edit',$model->id) }}"><button class="primary-btn blue-button"><i class="fas fa-edit"></i>Edit Job</button></a>
                        @php 
                        }
                    }
                        @endphp
                    </div>
                </div>
                <div class="post-job">
                    <div class="white-background">
                        <div class="row">
                            <div class="col-md-12 col-lg-7 border-right">
                                <div class="row">
                                    <div class="col-md-12 col-lg-5 border-right company-detail">
                                    @php   
                                        if($model->image){
                                            $thumbnail = asset($model->image);
                                        }elseif($model->agency->logo && (File::exists(public_path($model->agency->logo)))){
                                            $thumbnail = asset($model->agency->logo);
                                        }else{
                                            $thumbnail = url('/').'/images/company-name.png';
                                        }                       
                                    @endphp
                                        <img src="{{$thumbnail}}" />
                                        <h4 class="job_agency_name">{{$model->agency->agency_name}}</h4>
                                        <p><i class="bi bi-geo-alt-fill me-1"></i>{{$model->agency->address}}</p>
                                        <p><input class="rating left-right-auto"  max="5"  step="0.05" style="--fill:orange;--value:{{$model->agency->over_all_rating??0}}" type="range" value="{{$model->agency->over_all_rating??0}}"></p>
                                        
                                        <div class="skill-sub-footer-icons company-social-icons mt-5">
                                        @if($model->agency->facebook_url)
                                        <p class="blue-circle facebook-icn me-2">
                                            <a href="{{$model->agency->facebook_url }}" target="_blank"><i class="bi bi-only-facebook"></i></a>
                                        </p>
                                        @endif
                                        @if($model->agency->twitter_url)
                                        <p class="twitter-icn">
                                            <a href="{{$model->agency->twitter_url}}" target="_blank"><i class="bi bi-only-twitter"></i></a>
                                        </p>
                                        @endif
                                        @if($model->agency->linkedin_url)
                                        <p class="linkdin-icn">
                                        <a href="{{$model->agency->linkedin_url}}" target="_blank"><i class="bi bi-only-linkdin"></i></a>
                                            
                                        </p>
                                        @endif
                                    </div>
                                    </div>
                                    <div class="col-md-12 col-lg-7 company-detail-1">
                                        <h4> Job Detail</h4>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <b>Job Name</b>
                                            <p>{{ $model->title }}</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <b>Job Status</b>
                                            <p>{{ $model->getStatusValue($model->status)}}</p>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6 col-sm-6">
                                            <b>Start Date</b>
                                            <p>{{date('d M Y',strtotime($model->start_date))}}</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <b>End Date</b>
                                            <p>{{date('d M Y',strtotime($model->end_date))}}</p>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <b>Location</b>
                                            <p>{{$model->location}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <b>Skill Category</b>
                                            <p>{{$model->SkillCategory?$model->SkillCategory->name:'NA'}}</p>
                                        </div>
                                    </div>
                                    <div class="row mt-3 no-border">
                                        <div class="col-md-6 col-sm-6">
                                            <b>Tradies on Job</b>
                                            <p>{{$model->number_of_employees}}</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <b>Payment </b>
                                            <p>${{$model->minimum_price}} - ${{$model->maximum_price}}</p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-5 job-desc">
                                <h4> Job Description</h4>
                                <p>{{$model->note}}</p>
                                <div><i class="bi bi-map-fill"></i><a href="http://maps.google.com/maps?q={{urlencode($model->location)}}" target="_blank"> View Map</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 job-detail-second-section">
                        <div class="col-md-12 col-lg-7 col-xl-8 mt-3">
                            <div class="table-responsive dashboard-table">

                                <div class="table-title">
                                    <b> <a class="employeetab primary-btn blue-button" data-status="All">All</a><a class="employeetab primary-btn white-button" data-status="Hired">Hirees</a> <a class="employeetab primary-btn white-button" data-status="Applicant">Applicants</a></b>
                                    <input type="hidden" name="employee_status" id="employee_status" value="all"> 
                                    <!-- <button class="transparent-button">View All</button> -->
                                </div>
                                <div class="table-responsive-lg">    
                                    <table class="table skill-table-list" id="ajax_table">
                                        <thead>
                                            <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
                                            <th scope="col">Payment</th>
                                            <th scope="col">Actions</th>
                                            </tr>
                                        </thead>       
                                    </table>
                                </div>      
                                
                                


                            </div>
                        </div>

                        <div class="col-md-12 col-lg-5 col-xl-4 mt-3">
                            <div class="dashboard-listing job-listing pt-0">
                                <div class="listing-title">
                                    <b> Recent Activities</b>
                                    <!-- <button class="transparent-button">View All</button> -->
                                </div>
                                @php 
                                $text = '';
                                if(count($model->notificationAgency)){
                                @endphp 
                                @foreach($model->notificationAgency as $key=>$notify) 
                                @php 
                                    if($key == 0)
                                    $class = 'first-listing blue';
                                    elseif($key == (count($model->notificationAgency)-1))
                                    $class = 'last-item';
                                    else
                                    $class = '';
                                @endphp
                                <div class="listing-item  clearfix {{$class}}">
                                    <img src="../images/icons/brand-logo3.png" alt="">
                                    <div style="width:80%">
                                    <h4 class="job_agency_name"><a href="#">{{$notify->message}}</a></h4>
                                    <!-- <p>40 E 7th St, New York, NY 10003, USA.</p> -->
                                    </div>
                                    <small>{{date('d M',strtotime($notify->created_at))}}</small>
                                  </div>
                                @endforeach
                                @php
                                }else{
                                    $text = 'No Result Found';
                                }
                                @endphp 
                                {{$text}} 
                                
                            </div>
                        </div>
                    </div>
                </div>
                
</div>
@endsection
@section('script')
<link href="{{ asset('css/flatpickr.min.css') }}" rel="stylesheet">
<script src="{{asset('js/flatpickr.js')}}"></script>

<!-- Rating Modals -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="client_popupLabel">Feedback</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <!-- <span aria-hidden="true">&times;</span> -->
            </button>
        </div>
        <div class="modal-body">
            <form id="filter_form">   
                @csrf
                <div class="row">                   
                    <div class="col-md-8 mb-3">                       
                        <div class="input-group">
                        <label for="rating" class="form-label">Rating</label>
                        <input
                        class="rating"
                        max="5"
                        oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)"
                        step="0.5"
                        style="--value:0"
                        type="range"
                        name="rating"
                        id="rating"
                        required
                        > 
                        </div>                    
                    </div> 
                    <input type="hidden" id="userId" />       
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" required>{{ old('comment') }}</textarea>
                        <div class="invalid-feedback" id="commentError"></div>
                    </div>
                </div>
                <div class="row mt-4">    
                    <div class="col-12 text-center">
                        <button type="button" class="btn bg-secondary text-white me-4" data-bs-dismiss="modal" id="filterCloseBtn">Cancel</button>
                        <button type="submit" class="btn bg-primary text-white">Submit</button>
                    </div> 
                </div>
            </form>
        </div>   
        </div>
    </div>
</div>

<!-- Extension Modals -->
<div class="modal fade" id="extensionModal" tabindex="-1" role="dialog" aria-labelledby="extensionModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="client_popupLabel">Extension</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
      <div class="modal-body">
        <form id="extension_form">   
            @csrf
            <div class="row">                   
                <label for="payment" class="form-label">Extension Date</label>
                    <div class="row">
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" placeholder="dd-mm-YYYY" name="end_date" id="end_date"  onfocus="focused(this)" onfocusout="defocused(this)" required>
                                    </div>
                                </div>
                        <input type="hidden" id="applicationId" />       
                    </div>
            </div>
            <div class="row mt-4">    
                <div class="col-12 text-center">
                    <button type="button" class="btn bg-secondary text-white me-4" data-bs-dismiss="modal" id="filterCloseBtn">Cancel</button>
                    <button type="submit" class="btn bg-primary text-white">Submit</button>
                </div> 
            </div>
        </form>
      </div>   
    </div>
  </div>
</div>
<!-- Extension Modals -->
<div class="modal fade" id="afterextensionModal" tabindex="-1" role="dialog" aria-labelledby="afterextensionModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="client_popupLabel">Proposal Extension</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
      <div class="modal-body">
        <form id="extension_form">   
            @csrf
            <div class="row">                   
                <label for="payment" class="form-label">Proposal Extension Date</label>
                    <div class="row">
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control " placeholder="dd-mm-YYYY" name="extended_date" id="extended_date" value="" readonly>
                                    </div>
                                </div>
                        <input type="hidden" id="applicationId"  name="application_id"/>       
                    </div>
            </div>
            <div class="row mt-4">    
                <div class="col-12">
                    <p>Your Proposal Extension Date is: <span id="extension_date_status"></span></p>
                </div> 
            </div>
        </form>
      </div>   
    </div>
  </div>
</div>
<!-- Compliant Modals -->
<div class="modal fade" id="complaintModal" tabindex="-1" role="dialog" aria-labelledby="complaintModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="client_popupLabel">Report</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
        <div class="modal-body">
            <form id="complaint_form">   
                @csrf
                <div class="row">                   
                    <label for="payment" class="form-label">Description</label>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group">
                                <textarea class="form-control" id="description" name="description" rows="6\4" required>{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    <input type="hidden" id="jobapplicationId"  />       
                </div>
                
                <div class="row mt-4">    
                    <div class="col-12 text-center">
                        <button type="button" class="btn bg-secondary text-white me-4" data-bs-dismiss="modal" id="filterCloseBtn">Cancel</button>
                        <button type="submit" class="btn bg-primary text-white">Submit</button>
                    </div> 
                </div>
            </form>
        </div>   
    </div>
  </div>
</div>
<!-- Withdraw Modals -->
<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="client_popupLabel">Withdraw Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="withdrawapplicationId" value='' />
                <div class="row">
                    <div class="col-6">
                        <p id="withdraw_reason"></p>
                    </div>
                    <div class="col-6">
                        <p id="withdraw_date"></p>
                    </div>
                </div>
                <div class="row"> 
                <div class="col-12 text-center">
                    <button type="button" class="btn bg-secondary text-white me-4" data-bs-dismiss="modal" id="filterCloseBtn">Ok</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var ajax_table;
$(document).ready(function() {
    // Auto-enable Complete Job button when time arrives
    var $btn = $('#completeJobBtn');
    if ($btn.length && $btn.is(':disabled')) {
        var enableAt = new Date($btn.data('enable-at')).getTime();
        var checkInterval = setInterval(function() {
            if (Date.now() >= enableAt) {
                $btn.prop('disabled', false);
                clearInterval(checkInterval);
            }
        }, 60000); // check every minute
    }
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
            url:"{{route('fetch.hiredemployees')}}",
            data: function(data){                
                data.job_id  = $('#job_id').val();  
                data.employee_status  = $('#employee_status').val();                    
            }
          },
          columns: [          
            { data: 'id' },
            { data: 'name' },
            { data: 'start_date' },
            { data: 'end_date' },
            { data: 'payment' },         
            { data: 'buttons' }
        ],
        columnDefs: [          
            { className: 'text-center', targets: [2,3] },
            {"targets": 5,"orderable": false}
        ],
    });  
    ajax_table.column( 0 ).visible( false );  
    $('.employeetab').click(function(){       
        $('#employee_status').val($(this).attr('data-status'));
        
        $('.employeetab').addClass('white-button');
        $(this).removeClass('white-button').addClass('blue-button');
        ajax_table.draw(); 
    });
});
$(document).on('click', '#for_rating', function () {
    var id = $(this).data('userid');
    $('#userId').val(id);
    $.ajax({
        method:'GET',
        url: 'get-rating/'+id,
        data: id,
        success: function(response){
            $('#comment').val(response.data.comment);
            $('#rating').val(response.data.rating);
                $('#rating').attr('style','--value:'+response.data.rating);
        },
        error: function(xhr, status, error) {
            console.log('Error fetching rating:', error);
        }
    });
})
    // rating form
$('#filter_form').submit(function(e){
    e.preventDefault();
    var name = $('.rating').prop('value');
    var comment = $('#comment').val();
    $('.loader').show();
    $.ajax({
        type: "POST",
        url: "{{route('job.rating')}}",
        data:{
            "_token": "{{ csrf_token() }}",
            "rating": $('#rating').val(),
            "task_id": $('#userId').val(),
            "comment": comment
        }
    }).done(function( response ) {
        $('.loader').hide();
        if (response.status === true) {
            Swal.fire("Done!", "Rating added Successfully.", "success").then(function(){
                location.reload();
            });
        } else {
            Swal.fire("Error!", "Rating cannot be added","error");
        }
    }).fail(function(xhr) {
        $('.loader').hide();
        if (xhr.status === 422) {
            Swal.fire("Error!", "Please fill all required fields.", "error");
        } else {
            Swal.fire("Error!", "Rating cannot be added", "error");
        }
    });
});
//Extension End date
$(document).on('click', '#for_extension', function () {
    var id = $(this).data('applicationid');
    $('#applicationId').val(id);
})
$('#extension_form').submit(function(e){
    e.preventDefault();
    $('.loader').show();
    $.ajax({
        type: "POST",
        url: "{{route('job.extension')}}",
        data:{
            "_token": "{{ csrf_token() }}",
            "extension_date": $('#end_date').val(),
            "application_id": $('#applicationId').val(),
        }
    }).done(function( response ) {
        $('.loader').hide();
        ajax_table.ajax.reload();
        if (response.status==true) {
            Swal.fire("Done!", "Extension added Successfully.", "success");
            window.location.reload();
        }else {
            Swal.fire("Error!", "Extension cannot be added","error");
        }
        if(response.status === 422) {
            var errors = $.parseJSON(response.responseText).errors;
            Object.keys(errors).forEach(function (key) {                
                $("#" + key + "Input").addClass("is-invalid");
                $("#" + key + "Error").text(errors[key][0]);
            });
        }
                    
    });
});

$('#end_date').flatpickr({
    minDate: "today",
    enableTime: false,
    dateFormat: "Y-m-d",
});
//proposal extended date
$(document).on('click', '#after_extension', function () {
    var id = $(this).data('applicationid');
    var date = $(this).data('extensiondate');
    var status = $(this).data('extensionstatus');
    if(date){
        const datefield = document.getElementById('extended_date');
        datefield.value = date;
        //datefield.value += date;
    }
    $("#extension_date_status").text('');
    if(status == 1){
        $("#extension_date_status").html('Approved');
    }else if(status == 2){
        $("#extension_date_status").html('Rejected');
    }else{
        $("#extension_date_status").html('Pending');
    }
})

//complaint for trader
$(document).on('click', '.complaintModalbtn', function () {
    var id = $(this).attr('data-applicationid');
    $('#applicationId').val(id);
});
$('#complaint_form').submit(function(e){
    e.preventDefault();
    var name = $('.complaint').prop('value');
    var description = $('#description').val();
    $('.loader').show();
    $.ajax({
        type: "POST",
        url: "{{route('job.complaint')}}",
        data:{
            "_token": "{{ csrf_token() }}",
            "application_id": $('#applicationId').val(),
            "description": description
        }
    }).done(function( response ) {
        $('.loader').hide();
        if (response.status==true) {
            Swal.fire("Done!", "Report added Successfully.", "success");
            window.location.reload();
        }else {
            Swal.fire("Error!", "Report cannot be added",
                "error");
        }
                    
    });
});
$(document).on('click', '.withdrawModalbtn', function () {
    var id = $(this).attr('data-applicationid');
    $('#withdrawapplicationId').val(id);
    $.ajax({
        method:'GET',
        url: 'get-withdraw/'+id,
        data: id,
        success: function(response){
            
            $('#withdraw_reason').html(response.data.withdraw_reason);
            $('#withdraw_date').html(response.data.withdraw_date); 
        },
        error: function(xhr, status, error) {
            console.log('Error fetching withdraw reason:', error);
        }
    });
});
function approveEmployee(id,status) {
    if (id) {
            message = 'Are you sure you want to approve ?';
        Swal.fire({
            text: message,
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, do it!",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {            
            if (result.isConfirmed) {
                $('.loader').show();
                var url = "{{ route('job.approveemployee') }}";               
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "POST",
                    data: {id:id},
                    success: function(response) {
                        $('.loader').hide();
                        ajax_table.ajax.reload();
                        if (response.status==true) {
                            Swal.fire("Done!", "Employee status changed Successfully.", "success");
                        } else {
                            Swal.fire("Error!", "Error, Please Try Again",
                                "error");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error approving!", "Error, Please Try Again", "error");
                    }
                });
            }
        });
    }
}

function rejectEmployee(id,status) {
    if (id) {
            message = 'Are you sure you want to reject ?';
    
        Swal.fire({
            text: message,
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, do it!",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {          
            if (result.isConfirmed) {
                $('.loader').show();
                var url = "{{ route('job.rejectEmployee') }}";               
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "POST",
                    data: {id:id},
                    success: function(response) {
                        $('.loader').hide();
                        ajax_table.ajax.reload();
                        if (response.status==true) {
                            Swal.fire("Done!", "Hired Employee changed status Successfully.", "success");
                        } else {
                            Swal.fire("Error!", "Error, Please Try Again",
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

function completeJob(id) {
    if (id) {
            message = 'Are you sure you want to complete this job ?';
    
        Swal.fire({
            text: message,
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, do it!",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {          
            if (result.isConfirmed) {
                $('.loader').show();
                var url = "{{ route('job.completeJob') }}";               
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "POST",
                    data: {id:id},
                    success: function(response) {
                        $('.loader').hide();
                        ajax_table.ajax.reload();
                        if (response.status==200) {
                            Swal.fire("Done!", "Job has been completed Successfully.", "success");
                            location.reload();
                        } else {
                            Swal.fire("Error!", "Error, Please Try Again",
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

function cancelJob(id) {
    if (id) {
            message = 'Are you sure you want to cancel this job ?';
    
        Swal.fire({
            text: message,
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, do it!",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {           
            if (result.isConfirmed) {
                $('.loader').show();
                var url = "{{ route('job.cancelJob') }}";               
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "POST",
                    data: {id:id},
                    success: function(response) {
                        $('.loader').hide();
                        ajax_table.ajax.reload();
                        if (response.status==200) {
                            Swal.fire("Done!", "Job has been canceled Successfully.", "success");
                            location.reload();
                        } else {
                            Swal.fire("Error!", "Error, Please Try Again",
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