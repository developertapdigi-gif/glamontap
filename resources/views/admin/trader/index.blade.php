@extends('admin.layouts.master')
@section('title','Tradies')
@section('content')
<div class="container-fluid mx-3">
  <div class="row">
    <div class="col-12">
      
        <div class="page-title">
                    <h2 class="desktop-content"><i class="agency-black"></i>Tradies</h2>
                    
                    <h2 class="mobile-content"><i class="agency-black"></i>Tradies</h2>
                    <div class="right-title  me-0">
                    <a href="{{ route('trader.create') }}" class="text-white">
                        <button class="primary-btn blue-button"><i class="icon-plus"></i>New Tradies</button>
                    </a>
                    </div>
                </div>
          <div class="table-responsive-lg">
              <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list" id="ajax_table">
                  <thead>
                      <tr>
                        <th></th>
                          <th>SR no.</th>
                          <th>Name</th>
                          <th>Location</th>
                          <th>Email</th>
                          <th>Status</th>
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
            url:"{{route('fetch.traders')}}",
          },
          columns: [
            { data: "logo" },
            { data: 'id' },
            { data: 'first_name' },
            { data: 'address' },
            { data: 'email' },
           // { data: 'mobile' },
            { data: 'status' },
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
                var url = "{{ route('trader.destroy', ':id') }}";
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
