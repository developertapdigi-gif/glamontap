@extends('admin.layouts.master')
@section('title','Subscription Plans')
@section('content')
<div class="container-fluid middle-content dashboard-content">
                <div class="page-title mobile-page-title">
                    <h2 class=""><i class="subscription-black"></i>Subscription</h2>

                </div>
                <div class="subscription-detail">
                    <div class="row">
                        <div class="col-xl-4 col-lg-3 col-md-12">
                            <div class="border-sub-block">
                                <b>Current Plan</b>
                                <p class="mt-2">Basic Plan</p>
                                <p>Pending Subscription Limits - <b>20</b></p>
                                <p class="blue-font"><b>Pending Subscription Limits - $1940</b></p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-12">
                            <div class="border-sub-block">
                                <b>Plan Usage</b>
                                <div class="d-flex mt-2" style="position:relative">
                                    <div class="half-circle"> </div>
                                    <p class="complete-per">50%</p>
                                    <div>
                                        <p>Bilable session reported</p>
                                        <p>Remaining billable sessions</p>
                                        <p>All billable sessions</p>

                                    </div>
                                    <div class="sub-top-price">
                                        <p>12,500</p>
                                        <p>12,500</p>
                                        <p>12,500</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                     
                                <b>Need More Workers?</b>
                                <p class="mt-2">
                                    Upgrade your plan to suit your projects</br>
                                    Talent Match Access: You can view portfolios of up to 5 tradies </br>

                                    <b class="blue-font mt-2">Upgrade Subscription</b>
                                </p>
                            
                        </div>

                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-12">
                            <b>Enable Auto Renew</b> <br />
                            <p class="d-inline-block mt-2">Tradesmen Access: View profiles and portfolios of up to 150
                                tradesmen</p>

                            <label class="switch" for="checkbox">
                                <input type="checkbox" id="checkbox" />
                                <div class="slider round"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="skill-sub-plan">
                    <div class="sub-plan-title">
                        <h2>Renew Subscription Plans </h2>
                        <div class="sub-plan-btns">
                            <button class="monthly-button me-0">Monthly</button>
                            <button class="yearly-button">Yearly</button>
                        </div>
                    </div>




                    <div class="row equal-height-row d-flex flex-wrap">
                        <div class="col-md-4">
                            <div class="sub-service agency-sub-service">
                                <div class="title"><i class="bi bi-tag-fill yellow-tag"></i>
                                    <h3>Basic</h3>
                                </div>
                                <div class="package-detail yellow-plan-detail">
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Monthly Job Postings: Post up to 5 jobs per month</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Tradesmen Access: View profiles andportfolios of up to 20 tradesmen</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Communication: In-app messaging
                                            with tradesmen</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p>Support: Standard customer support</p>
                                    </div>
                                </div>

                                <div class="package-bottom-detail yellow-plan-desc">
                                    <b>$1940</b>
                                    <p>Annually Save 15%</p>

                                    <button class="btn-primary">Choose Plan</button>

                                </div>


                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sub-service agency-sub-service blue-border">
                                <div class="title"><i class="bi bi-rocket-takeoff-fill blue-tag"></i>
                                    <h3>Advanced</h3>
                                </div>
                                <div class="package-detail blue-plan-detail">
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Monthly Job Postings: Post up to 15 jobs per month</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Tradesmen Access: View profiles and
                                            portfolios of up to 150 tradesmen</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Enhanced Visibility: Featured job listings
                                            for higher visibility</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Communication: In-app messaging</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Support: Priority customer support</p>
                                    </div>
                                </div>

                                <div class="package-bottom-detail blue-plan-desc">
                                    <b>$1940</b>
                                    <p>Annually Save 15%</p>

                                    <button class="btn-primary">Choose Plan</button>

                                </div>


                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sub-service agency-sub-service me-0">
                                <div class="title"><i class="bi-crown green-tag"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="1.25em" height="1em" viewBox="0 0 640 512">
                                            <path fill="currentColor"
                                                d="M528 448H112c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h416c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16m64-320c-26.5 0-48 21.5-48 48c0 7.1 1.6 13.7 4.4 19.8L476 239.2c-15.4 9.2-35.3 4-44.2-11.6L350.3 85C361 76.2 368 63 368 48c0-26.5-21.5-48-48-48s-48 21.5-48 48c0 15 7 28.2 17.7 37l-81.5 142.6c-8.9 15.6-28.9 20.8-44.2 11.6l-72.3-43.4c2.7-6 4.4-12.7 4.4-19.8c0-26.5-21.5-48-48-48S0 149.5 0 176s21.5 48 48 48c2.6 0 5.2-.4 7.7-.8L128 416h384l72.3-192.8c2.5.4 5.1.8 7.7.8c26.5 0 48-21.5 48-48s-21.5-48-48-48" />
                                        </svg></i>
                                    <h3>Premium</h3>
                                </div>
                                <div class="package-detail green-plan-detail">
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Monthly Job Postings: Post up to 15 jobs per month</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Tradesmen Access: View profiles and
                                            portfolios of up to 150 tradesmen</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Enhanced Visibility: Featured job listings
                                            for higher visibility</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Communication: In-app messaging,
                                            video call scheduling, and direct contact details</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Custom Solutions: Tailored solutions for large-scale hiring needs</p>
                                    </div>
                                    <div>
                                        <i class="bi bi-check"></i>
                                        <p> Support: Dedicated account manager and 24/7 support</p>
                                    </div>
                                </div>

                                <div class="package-bottom-detail green-plan-desc">
                                    <b>$1940</b>
                                    <p>Annually Save 15%</p>

                                    <button class="btn-primary">Choose Plan</button>

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
            url:"{{route('fetch.skill-categories')}}",
          },
          columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'status' },
            { data: 'created_at' },
            { data: 'buttons' }
        ]
    });
   // ajax_table.column( 0 ).visible( false );
});
$(function(){
    $(".mode_radio").change(function(){
        $('#form_check').submit();
    });
});
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
                var url = "{{ route('skill-categories.destroy', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "DELETE",
                    success: function(response) {
                        ajax_table.ajax.reload();
                        $('#delete-'+id).remove();
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
function activate(id) {
    if (id) {
        Swal.fire({
            text: "{{ __('Are you sure you want to change status ?') }}",
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
                var url = "{{ route('plans.activate') }}";               
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "POST",
                    data: {id:id},
                    success: function(response) {
                        ajax_table.ajax.reload();
                        if (response.status==true) {
                            Swal.fire("Done!", "Job approved Successfully.", "success");
                        } else {
                            Swal.fire("Error Deleting!", "Job cannot be deleted",
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
</script>
@endsection