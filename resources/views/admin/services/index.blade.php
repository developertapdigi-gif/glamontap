@extends('admin.layouts.master')

@section('title','Services')

@section('content')

<div class="container-fluid middle-content dashboard-content">

```
<div class="page-title mobile-page-title pb-3">
    <h2 class="desktop-content">
        <i class="skill-black"></i> Services
    </h2>

    <div class="middle-title job-middle-title"></div>

    <h2 class="mobile-content">
        <i class="skill-black"></i> Services
    </h2>
</div>

<div class="d-flex justify-content-between pb-2">

    <a href="{{ route('service.create') }}" class="btn btn-primary">
        Add New
    </a>

    <span>
        Showing {{ $services->total() }} Service Results
    </span>

</div>

<div class="skill-table-heading">

    <div class="table-responsive-lg">
        <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list">

            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Service Name</th>
                    <th>Type</th>
                    <th>Parent Category</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($services as $service)

                <tr>

                    {{-- <td>{{ $service->id }}</td> --}}

                    <td>{{ $service->service_name }}</td>

                    <td>
                        <span class="badge bg-info">
                            {{ ucfirst($service->type) }}
                        </span>
                    </td>

                    <td>
                        {{ $service->parent->service_name ?? '-' }}
                    </td>

                    <td>
                        @if($service->status)
                            <span class="badge bg-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Inactive
                            </span>
                        @endif
                    </td>

                    <td>

                        <a href="{{ route('service.edit',$service->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('service.destroy',$service->id) }}"
                              method="POST"
                              style="display:inline-block">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this service?')">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="text-center">
                        No services found.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>
    </div>

    <div class="skill-table-pagintion d-flex">
        {{ $services->links() }}
    </div>

</div>
    

</div>
@endsection
