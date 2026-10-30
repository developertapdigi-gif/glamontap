
@extends('admin.layouts.master')

@section('title', 'Appointments')

@section('content')
<div class="container-fluid middle-content dashboard-content">

    <div class="page-title mobile-page-title pb-3">
        <h2 class="desktop-content">
            <i class="skill-black"></i> Appointments
        </h2>

        <!-- <div class="middle-title job-middle-title"></div> -->

        <h2 class="mobile-content">
            <i class="skill-black"></i> Appointments
        </h2>
    </div>

    <!-- <div class="d-flex justify-content-end pb-2">
        <div class="page-view">
            <a href="{{ request()->fullUrlWithQuery(['mode' => 'list']) }}">
                <i class="fa fa-list @if(!request()->mode || request()->mode == 'list') view-active @endif"></i>
            </a>

            <a href="{{ request()->fullUrlWithQuery(['mode' => 'grid']) }}">
                <i class="fa fa-th-large @if(request()->mode == 'grid') view-active @endif"></i>
            </a>
        </div>

        &nbsp; | &nbsp;

        <span>
            Showing {{ $appointments->total() }} Appointment Results
        </span>
    </div> -->

    @if(!request()->mode || request()->mode == 'list')

        {{-- LIST VIEW --}}
        <div class="skill-table-heading">
            <div class="table-responsive-lg">

                <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($appointments as $appointment)

                            <tr data-appointment-id="{{ $appointment->id }}">

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
                                    @if(auth()->user()->user_type == 1)

                                        <span class="status-text">
                                            {{ ucfirst($appointment->status) }}
                                        </span>

                                    @else

                                        <form
                                            action="{{ route('appointments.update-status', $appointment->id) }}"
                                            method="POST"
                                            class="status-update-form"
                                        >
                                            @csrf

                                            <select
                                                name="status"
                                                class="form-select form-select-sm status-dropdown"
                                                data-appointment-id="{{ $appointment->id }}"
                                            >
                                                <option value="pending"
                                                    {{ $appointment->status == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>

                                                <option value="confirmed"
                                                    {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>
                                                    Confirmed
                                                </option>

                                                <option value="completed"
                                                    {{ $appointment->status == 'completed' ? 'selected' : '' }}>
                                                    Completed
                                                </option>

                                                <option value="cancelled"
                                                    {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled
                                                </option>
                                            </select>
                                        </form>

                                    @endif
                                </td>

                                <td>
                                    <a
                                        href="{{ route('appointments.show', $appointment->id) }}"
                                        class=" btn btn-icon btn-sm btn-color-dark"
                                    >
                                        <i class="skill-table-action bi bi-eye-fill"></i>
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center">
                                    No appointments found.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- Pagination --}}
            <div class="skill-table-pagintion d-flex">
                {{ $appointments->links() }}
            </div>
        </div>

    @else

        {{-- GRID VIEW --}}
        <div class="row">

            @forelse($appointments as $appointment)

                <div class="col-md-6 col-lg-4 col-xl-3">

                    <div
                        class="job-listing"
                        data-appointment-id="{{ $appointment->id }}"
                    >
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

                            <div class="appointment-status mb-3">

                                <strong>Status:</strong>

                                <div class="mt-2">

                                    @if(auth()->user()->user_type == 1)

                                        <span class="status-text">
                                            {{ ucfirst($appointment->status) }}
                                        </span>

                                    @else

                                        <form
                                            action="{{ route('appointments.update-status', $appointment->id) }}"
                                            method="POST"
                                            class="status-update-form"
                                        >
                                            @csrf

                                            <select
                                                name="status"
                                                class="form-select form-select-sm status-dropdown"
                                                data-appointment-id="{{ $appointment->id }}"
                                            >
                                                <option value="pending"
                                                    {{ $appointment->status == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>

                                                <option value="confirmed"
                                                    {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>
                                                    Confirmed
                                                </option>

                                                <option value="completed"
                                                    {{ $appointment->status == 'completed' ? 'selected' : '' }}>
                                                    Completed
                                                </option>

                                                <option value="cancelled"
                                                    {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled
                                                </option>
                                            </select>
                                        </form>

                                    @endif

                                </div>
                            </div>

                            @if($appointment->message)
                                <p>
                                    <strong>Message:</strong><br>
                                    {{ $appointment->message }}
                                </p>
                            @endif

                            <a
                                href="{{ route('appointments.show', $appointment->id) }}"
                                class="btn btn-info btn-sm"
                            >
                            <i class="bi bi-eye-fill"></i>
                            </a>

                        </div>
                    </div>
                </div>

            @empty

                <div class="col-12 text-center">
                    <p>No appointments found.</p>
                </div>

            @endforelse

        </div>

        {{-- Grid pagination --}}
        <div class="row">
            <div class="skill-table-pagintion grid-pagintion d-flex">
                {{ $appointments->links() }}
            </div>
        </div>

    @endif

</div>
@endsection


@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
     * AJAX appointment status update.
     * No page reload is required.
     */

    const dropdowns = document.querySelectorAll('.status-dropdown');

    dropdowns.forEach(function (dropdown) {

        // Save the original status for error handling.
        dropdown.dataset.previousValue = dropdown.value;

        dropdown.addEventListener('change', async function () {

            const select = this;
            const form = select.closest('.status-update-form');

            if (!form) {
                console.error('Appointment status form not found.');
                return;
            }

            const previousStatus = select.dataset.previousValue;
            const newStatus = select.value;
            const csrfInput = form.querySelector('input[name="_token"]');

            if (!csrfInput) {
                select.value = previousStatus;
                showToast('CSRF token not found. Please refresh the page.', 'error');
                return;
            }

            // Prevent multiple requests while updating.
            select.disabled = true;

            try {

                const response = await fetch(form.action, {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfInput.value,
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                // Read JSON returned by Laravel.
                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(
                        data.message || 'Unable to update appointment status.'
                    );
                }

                // Save the new status only after successful database update.
                select.dataset.previousValue = newStatus;

                // Update any separate status label in the same row/card.
                const container =
                    select.closest('tr') ||
                    select.closest('.job-listing');

                if (container) {

                    const statusText = container.querySelector('.status-text');

                    if (statusText) {
                        statusText.textContent =
                            newStatus.charAt(0).toUpperCase() +
                            newStatus.slice(1);
                    }
                }

                showToast(
                    data.message || 'Appointment status updated successfully.',
                    'success'
                );

            } catch (error) {

                // Restore the previous selection if saving fails.
                select.value = previousStatus;

                console.error('Status update error:', error);

                showToast(
                    error.message || 'Something went wrong. Please try again.',
                    'error'
                );

            } finally {

                // Keep the original options and re-enable the dropdown.
                select.disabled = false;
            }

        });

    });


    /*
     * Success and error notification.
     */

    function showToast(message, type = 'success') {

        let container = document.querySelector('.toast-container');

        if (!container) {

            container = document.createElement('div');

            container.className =
                'toast-container position-fixed bottom-0 end-0 p-3';

            container.style.zIndex = '99999';

            document.body.appendChild(container);
        }

        const toast = document.createElement('div');

        toast.className =
            'alert ' +
            (type === 'success' ? 'alert-success' : 'alert-danger') +
            ' shadow';

        toast.setAttribute('role', 'alert');

        // Display the server message safely.
        toast.textContent = message;

        container.appendChild(toast);

        setTimeout(function () {
            toast.remove();

            // Remove the container if it is empty.
            if (container.children.length === 0) {
                container.remove();
            }
        }, 3000);
    }

});
</script>
@endsection
