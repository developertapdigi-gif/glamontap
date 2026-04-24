@extends('admin.layouts.master')
@section('title','Badges')
@section('content')
<div class="container-fluid middle-content dashboard-content">
                <div class="page-title mobile-page-title">
                    <h2 class="desktop-content"><i class="badge-black"></i>Badges</h2>
                    <div class="middle-title job-middle-title">
                       
                    </div>
                    <h2 class="mobile-content"><i class="badge-black"></i>Badges</h2>
                    <div class="right-filter job-right-filter">
                    <a href="{{route('badges.create')}}"> <button class="primary-btn blue-button"><i class="icon-plus"></i>New Badge</button></a>
                        <ul id="collapseExample" class="collapse dropdown-menu dropdown-menu-end  dropdown-menu-left-arrow notifications">
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
                <div class="row">
                    @foreach($badges as $_badge)
                    <div class="col-md-6 col-lg-4 col-xl-3" id="delete-{{$_badge->id}}">
                        <div class="job-listing">
                            <div class="d-flex justify-content-between align-items-start">

                                <div class="sub-list">
                                    <h3><i class="sk-icon {{$_badge->class_name}}"></i>{{ucfirst($_badge->name)}}</h3>
                                    <p>Experience Range - <b>{{$_badge->minimum_range}} to {{$_badge->maximum_range}} Years</b></p>
                                </div>
                                <a  href="{{route('badges.edit',$_badge->id)}}"><i class="bi bi-pencil-square bi-bold"></i></a>
                            </div>
                            @if($_badge->status == '1')
                            @if($_badge->JobBadge)
                            <a href="{{route('badges.changestatus',$_badge->id)}}" class="primary-btn grey-button d-none"><i class="bi bi-x cross-icon"></i>Deactivate</a>
                            <button class="primary-btn black-button badge-black-button d-none" onclick="deleteRecord({{$_badge->id}})" ><i class="bi bi-trash"></i>Delete</button>
                            @else
                            <a href="{{route('badges.changestatus',$_badge->id)}}" class="primary-btn grey-button"><i class="bi bi-x cross-icon"></i>Deactivate</a>
                            <button class="primary-btn black-button badge-black-button" onclick="deleteRecord({{$_badge->id}})" ><i class="bi bi-trash"></i>Delete</button>
                            @endif
                            
                            @else
                            <a href="{{route('badges.changestatus',$_badge->id)}}" class="primary-btn blue-button me-2"><i class="bi bi-check2"></i>Activate</a>
                            <button class="primary-btn black-button badge-black-button" onclick="deleteRecord({{$_badge->id}})" ><i class="bi bi-trash"></i>Delete</button>
                            @endif
                            
                            
                           
                        </div>

                    </div>
                    @endforeach
                    
                   
                 
                </div>
@endsection
@section('script')
<script type="text/javascript">
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
                var url = "{{ route('badges.destroy', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    url: url,
                    type: "DELETE",
                    success: function(response) {
                        $('#delete-'+id).remove();
                        //ajax_table.ajax.reload();
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
