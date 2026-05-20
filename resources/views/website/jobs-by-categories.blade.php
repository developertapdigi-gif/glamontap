@extends('website.layouts.master-employer')

@section('title')
    Jobs
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @forelse($tasks as $task)
                <!-- Task Card -->
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
                                    style="width: 60px; height: 60px; object-fit: cover;"
                                >
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
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">Incentives</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">Overtime Pay</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">Salary in Bank</span>
                        </div>

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
            @endforelse
        </div>
    </div>
</div>
@endsection