@extends('website.layouts.master')

@section('title')
    Search Results
@endsection

@section('content')

<div class="top-content banner-outer">
    <div class="row skill-title text-center">
        <h1 class="heading-size">
            Find Your Perfect Beauty Professional
        </h1>

        <ul class="skill-breadcrumbs d-flex justify-content-center">
            <li><a href="{{(session('employer_mode')?'/employer':'/')}}">Home</a> <i class="bi bi-arrow-right"></i></li>
            <li>{{ $service->service_name }}    </li>
        </ul>
    </div>
</div>

<div class="container job-detailpage py-4">

    <h3 class="job-search-result mb-4">
        {{ $service->service_name ?? 'Services' }}
    </h3>

    <div class="row">

        @forelse($subCategories as $subcat)

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">

                <div class="card h-100 shadow-sm border-0">

                    <img
                        src="{{ !empty($subcat->image) ? asset($subcat->image) : asset('images/no-image.png') }}"
                        class="card-img-top"
                        alt="{{ $subcat->service_name }}"
                        style="height:220px;object-fit:cover;"
                    >

                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title">
                            {{ $subcat->service_name }}
                        </h5>

                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit(strip_tags($subcat->description), 100) }}
                        </p>

                        <button
                            type="button"
                            class="btn btn-primary book-appointment-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#appointmentModal"
                            data-service="{{ $subcat->service_name }}">
                            Book Appointment
                        </button>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12 text-center">
                <h5>No Sub Categories Found</h5>
            </div>

        @endforelse

    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="appointmentModalLabel">Book Appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('appointment.store') }}" method="POST" id="appointmentForm">
        @csrf

        <div class="modal-body">
          <div class="row">

            <div class="col-md-6 mb-3">
              <label class="form-label">Full Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" id="name">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Phone Number <span class="text-danger">*</span></label>
              <input type="text" name="phone" class="form-control" id="phone">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control" id="email">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Service <span class="text-danger">*</span></label>
             <select name="service" class="form-select" id="service">
                <option value="">Select Service</option>

                @foreach ($subCategories as $ser)
                    <option value="{{ $ser->service_name }}">
                        {{ $ser->service_name }}
                    </option>
                @endforeach
            </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Salon <span class="text-danger">*</span></label>
              <select name="salon" class="form-select" id="salon">
                <option value="">Select Salon</option>
                @foreach ($company as $comp)
                <option value="{{ $comp->id }}">{{ $comp->first_name }}{{ $comp->last_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Appointment Date <span class="text-danger">*</span></label>
              <input type="date" name="appointment_date" class="form-control" id="appointment_date">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Appointment Time <span class="text-danger">*</span></label>
              <input type="time" name="appointment_time" class="form-control" id="appointment_time">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Appointment Type <span class="text-danger">*</span></label>
              <div class="service-toggle">
                <input type="radio" id="visitSalon" name="appointment_type" value="salon" checked>
                <label for="visitSalon">🏪 Visit Salon</label>

                <input type="radio" id="homeService" name="appointment_type" value="home">
                <label for="homeService">🏠 Home Service</label>
              </div>
            </div>

            <div class="col-12 mb-3">
              <label class="form-label">Message</label>
              <textarea name="message" rows="4" class="form-control"></textarea>
            </div>

            <input type="hidden" name="status" value="pending" class="form-control" required>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-black text-light" data-bs-dismiss="modal">
            Close
          </button>

          <button type="submit" class="btn btn-primary">
            Book Appointment
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

{{-- thank you modal --}}
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Thank You!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <h4>Your appointment has been booked successfully.</h4>
        <p>We will contact you with in 2 hours.</p>
      </div>

      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
          OK
        </button>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.book-appointment-btn').forEach(button => {

        button.addEventListener('click', function () {

            let service = this.getAttribute('data-service');

            // alert('Service: ' + service);
            console.log('Service:', service);

            document.getElementById('service').value = service;
        });

    });

});
</script>
@endsection
