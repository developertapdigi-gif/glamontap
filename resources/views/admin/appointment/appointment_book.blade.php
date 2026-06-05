@extends('admin.layouts.master')

@section('title','Appointments')

@section('content')
<div class="container-fluid middle-content dashboard-content">

    <div class="page-title mobile-page-title pb-3">
        <h2 class="desktop-content">
            <i class="skill-black"></i> Appointments
        </h2>

        <div class="middle-title job-middle-title"></div>

        <h2 class="mobile-content">
            <i class="skill-black"></i> Appointments
        </h2>
    </div>

    <div class="d-flex justify-content-end pb-2">
        <div class="page-view">
            <a href="{{ request()->fullUrlWithQuery(['mode' => 'list']) }}">
                <i class="fa fa-list @if(!request()->mode || request()->mode=='list') view-active @endif"></i>
            </a>

            <a href="{{ request()->fullUrlWithQuery(['mode' => 'grid']) }}">
                <i class="fa fa-th-large @if(request()->mode=='grid') view-active @endif"></i>
            </a>
        </div>

        &nbsp; | &nbsp;

        <span>
            Showing {{ $appointments->total() }} Appointment Results
        </span>
    </div>

    @if(!request()->mode || request()->mode == 'list')

        <div class="skill-table-heading">

            <div class="table-responsive-lg">
                <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Created On</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->name }}</td>
                                <td>{{ $appointment->phone }}</td>
                                <td>{{ $appointment->email }}</td>
                                <td>{{ $appointment->service }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </td>

                                <td>
                                    {{ $appointment->message }}
                                </td>

                                <td>
                                    @if($appointment->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>

                                    @elseif($appointment->status == 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>

                                    @elseif($appointment->status == 'completed')
                                        <span class="badge bg-primary">Completed</span>

                                    @elseif($appointment->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>

                                    @else
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $appointment->created_at->format('d M Y h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    No appointments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="skill-table-pagintion d-flex">
                {{ $appointments->links() }}
            </div>

        </div>

    @else

        <div class="row">

            @foreach($appointments as $appointment)

                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="job-listing">

                        <div class="sub-list">
                            <h3>{{ $appointment->name }}</h3>

                            <p>
                                <strong>Phone:</strong><br>
                                {{ $appointment->phone }}
                            </p>

                            <p>
                                <strong>Email:</strong><br>
                                {{ $appointment->email }}
                            </p>

                            <p>
                                <strong>Service:</strong><br>
                                {{ $appointment->service }}
                            </p>

                            <p>
                                <strong>Date:</strong><br>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                            </p>

                            <p>
                                <strong>Time:</strong><br>
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                            </p>

                            <p>
                                <strong>Status:</strong><br>

                                @if($appointment->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>

                                @elseif($appointment->status == 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>

                                @elseif($appointment->status == 'completed')
                                    <span class="badge bg-primary">Completed</span>

                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </p>

                            @if($appointment->message)
                                <p>
                                    <strong>Message:</strong><br>
                                    {{ $appointment->message }}
                                </p>
                            @endif

                        </div>
                    </div>
                </div>

            @endforeach

        </div>

        <div class="row">
            <div class="skill-table-pagintion grid-pagintion d-flex">
                {{ $appointments->links() }}
            </div>
        </div>

    @endif

</div>
@endsection