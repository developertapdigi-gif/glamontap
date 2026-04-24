@extends('tradie.layouts.master')
@section('title') Dashboard @endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2 class="mobile-hide"><i class="home-black"></i>Dashboard</h2>
    </div>

    {{-- Stats --}}
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="stat-card black-card">
                <i class="totaljob-grey"></i>
                <div class="stat-card-text">Applied Jobs</div>
                <div class="stat-card-number">{{ $appliedJobs }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="stat-card blue-card">
                <i class="ongoingjob-grey"></i>
                <div class="stat-card-text">Ongoing Jobs</div>
                <div class="stat-card-number">{{ $ongoingJobs }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="stat-card green-card">
                <i class="upcomingjob-grey"></i>
                <div class="stat-card-text">Upcoming Jobs</div>
                <div class="stat-card-number">{{ $upcomingJobs }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="stat-card orange-card">
                <i class="jobs-grey"></i>
                <div class="stat-card-text">Completed Jobs</div>
                <div class="stat-card-number">{{ $completedJobs }}</div>
            </div>
        </div>
    </div>

    {{-- Chart + Recent Jobs --}}
    <div class="row mt-4">
        <div class="col-lg-4 col-sm-12">
            <div class="bar-chart">
                <div class="table-title"><b>Job Status</b></div>
                <div id="myChart"></div>
            </div>
        </div>
        <div class="col-lg-8 col-sm-12">
            <div class="dashboard-table">
                <div class="table-title">
                    <b>Recent Jobs</b>
                    <a class="ms-auto" href="{{ route('tradie.jobs.index') }}"><button class="transparent-button">View All</button></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-no-wrap">
                        <thead>
                            <tr>
                                <th>Job Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentJobs as $application)
                            <tr>
                                <td>{{ $application->job->title ?? '-' }}</td>
                                <td>{{ $application->job ? date('d M Y', strtotime($application->job->start_date)) : '-' }}</td>
                                <td>{{ $application->job ? date('d M Y', strtotime($application->job->end_date)) : '-' }}</td>
                                <td>
                                    @php
                                    $status = $application->job->status ?? 0;
                                    $labels = [1=>'Open', 4=>'Ongoing', 5=>'Upcoming', 6=>'Completed'];
                                    $colors = [1=>'primary', 4=>'info', 5=>'success', 6=>'secondary'];
                                    @endphp
                                    <span class="badge bg-{{ $colors[$status] ?? 'dark' }}">{{ $labels[$status] ?? 'N/A' }}</span>
                                </td>
                                <td><a href="{{ route('tradie.jobs.show', $application->task_id) }}"><i class="fa fa-eye view-entry"></i></a></td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center">No jobs found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/apexcharts.min.js') }}"></script>
<script>
var seriesData = [{{ $ongoingJobs }}, {{ $upcomingJobs }}, {{ $completedJobs }}, {{ $appliedJobs }}];
var isEmpty = seriesData.every(v => v === 0);
var options = {
    series: isEmpty ? [1] : seriesData,
    chart: { type: 'donut' },
    labels: isEmpty ? ['No Data Available'] : ['Ongoing', 'Upcoming', 'Completed', 'Applied'],
    dataLabels: { enabled: false },
    colors: isEmpty ? ['#e2e5ec'] : ['#034bad', '#0ab39c', '#f6b84b', '#f06548'],
    legend: { position: 'bottom', height: 100 },
    responsive: [{ breakpoint: 320, options: { chart: { width: 200 } } }]
};
new ApexCharts(document.querySelector("#myChart"), options).render();
</script>
@endsection
