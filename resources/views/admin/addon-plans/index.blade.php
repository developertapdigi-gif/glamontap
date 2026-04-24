@extends('admin.layouts.master')
@section('title','Addon Plans')
@section('content')
<div class="container-fluid middle-content dashboard-content">
                <div class="page-title mobile-page-title add_on-page">
                    <h2 class="desktop-content"><i class="subscription-black"></i>Add-on</h2>
                    <h2 class="mobile-content"><i class="subscription-black"></i>Add-on</h2>
                    <div class="middle-title job-middle-title">
                   
                       
                    </div>                    
                    <div class="right-filter job-right-filter">
                        <a href="{{ route('addon-plans.create') }}" class="text-white"><button class="primary-btn blue-button"><i class="icon-plus"></i>New Add-on</button></a>                        
                    </div>
                </div>           
                <div class="skill-sub-plan">                
                    <div class="sub-plan row equal-height-row add-on-row">
                    @foreach($addonplans as $_plan)
                        <div class="col-xxl-4 col-xl-4 col-md-6 col-12  my-2" id="delete-{{$_plan->id}}">
                            <div class="plan-blue add-on-page">
                                <div class="add-ons">
                                <div class="plan-header">
                                    <i class="fas blue-tag"></i>
                                    <b>{{$_plan->name}}</b>
                                </div>
                                    <div class="price">
                                    ${{$_plan->price}}  
                                    </div>
                                </div>
                                <div class="sub-plan-bottom">
                                
                                  <a href="{{route('addon-plans.edit',$_plan->id)}}"><button class="primary-btn black-button badge-black-button"><i class="bi bi-pencil-square"></i>Edit</button></a>
                                  <button class="deletebutton" onclick="deleteRecord({{$_plan->id}})" ><i class="bi bi-trash float-end"></i></button>
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
                var url = "{{ route('addon-plans.destroy', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "DELETE",
                    success: function(response) {
                        //ajax_table.ajax.reload();
                        //console.log(('#delete-'+id))
                        if (response.data) {
                            $('#delete-'+id).remove();
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