@extends('admin.layouts.master')
@section('title','Jobs')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title">
        <h2 class="desktop-content"><i class="jobs-black"></i>Jobs</h2>
        <div class="middle-title job-middle-title">
        <a href="{{ route('job.index') }}"><button class="primary-btn blue-button">New</button></a>
            <a href="{{ route('job.ongoing') }}"><button class="primary-btn white-button">Ongoing</button></a>
            <a href="{{ route('job.upcoming') }}"><button class="primary-btn white-button">Upcoming</button></a>
            <button class="primary-btn white-button">Completed</button>
        </div>
        <h2 class="mobile-content"><i class="jobs-black"></i>Jobs</h2>
        <div class="right-filter job-right-filter dropdown btn-group dropstart">
                        <a class="filter-text dropdown-toggle"href="#" role="button" id="filter" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-sliders"></i>
                            <b>Filter</b>
                        </a>

                        <ul id="filter-collapse" aria-labelledby="filter"
                            class="dropdown-menu   dropdown-menu-arrow">
                            <li class="dropdown-header">
                                <div class="form-check filter-block">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        List View
                                    </label>
                                </div>
                                <div class="form-check filter-block">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Grid View
                                    </label>
                                </div>

                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="notification-item">
                                <div>
                                    <b>Skill Category</b>
                                    <select class="form-select mt-1">
                                        <option>Painter</option>
                                    </select>

                                </div>
                            </li>
                        </ul>

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
                <th>Location</th>
                <th>No of Employees</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Actions</th>
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
            { data: 'payment'},
            { data: 'status' },
            { data: 'buttons' }
        ]
    });   
});
function approveJob(id) {
    if (id) {
        Swal.fire({
            text: "{{ __('Are you sure you want to approve ?') }}",
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
                var url = "{{ route('job.approve') }}";               
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
