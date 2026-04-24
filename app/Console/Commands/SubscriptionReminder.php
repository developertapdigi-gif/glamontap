<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\{Subscription,Cashier};
use App\Mail\SubscriptionPaymentReminder;
use Carbon\Carbon;
class SubscriptionReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:subscription-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email to agencies for subscription payment';

    /**
     * Execute the console command.
     */
    public function handle()
    {      
        $now            = Carbon::now()->timestamp;
        $fiveDaysStart  = date('Y-m-d 00:00:00',Carbon::now()->addDays(5)->timestamp);
        $fiveDaysEnd    = date('Y-m-d 23:59:59',Carbon::now()->addDays(5)->timestamp);
        $subscriptions  = Subscription::where('stripe_status','active')
            ->whereBetween('ends_at',[$fiveDaysStart, $fiveDaysEnd])
            ->get();
        foreach ($subscriptions as $subscription) {           
            $user       = $subscription->user;
            $plan       = $user->activePlan->plan;
            $agencyName = $user->agency_name ?? $user->first_name;
            $endDate    = date('d-m-Y',strtotime($subscription->ends_at));
            if($user->activePlan->subscription_type==1){
                $amount = $plan->monthly_price;
            }else{
                $amount = $plan->yearly_price; 
            }
            Mail::to(trim($user->email))->send(new SubscriptionPaymentReminder($agencyName,$endDate,$amount));
        }
    }
}
