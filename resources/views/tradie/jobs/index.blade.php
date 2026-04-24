@extends('tradie.layouts.master')
@section('title') My Jobs @endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2><i class="jobs-icon"></i> My Jobs</h2>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-4">
        @foreach(['applied' => 'Applied', 'upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed'] as $key => $label)
        <li class="nav-item">
            <a class="nav-link {{ $tab == $key ? 'active' : '' }}" href="{{ route('tradie.jobs.index', ['tab' => $key]) }}">{{ $label }}</a>
        </li>
        @endforeach
    </ul>

    <div class="dashboard-table">
        <div class="table-responsive">
            <table class="table skill-table-list">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $application)
                    @php $job = $application->job; @endphp
                    <tr>
                        <td>{{ $job->title ?? '-' }}</td>
                        <td>{{ $job->agency->agency_name ?? '-' }}</td>
                        <td>{{ $job->location ?? '-' }}</td>
                        <td>{{ $job ? date('d M Y', strtotime($job->start_date)) : '-' }}</td>
                        <td>{{ $job ? date('d M Y', strtotime($job->end_date)) : '-' }}</td>
                        <td>
                            <a href="{{ route('tradie.jobs.show', $job->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">No jobs found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $jobs->appends(['tab' => $tab])->links() }}
    </div>
</div>
@endsection
