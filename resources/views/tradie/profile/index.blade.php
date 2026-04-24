@extends('tradie.layouts.master')
@section('title') My Profile @endsection
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title">
        <h2><i class="profile-icon"></i> My Profile</h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="post-job white-background p-4 mb-4">
                <h5>Personal Info</h5>
                <form action="{{ route('tradie.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ $model->first_name }}">
                            @error('first_name')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ $model->last_name }}">
                            @error('last_name')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $model->email }}">
                            @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="mobile" class="form-control" value="{{ $model->mobile }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $model->address }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Skill Category</label>
                            <select name="skill_category_id" class="form-control form-select">
                                @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" {{ $model->skill_category_id == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>

            <div class="post-job white-background p-4">
                <h5>Change Password</h5>
                <form action="{{ route('tradie.profile.password') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Current Password</label>
                            <input type="password" name="current_password" class="form-control">
                            @error('current_password')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="white-background p-4 text-center">
                @php
                $pic = url('/').'/images/icons/Profile.svg';
                if($model->profile_picture && File::exists(public_path($model->profile_picture))){
                    $pic = asset($model->profile_picture);
                }
                @endphp
                <img src="{{ $pic }}" class="rounded-circle mb-3" width="100" height="100">
                <h5>{{ $model->first_name }} {{ $model->last_name }}</h5>
                <p class="text-muted">{{ $model->skillCategory->name ?? '-' }}</p>
                <p>{{ $model->address }}</p>
                <p>{{ $model->email }}</p>
                <p>{{ $model->mobile }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
