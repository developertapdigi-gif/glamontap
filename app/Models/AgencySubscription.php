<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionPlans as Plan;
use Carbon\Carbon;
class AgencySubscription extends Model
{
    use HasFactory;    
    protected $guarded = [];
    CONST TYPE = [1=>'Monthly',2=>'Yearly',3=>'Add-on'];    

    public function plan(){
        return $this->hasOne(SubscriptionPlans::class,'id','plan_id');
    }
    public function agency(){
        return $this->hasOne(User::class,'id','agency_id');
    }
    public function getById($id)
    {
        return self::where('plan_id',$id)->where('agency_id',Auth::user()->id)->first();
    }
    public function getByAgencyId()
    {
        return self::where('agency_id',Auth::user()->id)->first();
    }

    public function getStatus($status){
        if($status == 1){
            return "<a class='skill-activate'>Paid</a>";
        }else{
            return "<a class='skill-red-warning'>Pending</a>";
        }
    } 
    public function isUpgradeAvailable(){
        $agencyId = Auth::user()->id;
        $activePlan = AgencySubscription::where('agency_id',$agencyId)
            ->where('payment_status',1)
            ->whereDate('end_date','>=',Carbon::today()) 
            ->first();
        $status = false;
        if($activePlan){
            $getHeigherPlans = Plan::where('status',1)->whereRaw('id!='.$activePlan->plan_id)
                ->pluck('id')
                ->toArray();
            if($getHeigherPlans){
                $status = $getHeigherPlans;
            }
        }  
        //print_r($status);die;     
        return $status;
    }
}
