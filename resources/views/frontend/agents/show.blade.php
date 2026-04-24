@extends('frontend.layouts.master')

@section('title')
    {{ $model->first_name }} {{ $model->last_name }}
@endsection
@section('content')
<div class="container-fluid mt-3">
      <!-- Table -->
      <div class="row">
        <div class="col">
			<div class="card">
				<div class="card-header bg-primary primary">
				<div>
					Employee: {{ $model->first_name }} {{ $model->last_name }}					
				</div>				
				</div>
				<div class="card-body">
					<div class="table-responsive detailpage">
					  <table class="table text-left">				  	
					 	<tr>
					      <th>First Name</th>
					      <td>{{$model->first_name}}</td>
					    </tr>
					    <tr>
					      <th>Last Name</th>
					      <td>{{$model->last_name}}</td>
					    </tr>
					    <tr>
					      <th>Email</th>
					      <td>{{$model->email}}</td>
					    </tr>
					     <tr>
					      <th>Mobile</th>
					      <td>{{$model->mobile}}</td>
					    </tr>
					  </table>
					</div>
				</div>
				 <div class="card-footer text-muted">
					<div class="col-4 text-right">
                        <a href="{{ route('agent.index') }}" class="btn btn-sm btn-primary">Back to list</a>
                    </div>
  				</div>
			</div>
        </div>
      </div>
  </div>
@endsection
