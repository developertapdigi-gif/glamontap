@extends('admin.layouts.master')

@section('title')
    {{ $model->first_name }} {{ $model->last_name }}
@endsection
@section('content')
<div class="container-fluid mt-3">
      <!-- Table -->
      <div class="row">
        <div class="col">
			<div class="card">
				<div class="card-header bg-primary primary text-white">				
					Skill Category: {{ $model->name }}				
				</div>
				<div class="card-body">
					<div class="table-responsive detailpage">
					  <table class="table text-left">
					 	<tr>
					      <th>Name</th>
					      <td>{{$model->name}}</td>
					    </tr>

                        <tr>
                            <th>Status</th>
                            <td>{{ $model->getStatusValue($model->status) }}</td>
                          </tr>
					  </table>
					</div>
				</div>
				 <div class="card-footer text-muted">
					<div class="col-4 text-right">
                        <a href="{{ route('skill-categories.index') }}" class="btn btn-sm btn-primary">Back to list</a>
                    </div>
  				</div>
			</div>
        </div>
      </div>
  </div>
@endsection
