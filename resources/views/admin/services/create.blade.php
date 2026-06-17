@extends('admin.layouts.master')

@section('content')

<div class="container">

    <h2>Add Service</h2>

    <form action="{{ route('service.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        @include('admin.services.form')

        <button class="btn btn-primary">
            Save Service
        </button>

        <a href="{{ route('service.index') }}"
           class="btn btn-secondary">
            Back
        </a>

    </form>

</div>

@endsection