@extends('admin.layouts.master')
@section('title','Subscription Plans')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="row">
        <div class="col-12">  
            <div class="page-title">
                <h2 class="desktop-content"><i class="subscription-black"></i>Subscription Plans</h2>                    
                <h2 class="mobile-content"><i class="subscription-black"></i>Subscription Plans</h2>
                <div class="right-title  me-0">
                    <a href="{{ route('plans.create') }}" class="text-white">
                        <button class="primary-btn blue-button"><i class="icon-plus"></i>Add Subscription Plan</button>
                    </a>
                </div>
            </div>
            <div class="table-responsive-lg">
                <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list" id="ajax_table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
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
          processing: true,
          serverSide: true,
          order: [[0, 'desc']],
          ajax: {
            url:"{{route('fetch.plans')}}",
          },
          columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'monthly_price' },
            { data: 'status' },
            { data: 'created_at' },
            { data: 'buttons' }
        ]
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
