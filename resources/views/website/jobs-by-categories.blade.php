@extends('website.layouts.master-employer')

@section('title')
Jobs
@endsection

@section('content')

<div class="top-content banner-outer">
        <div class="row skill-title text-center">
            <h1>
               Hairstylist
            </h1>
            

            <ul class="skill-breadcrumbs d-flex justify-content-center">
                <li><a href="{{(session('employer_mode')?'/employer':'/')}}">Home</a> <i class="bi bi-arrow-right"></i></li>
                <li>Hairstylist</li>
            </ul>
        </div>
    </div>


<section class="latest-section" id="latest-posts">

</section>
<div class="section-header">
    <h2>{{ $skill->name }}Jobs</h2>
</div>

<div class="container ">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @forelse($tasks as $task)
            <!-- Task Card -->
            <a class="job-outer swiper-slide" href="{{route('get.resultdetail', [$task->id,1]) }}">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body pt-5 pe-4 pb-4 ps-4">
                        <!-- Header: Skill Title + Image -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="h4 mb-1">{{ $task->title }}</h2>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    {{ $task->location ?? 'Location not specified' }}, India
                                </p>
                            </div>
                            <!-- Task Image -->
                            <div class="flex-shrink-0">
                                <img
                                    src="{{ asset('uploads/' . ($task->image ?? 'default-image.png')) }}"
                                    alt="{{ $task->title }}"
                                    class="rounded-circle"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr class="my-3">

                        <!-- Task Details: Salary, Experience, Location, Vacancies -->
                        <div class="row g-3 mb-4">
                            <!-- Salary -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-rupee-sign text-primary me-2"></i>
                                    <span>
                                        ₹{{ number_format($task->minimum_price ?? 0, 2) }} -
                                        ₹{{ number_format($task->maximum_price ?? 0, 2) }} / month
                                    </span>
                                </div>
                            </div>

                            <!-- Experience -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-briefcase text-primary me-2"></i>
                                    <span>{{ $task->experience_range ?? 'Experience not specified' }} years</span>
                                </div>
                            </div>

                            <!-- Company Address (if different from location) -->
                            @if($task->company_address && $task->company_address != $task->location)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-building text-primary me-2"></i>
                                    <span>{{ $task->company_address }}</span>
                                </div>
                            </div>
                            @endif

                            <!-- Vacancies -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users text-primary me-2"></i>
                                    <span>
                                        {{ $task->number_of_employees ?? '1' }} Vacanc{{ ($task->number_of_employees ?? 1) > 1 ? 'ies' : 'y' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Tags -->
                        {{-- <div class="d-flex flex-wrap gap-2 mb-4">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">Incentives</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">Overtime Pay</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">Salary in Bank</span>
                            </div> --}}

                        <!-- Apply Button -->
                        {{-- <div class="d-grid gap-2">
                                <a
                                    href="{{ route('tasks.apply', $task->id) }}"
                        class="btn btn-primary btn-sm"
                        >
                        <i class="fas fa-paper-plane me-1"></i> Apply Now
            </a>
        </div> --}}
    </div>
</div>
@empty
<!-- No Tasks Found -->
<div class="card text-center py-5">
    <div class="card-body">
        <i class="fas fa-search fa-3x text-muted mb-3"></i>
        <h3 class="h5">No Jobs Found</h3>
        <p class="text-muted mb-0">There are no tasks for this skill. Check back later!</p>
    </div>
</div>
</a>

    <div class="row">
        <div class="col-lg-4" data-aos="fade-right">
            <div class="bg-white border rounded-3 p-4 mb-4">
                <h6 class="fw-semibold mb-3">Search Keywords</h6>
                <input type="text" class="form-control rounded-pill" placeholder="Job title or keywords"
                    id="jobSearchInput">
            </div>
            <div class="bg-white border rounded-3 p-4 mb-4">
                <h6 class="fw-semibold mb-3">Location</h6>
                <select class="form-select rounded-pill" id="jobLocationInput">
                    <option>All Locations</option>
                    <option>New York</option>
                    <option>London</option>
                    <option>San Francisco</option>
                    <option>Berlin</option>
                    <option>Sydney</option>
                </select>
            </div>
            <div class="bg-white border rounded-3 p-4 mb-4">
                <h6 class="fw-semibold mb-3">Experience Level</h6>
                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="exp1"><label
                        class="form-check-label" for="exp1">Entry Level</label></div>
                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="exp2"><label
                        class="form-check-label" for="exp2">Mid Level</label></div>
                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="exp3"><label
                        class="form-check-label" for="exp3">Senior Level</label></div>
                <div class="form-check"><input class="form-check-input" type="checkbox" id="exp4"><label
                        class="form-check-label" for="exp4">Executive</label></div>
            </div>
        </div>
        <div class="col-lg-8" data-aos="fade-left">
            <div class="row">
                <div class="col-12">
                    <div class="job-card d-flex flex-wrap gap-3" data-job-type="full-time">
                        <img src="http://127.0.0.1:8000/uploads/profile/694913e223582_plumber3.webp" width="60" height="60" class="job-img">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 font-heading"><a href="job-detail.html" class="text-decoration-none text-dark">Senior Hair Colorist</a></h6>
                            <p class="text-muted small mb-0"><i
                                    class="fas fa-map-marker-alt me-1"></i>Paris</p>
                        </div>
                        <div class="text-end">
                            <p class="job-post-prize mb-0 mt-2">$70-90k</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforelse
</div>
</div>
</div>
@endsection