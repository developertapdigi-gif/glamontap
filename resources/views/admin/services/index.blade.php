@extends('admin.layouts.master')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h2>Services</h2>

        <a href="{{ route('services.create') }}" class="btn btn-primary">
            Add Service
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Service Name</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Status</th>
                <th width="180">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($services as $service)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        @if($service->image)
                            <img src="{{ asset('storage/'.$service->image) }}"
                                 width="60">
                        @endif
                    </td>

                    <td>{{ $service->service_name }}</td>

                    <td>${{ number_format($service->price,2) }}</td>

                    <td>{{ $service->duration }} Min</td>

                    <td>
                        @if($service->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>

                    <td>

                        <a href="{{ route('services.edit',$service->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form
                            action="{{ route('services.destroy',$service->id) }}"
                            method="POST"
                            style="display:inline-block">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Delete this service?')"
                                class="btn btn-danger btn-sm">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center">
                        No Services Found
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

    {{ $services->links() }}

</div>

@endsection