@extends('admin.layouts.master')
@section('title')
   SMTP Settings
@endsection
@section('content')

    <div class="container-fluid middle-content dashboard-content">
        <div class="page-title">
            <h2 class="desktop-content"><i class="setting-black"></i>SMTP Settings</h2>

            <h2 class="mobile-content"><i class="setting-black"></i>SMTP Settings</h2>
        </div>
      <div class="skill-reg-form">
        <form id="createform" class="regular-form" action="{{ route('setting.maileditpost',$model->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PATCH')
              <div class="row">
                <div class="col-6">
                  <label class="form-label">SMTP Username<span class="text-danger">*</span></label>
                  <div class="input-group">
                  <input id="smtp_username" name="smtp_username" class="form-control @error('smtp_username') is-invalid @enderror" type="email" value="{{ $model->smtp_username }}">
                  </div>
                  @error('smtp_username')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-6">
                  <label class="form-label">SMTP Password<span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input id="smtp_password" name="smtp_password" class="form-control @error('smtp_password') is-invalid @enderror" type="password" value="{{ $model->smtp_password }}">
                  </div>
                  @error('smtp_password')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                  <label class="form-label">SMTP From Email<span class="text-danger">*</span></label>
                  <div class="input-group">
                  <input id="smtp_from_address" name="smtp_from_address" class="form-control @error('smtp_from_address') is-invalid @enderror" type="email" value="{{ $model->smtp_from_address }}">
                  </div>
                  @error('smtp_from_address')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
              <div class="col-6">
                <label class="form-label">SMTP Host<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="smtp_host" name="smtp_host" class="form-control @error('smtp_host') is-invalid @enderror" type="text" value="{{ $model->smtp_host }}" >
                </div>
                @error('smtp_host')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>     
              </div>         
            
            <div class="row">   
                   <div class="col-6">
                <label class="form-label">SMTP Port<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input id="smtp_port" name="smtp_port" class="form-control @error('smtp_port') is-invalid @enderror" type="text" value="{{ $model->smtp_port }}" >
                </div>
                @error('smtp_port')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
                <div class="col-6">
                  <label class="form-label">SMTP Encryption<span class="text-danger">*</span></label>
                  <div class="input-group">
                  <input id="smtp_encryption" name="smtp_encryption" class="form-control @error('smtp_encryption') is-invalid @enderror" type="text" value="{{ $model->smtp_encryption }}" >
                  </div>
                  @error('smtp_encryption')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>            
             </div>            
            <div class="mt-5">
                <button class="btn btn-primary" type="submit">Save Changes</button>
            </div>
          </form>
        </div>
    </div>
@endsection