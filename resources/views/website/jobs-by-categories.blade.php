@extends('website.layouts.master-employer')

@section('title')
Jobs
@endsection

@section('content')

<div class="top-content banner-outer">
    <div class="row skill-title text-center">
        <h1>
            @if(isset($skill) && $skill)
                {{ $skill->name }} Jobs
            @else
                All Jobs
            @endif
        </h1>
        <ul class="skill-breadcrumbs d-flex justify-content-center">
            <li><a href="{{(session('employer_mode')?'/employer':'/')}}">Home</a> <i class="bi bi-arrow-right"></i></li>
            <li>
                @if(isset($skill) && $skill)
                {{ $skill->name }} Jobs
                @else
                    All Jobs
                @endif
            </li>
        </ul>
    </div>
</div>

<section class="latest-section" id="latest-posts"></section>

<div class="container">
    <div class="row">
        {{-- Sidebar --}}
        <div class="col-lg-4" data-aos="fade-right">
            {{-- Search --}}
            <div class="bg-white border rounded-3 p-4 mb-4">
                <h6 class="fw-semibold mb-3">Search Keywords</h6>
                <input type="text"
                       class="form-control rounded-pill"
                       placeholder="Job title or keywords"
                       id="jobSearchInput">
            </div>

            {{-- Location --}}
            <div class="bg-white border rounded-3 p-4 mb-4">
                <h6 class="fw-semibold mb-3">Location</h6>
                <select class="form-select rounded-pill" id="jobLocationInput">
                    <option>All Locations</option>
                    @foreach($locations as $location)
                        <option value="{{ strtolower(trim($location)) }}">
                            {{ $location }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Experience --}}
            <div class="bg-white border rounded-3 p-4 mb-4">
                <h6 class="fw-semibold mb-3">Experience Level</h6>
                <div class="form-check mb-2">
                    <input class="form-check-input experience-filter"
                           type="checkbox"
                           value="entry"
                           id="exp1">
                    <label class="form-check-label" for="exp1">Entry Level</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input experience-filter"
                           type="checkbox"
                           value="mid"
                           id="exp2">
                    <label class="form-check-label" for="exp2">Mid Level</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input experience-filter"
                           type="checkbox"
                           value="senior"
                           id="exp3">
                    <label class="form-check-label" for="exp3">Senior Level</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input experience-filter"
                           type="checkbox"
                           value="executive"
                           id="exp4">
                    <label class="form-check-label" for="exp4">Executive</label>
                </div>
            </div>
        </div>

        {{-- Jobs Listing --}}
        <div class="col-lg-8" data-aos="fade-left">
            {{-- Container for "No jobs found" message --}}
            <div id="noJobsMessageContainer" class="w-100 mb-3"></div>

            {{-- Job Items --}}
            <div class="row" id="jobsContainer">
                @if(isset($skill) && $skill)
                    @forelse($taskByCategory as $task)
                        <div class="col-12 mb-3 job-item"
                             data-location="{{ strtolower($task->location ?? '') }}"
                             data-experience="{{ $task->experiance_range }}">
                            <div class="job-card d-flex flex-wrap gap-3">
                                <img src="{{ asset('uploads/profile/694913e223582_plumber3.webp') }}"
                                     width="60"
                                     height="60"
                                     class="job-img">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 font-heading">
                                        <a href="{{ route('get.resultdetail', [$task->id,1]) }}"
                                           class="text-decoration-none text-dark">
                                            {{ $task->title }}
                                        </a>
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $task->location ?? 'Location not specified' }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <p class="job-post-prize mb-0 mt-2">
                                        ₹{{ number_format($task->minimum_price ?? 0, 2) }} -
                                        ₹{{ number_format($task->maximum_price ?? 0, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">No jobs found in this category.</div>
                        </div>
                    @endforelse
                @else
                    @forelse($allTasks as $task)
                        <div class="col-12 mb-3 job-item"
                             data-location="{{ strtolower($task->location ?? '') }}"
                             data-experience="{{ $task->experiance_range }}">
                            <div class="job-card d-flex flex-wrap gap-3">
                                <img src="{{ asset('uploads/profile/694913e223582_plumber3.webp') }}"
                                     width="60"
                                     height="60"
                                     class="job-img">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 font-heading">
                                        <a href="{{ route('get.resultdetail', [$task->id,1]) }}"
                                           class="text-decoration-none text-dark">
                                            {{ $task->title }}
                                        </a>
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $task->location ?? 'Location not specified' }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <p class="job-post-prize mb-0 mt-2">
                                        ₹{{ number_format($task->minimum_price ?? 0, 2) }} -
                                        ₹{{ number_format($task->maximum_price ?? 0, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">No jobs available.</div>
                        </div>
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function () {
    // Check if there are no jobs in the category initially
    const initialJobCount = $('#jobsContainer .job-item').length;
    if (initialJobCount === 0) {
        // If no jobs exist in the category, hide the "No jobs found matching your criteria" container
        $('#noJobsMessageContainer').hide();
    }

    // Search filter
    $('#jobSearchInput').on('keyup', function () {
        let value = $(this).val().toLowerCase();
        $('.job-item').each(function () {
            let text = $(this).text().toLowerCase();
            if (text.indexOf(value) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        updateNoJobsMessage();
    });

    // Location filter
    const locationFilter = document.getElementById('jobLocationInput');
    if (locationFilter) {
        locationFilter.addEventListener('change', function () {
            let selectedLocation = this.value.toLowerCase().trim();
            document.querySelectorAll('.job-item').forEach(function(job) {
                let jobLocation = (job.dataset.location || '').toLowerCase();
                if (selectedLocation === '' || selectedLocation === 'all locations' || jobLocation.includes(selectedLocation)) {
                    job.style.display = '';
                } else {
                    job.style.display = 'none';
                }
            });
            updateNoJobsMessage();
        });
    }

    // Experience filter
    const checkboxes = document.querySelectorAll('.experience-filter');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            filterJobs();
        });
    });
});

// Filter jobs by experience
function filterJobs() {
    let selectedLevels = [];
    document.querySelectorAll('.experience-filter:checked').forEach(function(item) {
        selectedLevels.push(item.value);
    });

    document.querySelectorAll('.job-item').forEach(function(job) {
        let experience = parseInt(job.dataset.experience || 0);
        let showJob = false;

        if (selectedLevels.length === 0) {
            showJob = true;
        } else {
            selectedLevels.forEach(function(level) {
                if (level === 'entry' && experience <= 1) showJob = true;
                if (level === 'mid' && experience >= 2 && experience <= 3) showJob = true;
                if (level === 'senior' && experience >= 4 && experience <= 5) showJob = true;
                if (level === 'executive' && experience >= 6) showJob = true;
            });
        }
        job.style.display = showJob ? '' : 'none';
    });
    updateNoJobsMessage();
}

// Update "No jobs found" message
function updateNoJobsMessage() {
    const visibleJobs = document.querySelectorAll('#jobsContainer .job-item:not([style*="display: none"])');
    const container = document.getElementById('noJobsMessageContainer');

    // Clear previous message
    container.innerHTML = '';

    // Only show the message if there are no visible jobs AND there are jobs in the category initially
    if (visibleJobs.length === 0 && $('#jobsContainer .job-item').length > 0) {
        const message = document.createElement('div');
        message.className = 'alert alert-info text-center';
        message.textContent = 'No jobs found matching your criteria.';
        container.appendChild(message);
    }
}
</script>
@endsection