@extends('website.layouts.master')
@section('title','Checkout Success')
@section('content')
<div class="container wh-100 my-5 py-5">
  <div class="row">
      <div class="col-12">
        <div class="success">  
          <div>
              <img src="{{asset('images/success.svg')}}">  
          </div>              
          <div class="payment_success">
            <h1 class="text-success">Congratulations!.</h1>
            <p class="py-2">Your subscription payment was successful! You can view your subscription benefits <a href="{{ route('subscription.index') }}">here.</a></p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-right-margin">Dashboard</a>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection