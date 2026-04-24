@extends('admin.layouts.master')
@section('title')
   {{$page_heading}}
@endsection
@section('content')
    <div class="container-fluid middle-content">
        <div class="card">
            @can('admin-role-create')
            <div class="card-header">               
                <div class="card-toolbar">                     
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('role.create') }}" class="btn btn-primary">Add Role</a>                    
                    </div>
                </div>
            </div>
             @endcan
            <div class="card-body">
                <div class="table-responsive admin-table">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="ajax_table">
                    <thead>                        
                        <tr class="text-start text-dark fw-bolder fs-7 text-uppercase gs-0">
                            <th>ID</th>                            
                            <th>Name</th>
                          <th style="width: 20% !important;" data-orderable="false">Action</th>
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
          ajax: {
             url:"{{route('fetch-role')}}",            
          },
          columns: [
            { data: 'id' },           
            { data: 'name' }, 
            { data: 'buttons' }
        ]
    });    
});   
function removeFunc(id) {
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
                var url = "{{ route('role.destroy', ':id') }}";
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
<style>
    .admin-table .dataTable {
    width: 100% !important;
    }
</style>
@endsection