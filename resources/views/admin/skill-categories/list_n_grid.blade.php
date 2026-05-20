@extends('admin.layouts.master')
@section('title','Skill Categories')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title pb-3">
        <h2 class="desktop-content"><i class="skill-black"></i>Skill Categories</h2>
        <div class="middle-title job-middle-title">
            
        </div>
        <h2 class="mobile-content"><i class="skill-black"></i>Skill Categories</h2>
        
        <div class="right-filter job-right-filter">
        <a class="btn-primary" href="{{route('skill-categories.create')}}"> <i class="bi bi-plus-lg"></i> New Skill Category</a><br/>
         
        </div>
     
    </div>
    <div class="d-flex justify-content-end pb-2">
    <div class="page-view">
          
          <a href="{{request()->fullUrlWithQuery(['mode' => 'list'])}}"><i class="fa fa-list  @if(!request()->mode || request()->mode=='list') view-active @else  @endif"></i></a>
          <a href="{{request()->fullUrlWithQuery(['mode' => 'grid'])}}"><i class="fa fa-th-large @if(request()->mode=='grid') view-active @endif"></i></a>
      </div> &nbsp; | &nbsp; <span id="job_count">Showing <span id="skill_count_value">{{$skill_categories->total()}}</span> Skill Categories Results</span>
            
    </div>        
    @if(!request()->mode || request()->mode=='list')
    <div class="skill-table-heading">
    <div class="d-flex">
        
        
    </div>

    <div class="table-responsive-lg">
            <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list" id="ajax_table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    <!--div class="skill-table-pagintion d-flex">       
        {{ $skill_categories->links() }}        
    </div-->   
@else
    <div class="row">
        @foreach($skill_categories as $_skill)
        <div class="col-md-6 col-lg-4 col-xl-3" id="delete-{{$_skill->id}}">
                        <div class="job-listing">
                            @if($_skill->image)
                                <div class="category-thumb mb-3 text-center">
                                    <img src="{{ asset($_skill->image) }}" alt="{{ $_skill->name }}" class="img-fluid rounded" style="max-height:160px; width:auto; object-fit:cover;" />
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-start">

                                <div class="sub-list">
                                    <h3>{{$_skill->name}}</h3>
                                </div>
                                <a  href="{{route('skill-categories.edit',$_skill->id)}}"><i class="bi bi-pencil-square"></i></a>
                            </div>
                            @if($_skill->status == '1')
                            @if($_skill->JobSkillCategory)
                            <a href="{{route('skill-categories.changestatus',$_skill->id)}}" class="primary-btn grey-button d-none"><i class="bi bi-x cross-icon"></i>Deactivate</a>
                            <button class="primary-btn black-button d-none" onclick="deleteRecord({{$_skill->id}})" ><i class="bi bi-trash"></i>Delete</button>
                            @else
                            <a href="{{route('skill-categories.changestatus',$_skill->id)}}" class="primary-btn grey-button"><i class="bi bi-x cross-icon"></i>Deactivate</a>
                            <button class="primary-btn black-button" onclick="deleteRecord({{$_skill->id}})" ><i class="bi bi-trash"></i>Delete</button>
                            @endif
                            
                            @else
                            <a href="{{route('skill-categories.changestatus',$_skill->id)}}" class="primary-btn blue-button"><i class="bi bi-check2"></i>Activate</a>
                            @endif
                            
                            
                            
                           
                        </div>
                    </div>
        @endforeach
    </div>       
    <div class="row">
        <div class="skill-table-pagintion grid-pagintion  d-flex">
            {{ $skill_categories->links() }}
        </div>         
    </div>
@endif     
</div>
@endsection
@section('script')
<script type="text/javascript">
        var ajax_table;
$(document).ready(function() {
    ajax_table = $('#ajax_table').on('xhr.dt', function (e, settings, json, xhr) {
         $('#skill_count_value').html('');
        $('#skill_count_value').append(JSON.parse(xhr.responseText).iTotalDisplayRecords); 
    }).DataTable({
        "columnDefs": [
                {"className": "text-center", "targets": [1, 5]},
                {"targets": 5,"orderable": false},
                {"className":"d-none", "targets": [0]},
                {"orderable": false, "targets": [1]},
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
            url:"{{route('fetch.skill-categories')}}",
          },
          columns: [
            { data: 'id' },
            { data: 'image' },
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
                var url = "{{ route('skill-categories.destroy', ':id') }}";
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
</script>
@endsection