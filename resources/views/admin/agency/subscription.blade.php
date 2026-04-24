@extends('admin.layouts.master')
@section('title','My Subscription')
@section('content')
<div class="container-fluid middle-content dashboard-content">
    <div class="page-title mobile-page-title">
        <h2 class=""><i class="subscription-black"></i>Subscription</h2>
    </div>
@if($activeSubscription)
    <div class="subscription-detail">
        <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-12">
                <div class="border-sub-block">
                    <b>Plan Usage</b>
                    <div class="outer-planusage">
                    <div class="progress-container">
                    <svg class="progress-circle" width="80" height="80">
                <circle class="progress-bg" cx="40" cy="40" r="35"></circle>
                <circle class="progress-fill" cx="40" cy="40" r="35"></circle>
            </svg> 
                        <!-- <div class="half-circle percentage_dynamic"> -->
                             <p class="complete-per complete_percentage" id="percentageText">{{round($percentage)}}%</p></div>
                        
                        <div>
                            <p>Job Posting</p>
                            <p class="candidate-recommend">Candidate Recommendations</p>

                        </div>
                        <div class="sub-top-price">
                            <p class="job_posting">{{$activeSubscription->job_limit - $activeSubscription->used_job_qty}}</p>
                            <p class="candidate-recommend">{{$talent_matching}}</p>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-3 col-md-12">
                <div class="border-sub-block">
                    <b>Current Plan</b>
                    <!-- <p class="mt-2">{{$activeSubscription->plan->name}}</p> -->
                    <p class="current-plan">Plan Start Date - <b>{{date('d-m-Y',strtotime($activeSubscription->start_date))}}</b></p>
                    <p>Plan End Date - <b>{{date('d-m-Y',strtotime($activeSubscription->end_date))}}</b></p>
                    <p>Renewal Date - <b>{{date('d-m-Y', strtotime($activeSubscription->end_date . ' +24 hours')); }}</b></p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-12">         
                <b>Need More Workers?</b>
                <p class="mt-2">Upgrade your plan to suit your projects</p>
                <p>Tradesmen Access: You can view portfolios of up to 5 tradies </p>
                <p><b class="blue-font mt-2">Upgrade Subscription</b></p>                
            </div>
        </div>   
    </div>
@else
<div class="subscription-detail">
    <div class="row">
        <div class="col-12">
            <h2 class="text-danger">Your agency doesn’t have an active subscription.</h2>
            <p class="d-inline-block mt-2 fw-bold">Please subscribe to get your exclusive benefits today.</p>
        </div>
    </div>
</div>
@endif
<div class="skill-sub-plan">
@php
    $agencySubModel = new \App\Models\AgencySubscription;
    $upgradeAble    = $agencySubModel->isUpgradeAvailable();
@endphp
    <div class="sub-plan-title">
        <h2>
            @if($upgradeAble)
                Upgrade your subscription plan    
            @elseif($activeSubscription && !$upgradeAble)
                You are already on a higher plan
            @elseif(!$activeSubscription && $expiredSubscription)        
                Renew your subscription plan   
            @else  
                Subscribe a plan 
            @endif           
        </h2>        
        <div class="sub-plan-btns">
            @php             
            if($activeSubscription && $activeSubscription->subscription_type==2){
                $subscription_type = $activeSubscription->subscription_type;
                $yearlyactiveClass = 'plan-blue-button';
                $yearlywhiteClass = '';
                $monthlyactiveClass = '';
                $monthlywhiteClass =  'plan-white-button';
            }else{
                $subscription_type = 1;
                $yearlyactiveClass = 'plan-white-button';
                $yearlywhiteClass = '';
                $monthlyactiveClass = '';
                $monthlywhiteClass =  'plan-blue-button';
            }
            @endphp
            <input type="hidden" id="subscription_type" value="{{$subscription_type}}">
            <button class="monthly-button {{$monthlyactiveClass}} {{$monthlywhiteClass}}" id="monthly" data-type="1">Monthly</button>
            <button class="yearly-button {{$yearlyactiveClass}} {{$yearlywhiteClass}}" id="yearly" data-type="2">Yearly</button>
            
        </div>
    </div>
    <div class="row equal-height-row d-flex flex-wrap">  
    @foreach($plans as $_plan)   
        <div class="col-md-4 my-2">
            <div class="sub-service agency-sub-service">
                <div class="title"><i class="fas {{$_plan->class_name}}-tag"></i>
                    <h3>{{$_plan->name}}</h3>
                </div>
                <div class="package-detail {{$_plan->class_name}}-plan-detail">
                
                    {!! $_plan->description !!}
                    
                </div>
                <div class="package-bottom-detail {{$_plan->class_name}}-plan-desc">
                    @php
                        $twelveMonthFees = $_plan->monthly_price*12;
                        $savingAmount    = (($twelveMonthFees - $_plan->yearly_price) / ($twelveMonthFees)) * 100;
                        
                        if(($activeSubscription && $activeSubscription->subscription_type==2)){
                            $subscriptionType = 2;
                            $price = number_format($_plan->yearly_price,0);
                            $yearlyclass = "";
                            $monthclass = "d-none";
                        }else{
                            $subscriptionType = 1;
                            $price = number_format($_plan->monthly_price,0);
                            $yearlyclass = "d-none";
                            $monthclass = "";
                        }
                    @endphp
                    <b id="monthly_price" class="{{$monthclass}}">${{number_format($_plan->monthly_price,0)}}</b>
                    <b id="yearly_price" class="{{$yearlyclass}}">${{number_format($_plan->yearly_price,0)}}</b>    
                    <p><!-- Annually Save {{ number_format($savingAmount,2) }}% --></p>
                    @if($_plan->name == 'Starter Plan' || $_plan->name == 'starter plan')
                    <p class="yearly_price"><small>Avail all the features of the {{$_plan->name}} for a year at a discounted rate.</small></p>
                    @elseif($_plan->name == 'Growth Plan' || $_plan->name == 'growth plan')
                    <p class="yearly_price"><small>Avail all the features of the {{$_plan->name}} for a year at a discounted rate.</small></p>
                    @elseif($_plan->name == 'Premium Plan' || $_plan->name == 'premium plan')
                    <p class="yearly_price"><small>Avail all the features of the {{$_plan->name}} for a year at a discounted rate.</small></p>
                    @endif

                    @if($activeSubscription && $_plan->id==$activeSubscription->plan_id && $activeSubscription->subscription_type==$subscriptionType)
                    <a href="{{ route('unSubscribe') }}"><button class="btn-primary btn-subscription unsubscribe_active" id="btn_subscription_{{$_plan->id}}">UnSubscribe</button></a>
                    <button class="btn-primary btn-subscription unsubscribe_update d-none" id="btn_subscription_{{$_plan->id}}" onclick="SubscribeNow({{$_plan->id}})">Upgrade Plan</button>
                    @elseif($pendingSubscription && $_plan->id==$pendingSubscription->plan_id && $pendingSubscription->payment_status==0)
                        <button class="btn-primary btn-subscription" id="btn_subscription_{{$_plan->id}}" disabled>In Review</button>
                    @elseif($pendingSubscription && $_plan->id==$pendingSubscription->plan_id && $pendingSubscription->payment_status==2)
                         <button class="btn-primary btn-subscription" id="btn_subscription_{{$_plan->id}}" disabled>Rejected</button>
                    @endif
                    

                    @if(!$activeSubscription && !$pendingSubscription)
                        <button class="btn-primary btn-subscription" id="btn_subscription_{{$_plan->id}}" onclick="SubscribeNow({{$_plan->id}})">Choose Plan</button>
                    @elseif($upgradeAble && in_array($_plan->id,$upgradeAble))
                        <button class="btn-primary btn-subscription" id="btn_subscription_{{$_plan->id}}" onclick="SubscribeNow({{$_plan->id}})">Upgrade Plan</button>
                    @endif
                </div>
            </div>
        </div> 
    @endforeach
    <div class="col-md-4">
                <div class="sub-service agency-sub-service">
                    <div class="title"><i class="fas brown-tag"></i>
                        <h3>Pay-as-you-go</h3>
                    </div>
                    <form id="pay-as-you-form">
                    @csrf
                    <div class="package-detail brown-plan-detail brown_plan">
                    
                    @foreach($addonplans as $_aplans)
                        <div> <input type="checkbox" name="amount" data-planid="{{$_aplans->id}}" value="    {{$_aplans->price}}">{{$_aplans->name}}: ${{$_aplans->price}}</div>
                    @endforeach                    
                    </div>
                    <div class="package-bottom-detail brown-plan-desc">                            
                       <button class="btn-primary" type="submit">Choose</button>
                    </div>
                    </form>
                </div>
            </div>
    </div>
</div>                
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
      $('#pay-as-you-form').submit(function(e){
        e.preventDefault();

        var amount = $('input[name="amount"]:checked').map(function() {
                    return this.value;
                }).get();
                var id = $('input[name="amount"]:checked').map(function() {
                    return this.getAttribute('data-planid');
                }).get();
                console.log(amount.length);
                console.log(id); 
                if(amount.length == 0){
                    Swal.fire("Warning!", "Please select atleast one option.",
                                "error");
                }else{
                    window.location.href = "{{route('stripe.checkout')}}"+'?id='+id+'&type='+amount+'&addon=1';
                }
      });  
      $('#monthly').click(function(){
        $('#subscription_type').val(1);
        $('#monthly').removeClass('plan-white-button').addClass('plan-blue-button');
        $('#yearly').removeClass('plan-blue-button').addClass('plan-white-button');       
        $('.package-bottom-detail #yearly_price').addClass('d-none');
        $('.package-bottom-detail #monthly_price').removeClass('d-none');
        $('.unsubscribe_update').removeClass('d-none');
        $('.unsubscribe_active').addClass('d-none');
        const element = document.querySelector('#monthly');
        const unsubscribe = document.querySelector('#btn_subscription_1');
        if (element.matches('.plan-blue-button') && unsubscribe.classList.contains('d-none')) {
            console.log('month');
            $('.unsubscribe_update').addClass('d-none');
            $('.unsubscribe_active').removeClass('d-none');
        }
    });
    $('#yearly').click(function(){
        $('#subscription_type').val(2);
        $('#yearly').removeClass('plan-white-button').addClass('plan-blue-button');
        $('#monthly').removeClass('plan-blue-button').addClass('plan-white-button');
        $('.unsubscribe_update').removeClass('d-none');
        $('.unsubscribe_active').addClass('d-none');
        const mainelement = document.querySelector('#yearly');
        const unsubscribe = document.querySelector('#btn_subscription_2');
        if (mainelement.matches('.plan-blue-button') && unsubscribe.classList.contains('d-none')) {
            console.log('year');
            $('.unsubscribe_update').addClass('d-none');
            $('.unsubscribe_active').removeClass('d-none');
        }
        const elements = document.querySelectorAll('#yearly_price');
        const elements1 = document.querySelectorAll('#monthly_price');
        elements.forEach(element => {
                element.classList.remove('d-none');  // Remove the old class
                elements1.forEach(element1 =>{
                    element1.classList.add('d-none');     // Add the new class
                });
            });
    });
    });
var token = "{{ csrf_token() }}";
function SubscribeNow(id) {
    if (id) {
        Swal.fire({
            text: "{{ __('Are you sure you want to subscribe this plan?') }}",
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, Submit",
            cancelButtonText: "No, Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-secondary",
            },
        }).then((result) => {
            if (result.isConfirmed) { 
                $('.loader').show();                    
                var type = $('#subscription_type').val();           
                window.location.href = "{{route('stripe.checkout')}}"+'?id='+id+'&type='+type;
            }
        });
    }
} 
function updateProgress() {
    let progressFill = document.querySelector(".progress-fill");
    let percentageText = document.getElementById("percentageText");

    let percentage = parseInt(percentageText.innerText.replace('%', ''), 10) || 0;

    percentage = Math.min(Math.max(percentage, 0), 100);

    let progress = (1 - percentage / 100) * 220;


    progressFill.style.strokeDashoffset = progress;
}

updateProgress();

const observer = new MutationObserver(updateProgress);
observer.observe(document.getElementById("percentageText"), { childList: true, subtree: true });

setInterval(updateProgress, 500);  
</script>
@endsection