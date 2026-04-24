@extends('admin.layouts.master')
@section('title','Subscription Plans')
@section('content')
<div class="container-fluid middle-content dashboard-content">
                <div class="page-title mobile-page-title">
                    <h2 class="desktop-content"><i class="subscription-black"></i>Subscription Plans</h2>
                    <h2 class="mobile-content"><i class="subscription-black"></i>Subscription Plans</h2>
                    <div class="middle-title job-middle-title">
                   
                        <a href="{{request()->fullUrlWithQuery(['type' => 'monthly'])}}" class="primary-btn @if(request()->type=='monthly' || !request()->type) blue-button @else white-button @endif">Monthly</a>
                        <a href="{{request()->fullUrlWithQuery(['type' => 'yearly'])}}" class="primary-btn @if(request()->type=='yearly') blue-button @else white-button @endif">Yearly</a>
                   
                    </div>                    
                    <div class="right-filter job-right-filter">
                        <a href="{{ route('plans.create') }}" class="text-white"><button class="primary-btn blue-button"><i class="icon-plus"></i>New Subscription Plan</button></a>                        
                    </div>
                </div>           
                <div class="skill-sub-plan">                
                    <div class="sub-plan row equal-height-row d-flex flex-wrap">
                        @foreach($plans as $_plan)
                        <div class="col-md-4 my-2" id="delete-{{$_plan->id}}">
                            <div class="plan-{{$_plan->class_name}}">
                                <div class="plan-header">
                                    <i class="fas {{$_plan->class_name}}-tag"></i>
                                    <b> {{$_plan->name}}</b>
                                    <div class="price">
                                    @if(request()->type == 'yearly')
                                        ${{$_plan->yearly_price}}
                                        <small> Per Year</small>
                                        @else
                                        ${{$_plan->monthly_price}}
                                        <small> Per Month</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="sub-plan-bottom">
                                @if($_plan->status == 1)
                                <a href="#" ><button class="primary-btn grey-button" onclick="activate({{$_plan->id}})"><i class="bi bi-x cross-icon"></i>Deactivate</button></a>
                                    @else
                                    <button class="primary-btn blue-button me-2 {{($_plan->id == 4 || $_plan->id == 6)?'d-none':''}}" onclick="activate({{$_plan->id}})" {{($_plan->id == 4 || $_plan->id == 6)?"disabled":''}}><i class="bi bi-check"></i> Activate</button>
                                    @endif
                                    <a  href="{{route('plans.edit',$_plan->id)}}"><button class="primary-btn black-button badge-black-button"><i class="bi bi-pencil-square"></i>Edit</button></a>
                                    @php 
                                    if(!count($_plan->AgencySubscription)){
                                    @endphp
                                    <button class="deletebutton {{($_plan->id == 4 || $_plan->id == 6)?'d-none':''}}" onclick="deleteRecord({{$_plan->id}})" ><i class="bi bi-trash float-end"></i></button>
                                    @php 
                                    }
                                    @endphp
                                </div>
                            </div>
                        </div>
                        
                        @endforeach
                        
                        
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
                var url = "{{ route('plans.destroy', ':id') }}";
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
                        
                        if (response.status==true) {
                            Swal.fire("Done!", "Status change Successfully.", "success");
                            window.location.reload();
                        } else {
                            Swal.fire("Error!", "Plan status cannot be Changed",
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