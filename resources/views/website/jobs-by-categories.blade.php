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
    <h2>
        @if(isset($skill) && $skill)
            {{ $skill->name }} Jobs
        @else
            All Jobs
        @endif
    </h2>
</div>

<div class="container">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-lg-4" data-aos="fade-right">

            {{-- Explore All Jobs Button --}}
            {{-- <div class="bg-white border rounded-3 p-4 mb-4 text-center">
                <a href="{{ route('skills.details') }}"
                   class="btn got-btn got-btn-primary btn-primary got-rounded-pill got-py-3 got-fw-bold shine-effect w-100">
                    Explore All Jobs
                </a>
            </div> --}}

            {{-- Categories --}}
            {{-- <div class="bg-white border rounded-3 p-4 mb-4">
                <h6 class="fw-semibold mb-3">Job Categories</h6>

                @foreach($allSkills as $item)
                    <div class="mb-2">
                        <a href="{{ route('skills.details', ['skillId' => $item->id]) }}"
                           class="text-decoration-none">
                            {{ $item->name }}
                        </a>
                    </div>
                @endforeach
            </div> --}}

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
                    <label class="form-check-label" for="exp1">
                        Entry Level
                    </label>
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input experience-filter"
                        type="checkbox"
                        value="mid"
                        id="exp2">
                    <label class="form-check-label" for="exp2">
                        Mid Level
                    </label>
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input experience-filter"
                        type="checkbox"
                        value="senior"
                        id="exp3">
                    <label class="form-check-label" for="exp3">
                        Senior Level
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input experience-filter"
                        type="checkbox"
                        value="executive"
                        id="exp4">
                    <label class="form-check-label" for="exp4">
                        Executive
                    </label>
                </div>
            </div>

        </div>

        {{-- Jobs Listing --}}
        <div class="col-lg-8" data-aos="fade-left">

            {{-- Category Tasks --}}
            @if(isset($skill) && $skill)

                <div class="row">

                    @forelse($taskByCategory as $task)

                        <div class="col-12 mb-3 job-item" data-location="{{ strtolower($task->location ?? '') }}" 
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
                                        ₹{{ number_format($task->minimum_price ?? 0, 2) }}
                                        -
                                        ₹{{ number_format($task->maximum_price ?? 0, 2) }}
                                    </p>
                                </div>

                            </div>
                        </div>

                    @empty

                        <div class="col-12">
                            <div class="alert alert-info">
                                No jobs found in this category.
                            </div>
                        </div>

                    @endforelse

                </div>

            @else

                {{-- All Tasks --}}
                <div class="row">

                    @forelse($allTasks as $task)

                        <div class="col-12 mb-3 job-item" data-location="{{ strtolower($task->location ?? '') }}"
                            data-experience="{{ $task->experiance_range }}" >
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
                                        ₹{{ number_format($task->minimum_price ?? 0, 2) }}
                                        -
                                        ₹{{ number_format($task->maximum_price ?? 0, 2) }}
                                    </p>
                                </div>

                            </div>
                        </div>

                    @empty

                        <div class="col-12">
                            <div class="alert alert-info">
                                No jobs available.
                            </div>
                        </div>

                    @endforelse

                </div>

            @endif

        </div>

    </div>
</div>

@section('script')

<script>
$(document).ready(function () {

    console.log('jQuery Loaded');
    console.log('Input Found:', $('#jobSearchInput').length);
    console.log('Job Items Found:', $('.job-item').length);

    $('#jobSearchInput').on('keyup', function () {

        let value = $(this).val().toLowerCase();

        console.log('Searching:', value);

        $('.job-item').each(function (index) {

            let text = $(this).text().toLowerCase();

            console.log('Checking Job:', index, text);

            if (text.indexOf(value) > -1) {

                console.log('MATCH FOUND');

                $(this).show();

            } else {

                console.log('HIDDEN');

                $(this).hide();
            }
        });

    });

});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const locationFilter = document.getElementById('jobLocationInput');

    if (!locationFilter) {
        console.log('Location dropdown not found');
        return;
    }

    locationFilter.addEventListener('change', function (e) {

        e.preventDefault();

        let selectedLocation = this.value.toLowerCase().trim();

        console.log('Selected Location:', selectedLocation);

        document.querySelectorAll('.job-item').forEach(function(job) {

            let jobLocation = (
                job.dataset.location || ''
            ).toLowerCase();

            if (
                selectedLocation === '' ||
                selectedLocation === 'all locations' ||
                jobLocation.includes(selectedLocation)
            ) {
                job.style.display = '';
            } else {
                job.style.display = 'none';
            }

        });

    });

});


</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const checkboxes = document.querySelectorAll('.experience-filter');

    checkboxes.forEach(function(checkbox) {

        checkbox.addEventListener('change', function(e) {

            e.preventDefault();

            filterJobs();

        });

    });

});

function filterJobs() {

    let selectedLevels = [];

    document.querySelectorAll('.experience-filter:checked')
        .forEach(function(item) {

            selectedLevels.push(item.value);

        });

    console.log('Selected Levels:', selectedLevels);

    document.querySelectorAll('.job-item')
        .forEach(function(job) {

            let experience =
                parseInt(job.dataset.experience || 0);

            let showJob = false;

            // No checkbox selected = show all jobs
            if (selectedLevels.length === 0) {

                showJob = true;

            } else {

                selectedLevels.forEach(function(level) {

                    if (
                        level === 'entry' &&
                        experience <= 1
                    ) {
                        showJob = true;
                    }

                    if (
                        level === 'mid' &&
                        experience >= 2 &&
                        experience <= 3
                    ) {
                        showJob = true;
                    }

                    if (
                        level === 'senior' &&
                        experience >= 4 &&
                        experience <= 5
                    ) {
                        showJob = true;
                    }

                    if (
                        level === 'executive' &&
                        experience >= 6
                    ) {
                        showJob = true;
                    }

                });

            }

            job.style.display =
                showJob ? '' : 'none';

        });

}
</script>
@endsection