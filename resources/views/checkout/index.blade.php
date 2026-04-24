@extends('admin.layouts.master')
@section('title','Checkout')
@section('content')
@php 
if($addon){
  $name = "addon_id";
  $value = $addon_id;
  $type = 3;
}else{
  $name = "plan_id";
  $value = $plan->id;
  $type = request()->type;
}
@endphp
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title">
        <h2><i class="subscription-black"></i>Checkout</h2>
    </div>
     <div class="subscription-detail">
        <div class="row my-5">
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-body p-5">                      
                        <form id='checkout-form' method='post' action="{{route('stripe.charge')}}">   
                            @csrf             
                            <input type='hidden' name="stripeToken" id="stripe-token-id">                              
                            <input type='hidden' name="amount" value="{{$amount}}">
                            <input type='hidden' name={{$name}} value="{{$value}}">
                            <input type='hidden' name="type" value="{{$type}}">
                            <h3 class="mb-3">Please enter billing address:</h3>
                            <div class="row mb-3">
                                <div class="col-6">
                                  <label class="form-label">First Name<span class="text-danger">*</span></label>
                                  <div class="form-group">
                                    <input id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" type="text" value="{{ $user->first_name }}" required>
                                  </div>
                                  @error('first_name')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="col-6">
                                  <label class="form-label">Last Name<span class="text-danger">*</span></label>
                                  <div class="form-group">
                                    <input id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" type="text" value="{{ $user->last_name }}" required>
                                  </div>
                                  @error('last_name')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div>
                                    <label class="form-label">Street Address<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                      <input id="street" name="street" class="form-control @error('street') is-invalid @enderror" type="text" value="{{ old('street') ?? $user->street }}" required>                                      
                                    </div>
                                    @error('street')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                            </div>
                            <div class="row mb-3">
                                 <div class="col-6">
                                  <label class="form-label">City<span class="text-danger">*</span></label>
                                  <div class="form-group">
                                    <input id="city" name="city" class="form-control @error('city') is-invalid @enderror" type="text" value="{{ old('city') ?? $user->city }}" required>
                                  </div>
                                  @error('city')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="col-6">
                                  <label class="form-label">State/Province<span class="text-danger">*</span></label>
                                  <div class="form-group">
                                    <input id="state" name="state" class="form-control @error('state') is-invalid @enderror" type="text" value="{{ old('state') ?? $user->state }}" required>
                                  </div>
                                  @error('state')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                            </div>    
                            <div class="row mb-3">
                                 <div class="col-6">
                                  <label class="form-label">Postal Code<span class="text-danger">*</span></label>
                                  <div class="form-group">
                                    <input id="pincode" name="pincode" class="form-control @error('pincode') is-invalid @enderror" type="text" value="{{ old('pincode') ?? $user->pincode }}"  required>
                                  </div>
                                  @error('pincode')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="col-6">
                                  <label class="form-label">Country<span class="text-danger">*</span></label>
                                  <div class="form-group">
                                   <select name="country" id="country" class="form-control form-select" aria-label="country" required>
                                      <option>Select Country</option>    
                                    @foreach(['Australia','India'] as $country)
                                      <option value="{{$country}}" @if($country==$user->country) selected @endif>{{$country}}</option>      
                                    @endforeach
                                    </select>
                                  </div>
                                  @error('state')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                            </div> 
                            <div id="card-element" class="form-control" ></div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <a class="btn btn-secondary me-2" href="/subscription" style="width:48%;">Back</a>
                                    <button id="pay-btn" class="btn btn-success w-50" type="button" onclick="createToken()">PAY {{$amount}}
                                    </button>
                                </div>
                            </div>                            
                        <form>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>                
@endsection
@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('pk_test_GV2L0G9f5AtUJiyhO9SqF1oa00yXdJfJhD');
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');  
    function createToken() {
        $('.loader').hide();
        document.getElementById("pay-btn").disabled = true;
        stripe.createToken(cardElement).then(function(result) {                   
            if(typeof result.error != 'undefined') {
                document.getElementById("pay-btn").disabled = false;                
                Swal.fire("Error!",result.error.message,"error");
            }
            if(!$('#first_name').val() || !$('#last_name').val() || !$('#street').val() || !$('#city').val() || !$('#state').val() || !$('#pincode').val() || !$('#country').val()){
                Swal.fire("Error!","Please fill all required details","error");
                document.getElementById("pay-btn").disabled = false;       
                return false;  
            }
            if(typeof result.token != 'undefined') {
                $('.loader').show();
                document.getElementById("stripe-token-id").value = result.token.id;
                document.getElementById('checkout-form').submit();
            }
        });
    }
    /********* Validation start from here ***********/
 var createform = $('#checkout-form');
    createform.validate({
        ignore: [],
        rules: {
            first_name: { required: true,minlength: 3},
            last_name: { required: true,minlength: 3},
            street: { required: true,minlength: 3},
            city: { required: true,minlength: 3},
            state: { required: true,minlength: 3},
            pincode: { required: true,minlength: 3},
            country: { required: true},
        },
        submitHandler: function(form) {
           form.submit();
        }
    });
</script>
@endsection