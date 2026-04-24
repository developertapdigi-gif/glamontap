@extends('admin.layouts.master')
@section('title','Companies')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title">
        <h2 class="desktop-content"><i class="agency-black"></i>Companies</h2>
        <div class="middle-title job-middle-title">
            
        </div>
        <h2 class="mobile-content"><i class="agency-black"></i>Companies</h2>        
        <div class="right-filter job-right-filter">           
        </div>     
    </div>
    <div class="d-flex justify-content-end pb-2">
    <div class="page-view">
          
          <a href="{{request()->fullUrlWithQuery(['mode' => 'list'])}}"><i class="fa fa-list  @if(!request()->mode || request()->mode=='list') view-active @else  @endif"></i></a>
          <a href="{{request()->fullUrlWithQuery(['mode' => 'grid'])}}"><i class="fa fa-th-large @if(request()->mode=='grid') view-active @endif"></i></a>
      </div>  &nbsp;  | <span id="job_count">&nbsp; Showing <span id="company_count_value"> {{$agencies->total()}} </span> for Companies Results</span>
            
           
    </div>        
@if(!request()->mode || request()->mode=='list')
    <div class="skill-table-heading">
        <div class="d-flex"> 
            <div class="sort-btns ms-auto">
            
            <button class="primary-btn white-grey-btn"> 
                <i class="bi bi-star"></i> 
                <select class="no-border" id="select_rating">
                    <option value="-1">Rating</option>
                    <option value="1">1 star</option>
                    <option value="2">2 star</option>
                    <option value="3">3 star</option>
                    <option value="4">4 star</option>
                    <option value="5">5 star</option>
                </select>
            </button>
            <button class="primary-btn white-grey-btn"> 
                <i class="bi bi-flag-fill"></i> 
                <select class="no-border" id="select_reports">
                    <option value="-1">Reports</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </button>
            <button class="primary-btn white-grey-btn"> 
                <i class="bi bi-tools"></i>
                <select class="no-border" id="select_jobs">
                    <option value="-1">Jobs</option>
                    <option value="low">Low to High</option>
                    <option value="high">High to Low</option>
                </select>
            </button>
            <button class="primary-btn white-grey-btn">
                <i  class="bi bi-currency-dollar"></i> 
                <select class="no-border" id="select_subscriber">
                    <option value="-1">Subscribe</option>
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                </select>
            </button>
        </div>
    </div>
    <div class="table-responsive-lg">
        <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list" id="ajax_table">
            <thead>
                <tr>
                    <th>SR no.</th>
                    <th>Logo</th>                                
                    <th>Name</th>
                    <th>Location</th>
                    <th>Created On</th>
                    <th>Hired Employees</th>
                    <th>No of Jobs</th>
                    <th>Rating</th>                              
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
@else
    <div class="row">
        @foreach($agencies as $_agency)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="job-listing">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3>{{ ucfirst(($_agency->agency_name)?$_agency->agency_name:$_agency->first_name) }} {{ ucfirst(($_agency->agency_name)?'':$_agency->last_name) }}</h3>
                            <p>No of Jobs - <b>{{ ($_agency->no_of_jobs)?$_agency->no_of_jobs:'10'}}</b></p>
                        </div>
                        @php               
                           if($_agency->logo && (File::exists(public_path($_agency->logo)))){
                              $thumbnail = asset($_agency->logo);
                           }else{
                              $thumbnail = url('/').'/images/company-name.png';
                           }                           
                        @endphp
                        <img title="job logo" src="{{$thumbnail}}" height="50px" class="profile-image" />
                    </div>
                    <div class="amount"></div>
                    <p>Hired Employees - <b>{{ ($_agency->hired_employees)?$_agency->hired_employees:'10'}} employess</b></p>
                    <div class="address">
                        <img src="../images/icons/address.png" />{{ ucfirst($_agency->address) }}
                    </div>
                    <p class="job-rating">Rating - &nbsp;
                    <input class="rating trader-rating"  max="5"  step="0.05" style="--fill:orange;--value:{{$_agency->over_all_rating??0}}" type="range" value="{{$_agency->over_all_rating??0}}">
                    </p>
                    <hr />
                    <div class="d-flex justify-content-between align-items-center view-detail">
                    @if($_agency->status == 1)
                    <button type="button" class="btn btn-icon btn-sm btn-color-dark decline-{{$_agency->id}}" onclick="activateRecord({{$_agency->id}},{{$_agency->status}})"><i class="skill-table-action bi bi-x-lg"></i></button>
                    <button type="button" class="btn btn-icon btn-sm btn-color-dark approve-{{$_agency->id}} d-none" onclick="activateRecord({{$_agency->id}},0)"><i class="skill-table-action bi bi-check skill-tooltip"></i></button>
                    @elseif($_agency->status == 2)
                    <button type="button" class="btn btn-icon btn-sm btn-color-dark approve-{{$_agency->id}}" onclick="activateRecord({{$_agency->id}},{{$_agency->status}})"><i class="skill-table-action bi bi-check skill-tooltip"></i></button>
                    <button type="button" class="btn btn-icon btn-sm btn-color-dark decline-{{$_agency->id}} d-none" onclick="activateRecord({{$_agency->id}},2)"><i class="skill-table-action bi bi-x-lg"></i></button>
                    @else
                    <button type="button" class="btn btn-icon btn-sm btn-color-dark approve-{{$_agency->id}}" onclick="activateRecord({{$_agency->id}},{{$_agency->status}})"><i class="skill-table-action bi bi-check skill-tooltip"></i></button>
                    <button type="button" class="btn btn-icon btn-sm btn-color-dark decline-{{$_agency->id}} d-none" onclick="activateRecord({{$_agency->id}},1)"><i class="skill-table-action bi bi-x-lg"></i></button>
                    @endif
                    
                    <a href="{{ route('agency.show',$_agency->id) }}"><i class="bi bi-arrow-down-right-circle-fill"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>       
    <div class="row">
        <div class="skill-table-pagintion grid-pagintion  d-flex">
            {{ $agencies->links() }}
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
         $('#company_count_value').html('');
        $('#company_count_value').append(JSON.parse(xhr.responseText).iTotalDisplayRecords); 
    }).DataTable({
            "columnDefs": [
                {"className": "text-center", "targets": [3,4,5,6]},
                {"targets": [1,8],"orderable": false},
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
                url:"{{route('fetch.agencies')}}",
                data: function(data){   
                    data.subscriber  = $('#select_subscriber').val();              
                    data.over_all_rating  = $('#select_rating').val();              
                    data.has_complain  = $('#select_reports').val();            
                }
              },
              columns: [
                { data: 'id' },
                { data: 'logo' },                
                { data: 'first_name' },
                { data: 'address' },
                { data: 'created_at' },
                { data: 'hiring_count' },
                { data: 'completed_jobs' },
                { data: 'over_all_rating'},        
                { data: 'buttons' }
            ]
    }); 
    ajax_table.column( 0 ).visible( false );
    $('#select_rating,#select_reports,#select_subscriber').change(function(){
      ajax_table.draw();
    }); 
    $('#select_jobs').change(function(){
        let jobOrder = $(this).val();
        if(jobOrder=='low'){
            ajax_table.order([6, 'asc']).draw();
        }else if(jobOrder=='high'){
            ajax_table.order([6, 'desc']).draw();
        }        
    });
    $(".mode_radio").change(function(){
        $('#form_check').submit();
    });   
});
function activateRecord(id,status){
    if(id){
        if(status == 1){
        popMessage = "Are you sure you want to block this account?";
    }else{
        popMessage = "Are you sure you want to approve this account?";
    }
        Swal.fire({
            text: popMessage,
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, Change!",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('agency.changestatus', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    data: { oldstatus : status }, 
                    success: function(response) {
                        ajax_table.ajax.reload();
                        if (response.data) {
                            if(status == 1){
                                $('.approve-'+id).removeClass('d-none');
                                $('.decline-'+id).addClass('d-none');                                
                            }else{
                                $('.approve-'+id).addClass('d-none');
                                $('.decline-'+id).removeClass('d-none');
                            }
                            Swal.fire("Done!", "Changed Successfully.", "success");
                        } else {
                            Swal.fire("Error!", "This row cannot be chnaged",
                                "error");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error!", "Error, Please Try Again", "error");
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
                var url = "{{ route('agency.destroy', ':id') }}";
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