@extends('website.layouts.master')
@section('title','Checkout Success')
@section('content')
<div class="container wh-100 my-5 py-5">
  <div class="row">
    <div class="col-12">
      <div class="success">
        <div class="">
          <img src="{{asset('images/failed.svg')}}">
      </div>
      <div class="payment_success pay_failed">
        <h4>Payment Failed</h4>
        <p>Your subscription payment was unsuccessful! Please check your payment details and try again</p>
        <a href="{{ route('subscription.index') }}" class="btn btn-primary btn-right-margin">Dashboard</a>
      </div>
  </div>
</div>
</div>
</div>
@endsection