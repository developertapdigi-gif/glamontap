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
                            {{-- <th>ID</th> --}}
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Time</th>
                            {{-- <th>Message</th> --}}
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                {{-- <td>{{ $appointment->id }}</td> --}}
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

                                {{-- <td>
                                    {{ $appointment->message }}
                                </td> --}}

                                @if(auth()->user()->user_type == 1)
                                    <td>
                                        {{ $appointment->status }}
                                    </td>
                                @else 
                                <td>
                                    <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="status-update-form">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm status-dropdown" 
                                                data-appointment-id="{{ $appointment->id }}">
                                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                @endif

                                {{-- <td>
                                    {{ $appointment->created_at->format('d M Y h:i A') }}
                                </td> --}}
                                <td>
                                    <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-info btn-sm">
                                     View </a>
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
                                <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="status-update-form">
                                    @csrf
                                   
                                    <select name="status" class="form-select form-select-sm status-dropdown" 
                                            data-appointment-id="{{ $appointment->id }}">
                                        <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
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
@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('.status-dropdown');
    
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('change', function() {
            const form = this.closest('.status-update-form');
            const appointmentId = this.dataset.appointmentId;
            const status = this.value;
            
            // Show loading state
            const originalHtml = this.innerHTML;
            this.innerHTML = '<option>Updating...</option>';
            this.disabled = true;
            
            // Use fetch API for AJAX with POST method (not PATCH)
            fetch(`/appointments/${appointmentId}/status`, {
                method: 'POST',  // Changed from PATCH to POST
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'  // Add this for AJAX detection
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    showToast('Status updated successfully!', 'success');
                    
                    // Update the status display in the same cell
                    const td = this.closest('td');
                    if (td) {
                        // Remove old status text if exists
                        const statusText = td.querySelector('.status-text');
                        if (statusText) {
                            statusText.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        }
                    }
                    
                    // Also handle grid view
                    const parentDiv = this.closest('.job-listing');
                    if (parentDiv) {
                        const statusParagraph = parentDiv.querySelector('p strong:contains("Status")');
                        if (statusParagraph) {
                            const parentP = statusParagraph.closest('p');
                            if (parentP) {
                                const statusSpan = parentP.querySelector('.status-text');
                                if (statusSpan) {
                                    statusSpan.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                                }
                            }
                        }
                    }
                    
                    // Optionally reload the page after a short delay to reflect changes
                    // setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message || 'Error updating status', 'error');
                    // Revert dropdown
                    this.value = this.dataset.previousValue || this.value;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error updating status. Please try again.', 'error');
                // Revert dropdown
                this.value = this.dataset.previousValue || this.value;
            })
            .finally(() => {
                // Reset dropdown
                this.innerHTML = originalHtml;
                this.disabled = false;
                // Store current value for potential rollback
                this.dataset.previousValue = status;
            });
        });
        
        // Store initial value
        dropdown.dataset.previousValue = dropdown.value;
    });
    
    // Toast notification function with Bootstrap
    function showToast(message, type = 'success') {
        // Check if Bootstrap Toast is available
        if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
            // Create toast container if not exists
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                toastContainer.style.zIndex = '9999';
                document.body.appendChild(toastContainer);
            }
            
            const toastEl = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-success' : 'bg-danger';
            toastEl.className = `toast align-items-center text-white ${bgColor} border-0`;
            toastEl.setAttribute('role', 'alert');
            toastEl.setAttribute('aria-live', 'assertive');
            toastEl.setAttribute('aria-atomic', 'true');
            
            toastEl.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            toastContainer.appendChild(toastEl);
            const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
            toast.show();
            
            // Remove toast after it's hidden
            toastEl.addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        } else {
            // Fallback to alert or custom notification
            alert(message);
        }
    }
});
</script>
@endsection


