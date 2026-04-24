<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubscriptionPlans as Plan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\{AgencySubscription,PlansAddon,User,AgencySubscriptionAddon};
use Carbon\Carbon;
class AgencySubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if($user->user_type == User::ROLE['agency']){
            $activeSubscription = AgencySubscription::where('agency_id',$user->id)
                ->where('payment_status',1)
                ->whereDate('end_date','>=',Carbon::today()) 
                ->first();
            $expiredSubscription = AgencySubscription::where('agency_id',$user->id)
                ->where('payment_status',1)
                ->whereDate('end_date','<',Carbon::today()) 
                ->first();
            $pendingSubscription = AgencySubscription::where('agency_id',$user->id)
                ->whereNull('start_date')           
                ->first(); 
            $addonPlanssubscription = AgencySubscriptionAddon::where('agency_id',$user->id)->get();
            $jobposting = $talentmatching = $optimisation = 0;
            foreach($addonPlanssubscription as $_addon){
                $addonsubscription = PlansAddon::find($_addon->addon_id);
                if($_addon->addon_id == 3){
                    $jobposting += $addonsubscription->price;
                }else if($_addon->addon_id == 4){
                    $talentmatching += $addonsubscription->price;
                }else if($_addon->addon_id == 5){
                    $optimisation += $addonsubscription->price;
                }
            }            
            $percentage = $talent_matching = $slot_optimisation = 0;
            if($activeSubscription){
                if($activeSubscription->job_limit){
                $percentage = (($activeSubscription->job_limit - $activeSubscription->used_job_qty)/$activeSubscription->job_limit)*100;
                }
                if(in_array($activeSubscription->plan_id,[1,2])){
                    $talent_matching = $activeSubscription->tradesman_limit??0;
                    if($activeSubscription->plan_id == 2){
                        $slot_optimisation = 1;
                    }
                }elseif($activeSubscription->plan_id == 3){
                    $talent_matching = 2;
                    $slot_optimisation = 5;
                }
                $activeSubscriptionaddon = AgencySubscription::where('agency_id',$user->id)
                ->where('payment_status',1)
                ->whereDate('plan_id','=',6) 
                ->first();
 
                $slotsubscription = $activeaddonSubscription = AgencySubscriptionAddon::where('agency_id',$user->id)->where('agency_subscription_id',$activeSubscription->id); 
                /* if($activeaddonSubscription){
                    //$talent_matching += 2*$activeaddonSubscription->where('addon_id',4)->count();
                    $talent_matching = $activeSubscription->tradesman_limit??0;

                } */if($slotsubscription){
                    $slot_optimisation += AgencySubscriptionAddon::where('agency_id',$user->id)->where('agency_subscription_id',$activeSubscription->id)->where('addon_id',5)->count();
                }
            }
               
            $plans = Plan::where('status',1)->orderby('id', 'asc')->paginate(10);
            $addonplans = PlansAddon::where('status',1)->orderby('id', 'asc')->paginate(10);
            return view('admin.agency.subscription',compact('plans','addonplans','activeSubscription','expiredSubscription','pendingSubscription','jobposting','talentmatching','optimisation','percentage','talent_matching','slot_optimisation'));
        }elseif($user->user_type == User::ROLE['admin']){     
            return redirect('plans');
        }elseif($user->user_type == User::ROLE['agency_sub_user']){     
            return redirect('dashboard');
        }else{
            return redirect('user.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user       = Auth::user();  
        $plan       = Plan::find($request->id);
        $start_date = date('Y-m-d H:i:s');        

        if($request->type==1){           
            $end_date   = date('Y-m-d H:i:s',strtotime("+ 1 months"));
            $amount     = $plan->monthly_price;
        }else{
            $end_date   = date('Y-m-d H:i:s',strtotime("+ 12 months"));
            $amount     = $plan->yearly_price;
        }                         
        $activeSub = AgencySubscription::where('agency_id',$user->id)
            ->where('payment_status',1)
            ->whereDate('end_date','>=',Carbon::today()) 
            ->first();
        if($activeSub){
            $activeSub->tradesman_limit     = $activeSub->tradesman_limit+$plan->tradesman_limit;
            $activeSub->job_limit           = $activeSub->job_limit+$plan->job_limit;
            $activeSub->subscription_type   = $request->type;

            $start_date         = date('Y-m-d H:i:s',strtotime($activeSub->end_date.' 1 day'));      
            if($request->type==1){           
               $end_date   = date('Y-m-d H:i:s',strtotime("$start_date + 1 months")); 
            }else{
               $end_date   = date('Y-m-d H:i:s',strtotime("$start_date + 12 months")); 
            }
            $activeSub->end_date    = $end_date;
            $activeSub->plan_id     = $plan->id;
            $activeSub->amount      = $amount+$activeSub->amount;
            $activeSub->save();
        
        }else {    
            AgencySubscription::create([            
                'agency_id'=>$user->id,
                'plan_id'=>$request->id,
                'payment_status'=>1,          
                'tradesman_limit'=>$plan->tradesman_limit,
                'job_limit'=>$plan->job_limit,
                'subscription_type'=>$request->type,
                'amount'=>$amount,
                'used_job_qty'=>0,
                'used_tradesman_qty'=>0,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
            ]);
        }
        return response()->json([
            'status'=>200,
            'message'=>__('Your subscription has been submitted')
        ]); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
