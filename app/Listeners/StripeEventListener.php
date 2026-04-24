<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Events\WebhookReceived;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\SubscriptionPlans as Plan;
use App\Models\{User,AgencySubscription,SubscriptionTransaction,PlansAddon,SubscriptionPlans,AgencySubscriptionAddon};
use App\Mail\Invoice;
use Carbon\Carbon;
use Laravel\Cashier\{Subscription,Cashier};
class StripeEventListener
{
   
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'invoice.payment_succeeded') {
            try{
                 Log::info('Stripe payment_succeeded:', [
                    'status' => 400,
                    'body' =>$event->payload,
                ]);
                $lineData   = $event->payload['data']['object']['lines']['data'][0];             
                # start and end date 
                $start_date = date('Y-m-d H:i:s',$lineData['period']['start']);
                $end_date   = date('Y-m-d H:i:s',$lineData['period']['end']);
                # get plan details 
                $planData   = $lineData['plan'];
                $productId  = $planData['product'];                
                $stripeId   = $event->payload['data']['object']['customer'];
                $subType    = $planData['interval'] == 'month' ? 1 : 2;

                $plan       = Plan::where('stripe_product_id',$productId)->first();
                $user       = User::where('stripe_id',$stripeId)->first();
                
                $activeSub = AgencySubscription::where('agency_id',$user->id)
                            ->where('payment_status',1)
                            ->whereDate('end_date','>=',Carbon::today()) 
                            ->first();
                if($subType==1){           
                       $job_limit = $plan->job_limit;
                       $tradesman_limit = $plan->tradesman_limit;
                }else{
                       $job_limit = $plan->job_limit * 12; 
                       $tradesman_limit = $plan->tradesman_limit*12;
                }
                if($activeSub){
                    $subscriptions = Subscription::query()->active()->get();
                    if(count($subscriptions)){
                        $monthId = $plan->stripe_monthly_price_id;
                        $yearId = $plan->stripe_yearly_price_id;
                        foreach($subscriptions as $_subscription){
                            if($_subscription->user_id == $user->id && ($monthId!=$_subscription->stripe_price && $yearId!=$_subscription->stripe_price)){
                                $_subscription->cancel();
                            }
                        }
                    }
                    $activeSub->tradesman_limit     = $activeSub->tradesman_limit+$tradesman_limit;
                    $activeSub->job_limit           = $activeSub->job_limit+$job_limit;
                    $activeSub->subscription_type   = $subType;
                    $activeSub->plan_id             = $plan->id;
                    $start_date                     = date('Y-m-d H:i:s',strtotime($activeSub->end_date.' 1 day'));
                    if($subType==1){           
                       $end_date   = date('Y-m-d H:i:s',strtotime("$start_date + 1 months")); 
                       $job_limit = $plan->job_limit;
                       
                    }else{
                       $end_date   = date('Y-m-d H:i:s',strtotime("$start_date + 12 months"));
                       $job_limit = $plan->job_limit * 12; 
                    }
                    $activeSub->end_date    = $end_date;
                    $activeSub->amount      = ($planData['amount']/100)+$activeSub->amount;
                    $activeSub->save();
                }else{
                    $activeSub = AgencySubscription::create([            
                        'agency_id'=>$user->id,
                        'plan_id'=>$plan->id,
                        'payment_status'=>1,          
                        'tradesman_limit'=>$tradesman_limit,
                        'job_limit'=>$job_limit,
                        'subscription_type'=>$subType,
                        'amount'=>($planData['amount']/100),
                        'used_job_qty'=>0,
                        'used_tradesman_qty'=>0,
                        'start_date'=>$start_date,
                        'end_date'=>$end_date,
                    ]);                   
                }
                $transaction = SubscriptionTransaction::create([
                    'agency_id'=>$user->id,
                    'plan_id'=>$plan->id,
                    'subscription_id'=>$activeSub->id,
                    'transaction_id'=>$event->payload['data']['object']['charge'],
                    'additional_information'=>json_encode($event->payload),
                ]);
            }catch(\Exceptions $e){
               Log::info('Stripe payment_succeeded:', [
                    'status' => 400,
                    'body' =>$e->getMessage(),
                ]); 
            }
            $data = [
                'amount_paid' => ($planData['amount']/100),
                'plan_name' => $plan->name,
                'transaction_id'=>$transaction->transaction_id,
                'paid_date'=>date('d-m-Y',strtotime($activeSub->start_date))
            ];
            Mail::to($user->email)->send(new Invoice($data));   
        }else if ($event->payload['type'] === 'checkout.session.completed') {
                if(!preg_match('/addon=([^&]+)/', $event->payload['data']['object']['success_url'], $matches)){
                    return;
                }
                $addonId = $matches[1];
                $stripeId   = $event->payload['data']['object']['customer'];
                
                $user       = User::where('stripe_id',$stripeId)->first();
                $activeSub = AgencySubscription::where('agency_id',$user->id)
                ->where('payment_status',1)
                ->whereDate('end_date','>=',Carbon::today()) 
                ->first();
                if($activeSub){
                    $pay_plan = SubscriptionPlans::find(6);
                    $amount = 0;
                    foreach(explode("-",$addonId) as $addon_id){
                        $checkAddonPlan =PlansAddon::find($addon_id);
                        if($pay_plan){
                            $activeSub->plan_id     = $activeSub->plan_id;
                        }
                            if (str_contains($checkAddonPlan->name, 'Job Post') || str_contains($checkAddonPlan->name, 'job post') || str_contains($checkAddonPlan->name, 'Job post') || str_contains($checkAddonPlan->name, 'job Post')) {
                            $activeSub->job_limit = $activeSub->job_limit+1;
                        }
                        if(str_contains($checkAddonPlan->name, 'Candidate') || str_contains($checkAddonPlan->name, 'candidate')){
                            $activeSub->tradesman_limit = $activeSub->tradesman_limit+2;
                        }
                        //$amount = $amount + $checkAddonPlan->price;
                    }
                    $activeSub->addon_id     = $addonId;
                    $start_date         = date('Y-m-d H:i:s',strtotime($activeSub->end_date.' 1 day'));
                    if($activeSub->end_date < Carbon::today()){
                        $cal_date = date('Y-m-d H:i:s');
                        $activeSub->end_date = date('Y-m-d H:i:s',strtotime("$cal_date + 1 day"));
                    }
                    $amount = ($event->payload['data']['object']['amount_total'])/100;
                    $activeSub->amount      = $amount+$activeSub->amount;
                    $activeSub->save();
                    foreach(explode("-",$addonId) as $_addonId){
                        $agency_addon = AgencySubscriptionAddon::create([
                            'agency_subscription_id'=>$activeSub->id,
                            'addon_id'=>$_addonId,
                            'agency_id'=>$user->id,
                        ]);
                    }
                    $transaction = SubscriptionTransaction::create([
                        'agency_id'=>$user->id,
                        'plan_id'=>$pay_plan->id,
                        'subscription_id'=>$activeSub->id,
                        'transaction_id'=>$event->payload['data']['object']['payment_intent'],
                        'additional_information'=>json_encode($event->payload),
                    ]);
                }else{
                    if(!preg_match('/addon=([^&]+)/', $event->payload['data']['object']['success_url'], $matches)){
                        return;
                    }
                    $tradesman_limit = $job_limit = 0;                    
                    $addonId = $matches[1];
                    $pay_plan = SubscriptionPlans::find(6);
                    foreach(explode("-",$addonId) as $addon_id){
                        $checkAddonPlan =PlansAddon::find($addon_id);
                        if($checkAddonPlan->name == "Job posting")
                        //$job_limit = 1;
                        if (str_contains($checkAddonPlan->name, 'Job Post')) {
                            $job_limit = 1;
                        }
                        if(str_contains($checkAddonPlan->name, 'Candidate')){
                            $tradesman_limit = 2;
                        }
                    }
                    $start_date = date('Y-m-d H:i:s');
                    $end_date   = date('Y-m-d H:i:s',strtotime("+ 1 day")); 
                    $addon_id = $addonId;
                    $pay_plan = SubscriptionPlans::find(6);
                    $activeSub = AgencySubscription::create([            
                        'agency_id'=>$user->id,
                        'plan_id'=>$pay_plan->id,
                        'addon_id'=>$addon_id,
                        'payment_status'=>1,          
                        'job_limit'=>$job_limit,
                        'subscription_type'=>3,
                        'amount'=>($event->payload['data']['object']['amount_total'])/100,
                        'used_job_qty'=>0,
                        'tradesman_limit'=>$tradesman_limit,
                        'used_tradesman_qty'=>0,
                        'start_date'=>$start_date,
                        'end_date'=>$end_date,
                    ]);
                    foreach(explode("-",$addon_id) as $_addonId){
                        AgencySubscriptionAddon::create([
                            'agency_subscription_id'=>$activeSub->id,
                            'addon_id'=>$_addonId,
                            'agency_id'=>$user->id,
                        ]);
                    }
                    $transaction = SubscriptionTransaction::create([
                        'agency_id'=>$user->id,
                        'plan_id'=>$pay_plan->id,
                        'subscription_id'=>$activeSub->id,
                        'transaction_id'=>$event->payload['data']['object']['payment_intent'],
                        'additional_information'=>json_encode($event->payload),
                    ]);
                    $amount = $activeSub->amount;
                }   
                $data = [
                    'amount_paid' => $amount,
                    'plan_name' => $pay_plan->name,
                    'transaction_id'=>$transaction->transaction_id,
                    'paid_date'=>date('d-m-Y',strtotime($activeSub->start_date))
                ];
                Mail::to($user->email)->send(new Invoice($data));        
        }
    }
}
