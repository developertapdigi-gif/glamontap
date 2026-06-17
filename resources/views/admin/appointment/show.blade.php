@extends('admin.layouts.master')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Appointment Details</h2>

        <a href="{{ route('appointments.index') }}"
           class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="200">Appointment ID</th>
                    <td>#{{ $appointment->id }}</td>
                </tr>

                <tr>
                    <th>Name</th>
                    <td>{{ $appointment->name }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $appointment->email }}</td>
                </tr>

                <tr>
                    <th>Phone</th>
                    <td>{{ $appointment->phone }}</td>
                </tr>

                <tr>
                    <th>Service</th>
                    <td>
                        {{ $appointment->service->name ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <th>Appointment Date</th>
                    <td>
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Appointment Time</th>
                    <td>{{ $appointment->appointment_time }}</td>
                </tr>

                {{-- <tr>
                    <th>Status</th>
                    <td>
                        @if($appointment->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($appointment->status == 'confirmed')
                            <span class="badge bg-success">Confirmed</span>
                        @elseif($appointment->status == 'completed')
                            <span class="badge bg-primary">Completed</span>
                        @elseif($appointment->status == 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </td>
                </tr> --}}
                <tr>
                    <th>Appointment Type</th>
                    <td>{{ $appointment->appointment_type ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Message</th>
                    <td>{{ $appointment->message ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Created At</th>
                    <td>{{ $appointment->created_at->format('d M Y h:i A') }}</td>
                </tr>

            </table>

        </div>
    </div>

</div>
@endsection