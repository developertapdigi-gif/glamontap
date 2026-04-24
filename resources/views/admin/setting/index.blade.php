@extends('admin.layouts.master')
@section('title','Setting')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title">
        <h2 class="desktop-content"><i class="setting-black"></i>Setting</h2>
        <div class="middle-title job-middle-title">
           
        </div>
        <h2 class="mobile-content"><i class="setting-black"></i>Setting</h2>
        <div class="right-filter job-right-filter">
            <a data-bs-toggle="collapse" href="#collapseExample" class="filter-text" ><i class="bi bi-sliders"></i>
            <b>Filter</b></a>
        </div>
    </div>
    <div class="skill-table-heading"></div>
    <div class="table-responsive-lg">
        <table class="table skill-table-list" id="ajax_table">
            <thead>
              <tr>
                <th>Website Name</th>
                <th>Location</th>
                <th>Emails</th>
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
            url:"{{route('fetch.settings')}}",
          },
          columns: [
            { data: 'site_name' },
            { data: 'address' },
            { data: 'emails' },
            { data: 'buttons' }
        ]
    });   
});


</script>
@endsection
