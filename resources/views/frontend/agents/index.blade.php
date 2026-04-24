@extends('frontend.layouts.master')
@section('title','Agents')
@section('content')
<div class="container-fluid mx-3">
<div class="row">
<div class="col-12">
  <div class="card shadow">
    <div class="card-header bg-primary border-0 ">
     <a href="{{ route('agent.create') }}" class="text-white">
          <i class="ni ni-fat-add"></i>
          <span>Add New Agent</span>
      </a>
    </div>
    <div class="card-body">
        <div class="table-responsive2">
            <table class="table align-middle table-row-dashed fs-6 gy-5 " id="ajax_table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Created On</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
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
          processing: true,
          serverSide: true,
          order: [[0, 'desc']],
          ajax: {
            url:"{{route('fetch.agents')}}",
          },
          columns: [
            { data: 'id' },
            { data: 'first_name' },
            { data: 'email' },
            { data: 'mobile' },
            { data: 'created_at' },
            { data: 'buttons' }
        ]
    });
   // ajax_table.column( 0 ).visible( false );
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
                var url = "{{ route('agent.destroy', ':id') }}";
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
