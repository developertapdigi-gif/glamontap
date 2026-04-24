@extends('frontend.layouts.master')
@section('title','Jobs')
@section('content')


        <div class="container-fluid middle-content dashboard-content">
            <div class="page-title mobile-page-title">
                <h2 class="desktop-content"><i class="jobs-black"></i>Jobs</h2>
                <div class="middle-title job-middle-title">
                    <button class="primary-btn blue-button">Ongoing</button>
                    <button class="primary-btn white-button">Upcoming</button>
                    <button class="primary-btn white-button">New</button>
                    <button class="primary-btn white-button">Completed</button>
                </div>
                <h2 class="mobile-content"><i class="jobs-black"></i>Jobs</h2>
                <div class="right-filter job-right-filter">
        <a data-bs-toggle="collapse" href="#collapseExample" class="filter-text" aria-expanded="false" aria-controls="collapseExample"><i class="bi bi-sliders"></i>
<b>Filter</b></a> | &nbsp;
                    Showing 246 Results


                </div>
            </div>
            <div class="skill-table-heading">Ongoing Jobs</div>
            <div class="table-responsive-lg">
            <table class="table skill-table-list" id="ajax_table">
                <thead>
                  <tr>
                    <th>Job Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Loaction</th>
                    <th>No of Employees</th>
                    <th>Actions</th>
                  </tr>
                </thead>

              </table>
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
            url:"{{route('fetch.jobs')}}",
          },
          columns: [
            { data: 'id' },
            { data: 'start_date' },
            { data: 'end_date' },
            { data: 'location' },
            { data: 'number_of_employees' },
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
                var url = "{{ route('job.destroy', ':id') }}";
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
