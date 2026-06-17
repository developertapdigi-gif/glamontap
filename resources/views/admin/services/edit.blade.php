@extends('admin.layouts.master')

@section('content')

<div class="container">

    <h2>Edit Service</h2>

    <form action="{{ route('service.update',$service->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('admin.services.form')

        <button class="btn btn-success">
            Update Service
        </button>

        <a href="{{ route('service.index') }}"
           class="btn btn-secondary">
            Back
        </a>

    </form>

</div>

@endsection