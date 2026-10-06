@extends('admin.layouts.master')
@section('title','Customers List')
@php 
use Illuminate\Support\Facades\Auth;
use App\Models\User;
$usertype = Auth::user()->user_type;
$userrole = User::ROLE['customer'];
@endphp
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title">
        <h2 class="desktop-content"><i class="traders-black"></i>Customers</h2>
        <div class="middle-title job-middle-title">
            <input type="hidden" id="usertype" name="usertype" value="{{$usertype}}">
            <input type="hidden" id="role" name="role" value="{{$userrole}}">
        </div>
        <h2 class="mobile-content"><i class="traders-black"></i>Customers</h2>
        @if(Auth::user()->user_type == User::ROLE['customer'])
        <div class="right-title me-0">
            <a href="{{ route('agent.create') }}" class="btn-primary">
                <i class="bi bi-plus-lg"></i>New Sub User
            </a>
        </div>
        @endif
    </div>
    
    <div class="d-flex justify-content-end pb-2">
        <div class="page-view">
            <!-- View toggle buttons -->
            <button class="btn btn-sm btn-outline-secondary mode_radio" value="list" id="list_view">
                <i class="bi bi-list"></i> List
            </button>
            <button class="btn btn-sm btn-outline-secondary mode_radio" value="grid" id="grid_view">
                <i class="bi bi-grid"></i> Grid
            </button>
        </div> 
        <span id="job_count">&nbsp; Showing <span id="customer_count_value">{{ $customerlist->total() }}</span> Customers Results </span>
    </div>
   
    @if(!request()->mode || request()->mode=='list')
        <!-- List View -->
        <div class="skill-table-heading ps-4">Customers</div>
        <div class="table-responsive-lg">
            <table class="table skill-table-list job_completed" id="ajax_table">
                <thead>
                    <tr>
                        <th>SR No.</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    @else
        <!-- Grid View -->
        <div class="row">
            @php $counter = 1; @endphp
            @foreach($customers as $customer)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="job-listing">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3>#{{ $counter++ }} - {{ $customer->first_name }} {{ $customer->last_name }}</h3>
                                <p>Email: <b>{{ $customer->email }}</b></p>
                            </div>
                            @php               
                                if($customer->logo && File::exists(public_path($customer->logo))){
                                    $thumbnail = asset($customer->logo);
                                }else{
                                    $thumbnail = url('/').'/images/company-name.png';
                                }                           
                            @endphp
                            <img title="profile image" src="{{ $thumbnail }}" height="50px" class="profile-image"/>
                        </div>
                        <div class="amount"></div>
                        <p>Mobile: <b>{{ $customer->mobile ?? 'N/A' }}</b></p>
                        <p>Status: 
                            @if($customer->status == 1)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>
                        <hr />
                    </div>
                </div>
            @endforeach
        </div>       
        <div class="row">
            <div class="col-auto">
                {{ $customerlist->links() }}
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
            $('#customer_count_value').html('');
            $('#customer_count_value').append(JSON.parse(xhr.responseText).iTotalDisplayRecords); 
        }).DataTable({
            "columnDefs": [
                {"className": "text-center", "targets": [0, 5]},
                {"targets": [0], "orderable": false}, // Make serial number column not sortable
            ],
            language: {
                'paginate': {
                    'previous': '<i class="bi bi-arrow-left"></i>',
                    'next': '<i class="bi bi-arrow-right"></i>'
                }
            },
            processing: true,
            serverSide: true,
            order: [[1, 'asc']], // Order by first name by default
            ajax: {
                url: "{{ route('fetch.customers') }}",
                data: function(data){   
                    data.filter_skill = $('#filter_skill').val();              
                }
            },
            columns: [
                { data: 'id' },
                { data: 'first_name' },
                { data: 'last_name' },
                { data: 'email' },
                { data: 'mobile' },
                { data: 'status' }
            ]
        });
        
        $('#filter_skill').change(function(){
            ajax_table.draw();
        });
    });

    $(function(){
        $(".mode_radio").click(function(){
            var mode = $(this).val();
            window.location.href = window.location.pathname + '?mode=' + mode;
        });
    });
</script>
@endsection