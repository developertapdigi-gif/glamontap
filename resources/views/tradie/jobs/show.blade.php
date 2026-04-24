@extends('tradie.layouts.master')
@section('title') Job Detail @endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2>Job Detail</h2>
        <div class="right-title">
            <a href="{{ route('tradie.jobs.index') }}"><button class="primary-btn black-button">Back</button></a>
            @if($application && in_array($job->status, [4,5]))
            <form action="{{ route('tradie.jobs.withdraw') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <button type="submit" class="primary-btn blue-button" onclick="return confirm('Are you sure you want to withdraw?')">Withdraw</button>
            </form>
            @endif
            @if($application && in_array($application->status, [1, 3]))
            @if($application->status == 3)
            <span class="primary-btn" style="background:#28a745;color:#fff;cursor:default;"><i class="bi bi-check-circle-fill me-1"></i>Completed</span>
            @else
            <form action="{{ route('tradie.jobs.complete', $job->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="primary-btn blue-button" {{ now()->lte($job->end_date) ? 'disabled' : '' }}>Mark Complete</button>
            </form>
            @endif
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="post-job white-background p-4">
                @if($application && $application->status == 3)
                <div class="d-flex align-items-center mb-3 p-3" style="background:#d4edda;border-radius:8px;border:1px solid #c3e6cb;">
                    <i class="bi bi-check-circle-fill me-2" style="color:#28a745;font-size:22px;"></i>
                    <div>
                        <b style="color:#155724;">You have marked this job as completed.</b>
                        <p class="mb-0" style="color:#155724;font-size:13px;">Waiting for company confirmation.</p>
                    </div>
                </div>
                @endif
                <h4>{{ $job->title }}</h4>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <b>Company</b>
                        <p>{{ $job->agency->agency_name ?? $job->agency->first_name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <b>Skill Category</b>
                        <p>{{ $job->SkillCategory->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <b>Location</b>
                        <p>{{ $job->location }}</p>
                    </div>
                    <div class="col-md-6">
                        <b>Experience Range</b>
                        <p>{{ $job->experience_range }}</p>
                    </div>
                    <div class="col-md-6">
                        <b>Start Date</b>
                        <p>{{ date('d M Y', strtotime($job->start_date)) }}</p>
                    </div>
                    <div class="col-md-6">
                        <b>End Date</b>
                        <p>{{ date('d M Y', strtotime($job->end_date)) }}</p>
                    </div>
                    <div class="col-md-6">
                        <b>Payment Range</b>
                        <p>{{ $job->payment_range }}</p>
                    </div>
                    <div class="col-md-12 mt-2">
                        <b>Additional Notes</b>
                        <p>{{ $job->additional_notes ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Review Form (only for completed jobs) --}}
            @if($application && $job->status == 6)
            <div class="post-job white-background p-4 mt-3">
                <h5>{{ $review ? 'Update Your Review' : 'Rate this Company' }}</h5>
                <form action="{{ route('tradie.jobs.review') }}" method="POST">
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    <div class="mb-3">
                        <label>Rating</label>
                        <select name="rating" class="form-control" required>
                            @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ $review && $review->over_all_rating == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Comment</label>
                        <textarea name="comment" class="form-control" rows="3">{{ $review->comment ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ $review ? 'Update Review' : 'Submit Review' }}</button>
                </form>
            </div>

            {{-- Report Form --}}
            <div class="post-job white-background p-4 mt-3">
                <h5>Report Company</h5>
                <form action="{{ route('tradie.jobs.report') }}" method="POST">
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    <div class="mb-3">
                        <label>Reason</label>
                        <textarea name="comment" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Submit Report</button>
                </form>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="dashboard-table white-background p-4">
                <h5>Company Info</h5>
                @php
                $agency = $job->agency;
                $logo = url('/').'/images/icons/brand-logo2.png';
                if($agency && $agency->logo && File::exists(public_path($agency->logo))){
                    $logo = asset($agency->logo);
                }
                @endphp
                <img src="{{ $logo }}" height="60px" class="mb-3">
                <p><b>{{ $agency->agency_name ?? $agency->first_name ?? '-' }}</b></p>
                <p>{{ $agency->address ?? '-' }}</p>
                <p>{{ $agency->email ?? '-' }}</p>
                @if($agency)
                <a href="{{ route('user', $agency->id) }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                    <i class="bi bi-chat"></i> Message
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
