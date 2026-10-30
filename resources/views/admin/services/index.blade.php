
@extends('admin.layouts.master')

@section('title', 'Services')

@section('content')

<div class="container-fluid middle-content dashboard-content">

    <div class="page-title mobile-page-title pb-3">

        <h2 class="desktop-content">
            <i class="skill-black"></i> Services
        </h2>

        <h2 class="mobile-content">
            <i class="skill-black"></i> Services
        </h2>

        <div class="d-flex justify-content-between">

            <a href="{{ route('service.create') }}"
               class="primary-btn blue-button me-0">
                Add New
            </a>

        </div>

    </div>

    <div class="skill-table-heading">

        <div class="table-responsive-lg">

            <table class="table align-middle table-row-dashed fs-6 gy-5 skill-table-list">

                <thead>
                    <tr>
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

                            <td>{{ $service->service_name }}</td>

                            <td>
                                <span class="badge" style="background-color: #ffeee0; color: #724726;">

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

                                <a href="{{ route('service.edit', $service->id) }}">
                                    <i class="skill-table-action bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('service.destroy', $service->id) }}"
                                      method="POST"
                                      style="display:inline-block">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-icon btn-sm btn-color-dark"
                                            onclick="return confirm('Delete this service?')">

                                        <i class="skill-table-action bi-trash3-fill"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                No services found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}

        @if($services->total() > 0)

            <div class="skill-table-pagintion d-flex justify-content-end align-items-center flex-wrap">

                {{-- <span class="pagination-results me-2">
                    Showing {{ $services->firstItem() }}
                    to {{ $services->lastItem() }}
                    of {{ $services->total() }} results
                </span> --}}

                {{ $services->onEachSide(0)->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
