@extends('admin.layouts.master')
@section('title','Pages')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title pb-3">
        <h2 class="desktop-content"><i class="skill-black"></i>Pages</h2>
        <div class="middle-title job-middle-title">
            
        </div>
        <h2 class="mobile-content"><i class="skill-black"></i>Pages</h2>
        
        <div class="right-filter job-right-filter">
        <a class="btn-primary" href="{{route('cms.create')}}"> <i class="bi bi-plus-lg"></i> New Pages</a><br/>
         
        </div>
     
    </div>
    <div class="d-flex justify-content-end pb-2">
            
    </div>    
    <div class="skill-table-heading">
    <div class="d-flex">
    </div>
    <div class="table-responsive-lg">
        <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list" id="ajax_table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div> 
</div>
@endsection
@section('script')
<script type="text/javascript">
        var ajax_table;
$(document).ready(function() {
    ajax_table = $('#ajax_table').DataTable({
          columnDefs: [
                {"className": "text-center", "targets": [4]}
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
            url:"{{route('fetch.cms')}}",
          },
          columns: [
            { data: 'id' },
            { data: 'page_title' },
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
                var url = "{{ route('cms.destroy', ':id') }}";
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