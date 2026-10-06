@extends('admin.layouts.master')
@section('title') Dashboard @endsection

@push('styles')
<style>
    /* Appointment Cards */
    .appointment-stats-row {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 15px;
        margin: 20px 0;
    }
    .appointment-stat-card {
        background: #fff;
        border-radius: 10px;
        padding: 18px 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        text-align: center;
        border-left: 4px solid #6c757d;
        transition: all 0.3s ease;
    }
    .appointment-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.10);
    }
    .appointment-stat-card .stat-icon {
        font-size: 24px;
        margin-bottom: 5px;
        opacity: 0.6;
    }
    .appointment-stat-card .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 5px 0;
    }
    .appointment-stat-card .stat-label {
        font-size: 13px;
        color: #6c757d;
        font-weight: 500;
        margin: 0;
    }
    .appointment-stat-card.total { border-left-color: #6f42c1; }
    .appointment-stat-card.pending { border-left-color: #ffc107; }
    .appointment-stat-card.confirmed { border-left-color: #0d6efd; }
    .appointment-stat-card.completed { border-left-color: #198754; }
    .appointment-stat-card.cancelled { border-left-color: #dc3545; }
    .appointment-stat-card.today { border-left-color: #0dcaf0; }

    /* Table Styles */
    .table-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }
    .table-title b {
        font-size: 16px;
    }
    .transparent-button {
        background: transparent;
        border: 1px solid #0d6efd;
        color: #0d6efd;
        padding: 5px 15px;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .transparent-button:hover {
        background: #0d6efd;
        color: #fff;
    }
    .white-backgound {
        background: #fff;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .fix-height-table {
        min-height: 300px;
    }
    .no-result {
        text-align: center;
        padding: 20px;
        color: #6c757d;
        margin: 0;
    }
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-status.pending { background: #ffc107; color: #000; }
    .badge-status.confirmed { background: #0d6efd; color: #fff; }
    .badge-status.completed { background: #198754; color: #fff; }
    .badge-status.cancelled { background: #dc3545; color: #fff; }
    .view-entry {
        color: #0d6efd;
        font-size: 16px;
    }
    .view-entry:hover {
        color: #0a58ca;
    }

    @media (max-width: 768px) {
        .appointment-stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
        .table-title {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
       <h2 class="mobile-hide"><i class="home-black"></i>Dashboard</h2>
       <div class="right-title">
          <a href="{{ route('job.create') }}"><button class="primary-btn blue-button"><i class="icon-plus"></i>Post New Job</button></a>
          <a href="{{ route('job.index') }}"><button class="primary-btn black-button"><i class="icon-eye"></i>Jobs</button></a>
       </div>
    </div>
    
    <!-- First Row - Job Statistics -->
    <div class="row equal-height-row">
       <div class="col-lg-12 col-sm-12">
          <div class="row">
             <div class="col-lg-3 col-sm-12">
                <div class="stat-card black-card">
                   <i class="totaljob-grey"></i>
                   <div class="stat-card-text">Total Jobs</div>
                   <div class="stat-card-number">{{$totaljobs}}</div>
                </div>
             </div>
             <div class="col-lg-3 col-sm-12">
                <div class="stat-card blue-card">
                   <i class="ongoingjob-grey"></i>
                   <div class="stat-card-text">Ongoing Jobs</div>
                   <div class="stat-card-number">{{$ongoingJobs->total()}}</div>
                </div>
             </div>
             <div class="col-lg-3 col-sm-12">
                <div class="stat-card green-card">
                   <i class="upcomingjob-grey"></i>
                   <div class="stat-card-text">Upcoming Jobs</div>
                   <div class="stat-card-number">{{$upcomingJobs->total()}}</div>
                </div>
             </div>
             <div class="col-lg-3 col-sm-12">
                <div class="stat-card rust-card">
                   <i class="newjob-grey"></i>
                   <div class="stat-card-text">Appointed Jobs</div>
                   <div class="stat-card-number">{{$asignedJobs->total()}}</div>
                </div>
             </div>
             <div class="col-lg-3 col-sm-12">
                <div class="stat-card orange-card">
                   <i class="jobs-grey"></i>
                   <div class="stat-card-text">Completed Jobs</div>
                   <div class="stat-card-number">{{$completedJobs->total()}}</div>
                </div>
             </div>
             <div class="col-lg-3 col-sm-12">
                <div class="stat-card grey-card">
                   <i class="endorsment-grey"></i>
                   <div class="stat-card-text">Endorsement Posts</div>
                   <div class="stat-card-number">{{count($endrosementposts)}}</div>
                </div>
             </div>
             <div class="col-lg-3 col-sm-12">
                <div class="stat-card grey-card">
                   <i class="endorsment-grey"></i>
                   <div class="stat-card-text">Total Appointments</div>
                   <div class="stat-card-number">{{ $appointmentStats['total'] ?? 0 }}</div>
                </div>
             </div>
          </div>
       </div>
    </div>

    <!-- Ongoing Jobs & Latest Appointments Tables (Side by Side) -->
    <div class="row">
        <div class="col-lg-6 col-sm-12 white-backgound">
            <div class="dashboard-table fix-height-table">
                <div class="table-title">
                    <b>Latest Appointments</b>
                    <a href="{{ route('bookings') }}" class="ms-auto"><button class="transparent-button">View All</button></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-no-wrap">
                        <thead>
                            <tr>
                                <th scope="col">Customer</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                {{-- <th scope="col">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($latestAppointments) && $latestAppointments->count() > 0)
                                @foreach($latestAppointments as $appointment)
                                    @php
                                        $customer = App\Models\User::find($appointment->user_id);
                                        $customerName = $customer ? $customer->first_name . ' ' . $customer->last_name : 'N/A';
                                    @endphp
                                    <tr>
                                        <td>{{ $customerName }}</td>
                                        <td>{{ $appointment->created_at->format('d M Y, h:i A') }}</td>
                                        <td>
                                            <span class="badge-status {{ $appointment->status }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        {{-- <td>
                                            <a href="javascript:void(0)" onclick="viewAppointment({{ $appointment->id }})">
                                                <i class="fa fa-eye view-entry"></i>
                                            </a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">
                                        <p class="no-result">No appointments found</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        
        <div class="col-lg-6 col-sm-12 white-backgound">
            <div class="dashboard-table fix-height-table">
                <div class="table-title">
                    <b>Ongoing Jobs</b>
                    <a class="ms-auto" href="{{ route('job.index',['status' =>4,'type' => 'Ongoing']) }}"><button class="transparent-button">View All</button></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-no-wrap">
                        <thead>
                            <tr>
                                <th scope="col">Job Name</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ongoingJobs as $_ongoing_job)
                            <tr>
                                <td>{{$_ongoing_job->title}}</td>
                                <td>{{date('d M Y',strtotime($_ongoing_job->start_date))}}</td>
                                <td>{{date('d M Y',strtotime($_ongoing_job->end_date))}}</td>
                                <td><a href="{{route('job.show', $_ongoing_job->id)}}"><i class="fa fa-eye view-entry"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="no-result">
                        @if($ongoingJobs->total() == 0) No Result Found @endif
                    </p>   
                </div>
            </div>
        </div>
        
    </div>

    <!-- Second Row - Job Status & Tables -->
    <div class="row">
        <div class="col-lg-4 col-sm-12">
            <div class="bar-chart">
                <div class="table-title">
                    <b>Job Status</b>
                    <a class="ms-auto" href="{{ route('job.index') }}"><button class="transparent-button">View All</button></a>
                </div>
                <div id="myChart" width="900" height="600"></div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="dashboard-table">
                <div class="table-title">
                    <b>Upcoming Jobs</b>
                    <a class="ms-auto" href="{{ route('job.index',['status' =>5,'type' => 'Upcoming']) }}"><button class="transparent-button">View All</button></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-no-wrap">
                        <thead>
                            <tr>
                                <th scope="col">Job Name</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingJobs as $_upcoming)
                            <tr>
                                <td>{{$_upcoming->title}}</td>
                                <td>{{date('d M Y',strtotime($_upcoming->start_date))}}</td>
                                <td>{{date('d M Y',strtotime($_upcoming->end_date))}}</td>
                                <td><a href="{{route('job.show', $_upcoming->id)}}"><i class="fa fa-eye view-entry"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($upcomingJobs->total() == 0)
                        <p class="no-result">No Result Found</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="dashboard-table">
                <div class="table-title">
                    <b>Completed Jobs</b>
                    <a class="ms-auto" href="{{ route('job.index',['status' =>6,'type' => 'Completed']) }}"><button class="transparent-button">View All</button></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-no-wrap">
                        <thead>
                            <tr>
                                <th scope="col">Job Name</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedJobs as $_completed)
                            <tr>
                                <td>{{$_completed->title}}</td>
                                <td>{{date('d M Y',strtotime($_completed->end_date))}}</td>
                                <td><a href="{{route('job.show', $_completed->id)}}"><i class="fa fa-eye view-entry"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($completedJobs->total() == 0)
                        <p class="no-result">No Result Found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Appointment Modal -->
<div class="modal fade" id="viewAppointmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="appointmentDetails">
                    <p><strong>Title:</strong> <span id="viewTitle"></span></p>
                    <p><strong>Customer:</strong> <span id="viewCustomer"></span></p>
                    <p><strong>Status:</strong> <span id="viewStatus" class="badge-status"></span></p>
                    <p><strong>Date:</strong> <span id="viewDate"></span></p>
                    <p><strong>Time:</strong> <span id="viewTime"></span></p>
                    <p><strong>Description:</strong> <span id="viewDescription"></span></p>
                    <p><strong>Created:</strong> <span id="viewCreated"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/apexcharts.min.js') }}"></script>
<script>
// Job Status Chart
var seriesData = [{{ $ongoingJobs->total() }}, {{ $upcomingJobs->total() }}, {{ $completedJobs->total() }}, {{ $asignedJobs->total() }}];
var isChartEmpty = seriesData.every(value => value === 0);

if (isChartEmpty) {
    seriesData = [1];
}

var options = {
    series: seriesData,
    chart: {
        type: 'donut',
    },
    labels: isChartEmpty ? ['No Data Available'] : ['Ongoing', 'Upcoming', 'Completed', 'Open'],
    dataLabels: {
        enabled: false
    },
    responsive: [{
        breakpoint: 320,
        options: {
            chart: {
                width: 200
            },
            legend: {
                position: 'bottom'
            }
        }
    }],
    legend: {
        position: 'bottom',
        offsetY: 0,
        height: 100,
    },
    colors: isChartEmpty ? ['#e2e5ec'] : ['#034bad', '#0ab39c', '#f6b84b', '#f06548'],
    states: {
        hover: {
            filter: {
                type: isChartEmpty ? 'darken' : 'lighten',
                value: isChartEmpty ? 0.4 : 0.35,
            }
        }
    },
    tooltip: {
        enabled: true,
        y: {
            formatter: function (value, { seriesIndex, w }) {
                if (isChartEmpty) {
                    return 'N/A';
                }
                return value;
            }
        }
    }
};

var chart = new ApexCharts(document.querySelector("#myChart"), options);
chart.render();

// View appointment function
window.viewAppointment = function(id) {
    @if(isset($appointments))
    var appointment = @json($appointments).find(e => e.id == id);
    if (appointment) {
        $('#viewTitle').text(appointment.title || 'Appointment');
        $('#viewCustomer').text(appointment.customer_name || 'N/A');
        $('#viewStatus').text(appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1))
                       .removeClass('pending confirmed completed cancelled')
                       .addClass(appointment.status);
        $('#viewDate').text(appointment.date || moment(appointment.created_at).format('DD MMM YYYY'));
        $('#viewTime').text(appointment.time || moment(appointment.created_at).format('hh:mm A'));
        $('#viewDescription').text(appointment.description || 'No description');
        $('#viewCreated').text(moment(appointment.created_at).format('DD MMM YYYY, hh:mm A'));
        $('#viewAppointmentModal').modal('show');
    }
    @endif
};
</script>
@endsection