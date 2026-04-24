<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlans extends Model
{
    use HasFactory;
    protected $guarded = [];
    CONST STATUS = [1=>'Enable',0=>'Disable'];
    CONST CLASSNAME = ['red'=>'Red','blue'=>'Blue','yellow'=>'Yellow','mustard'=>'Mustard','brown'=>'Brown','green'=>'Green'];

    public function AgencySubscription(){
        return $this->hasMany(AgencySubscription::class,'plan_id','id');
    }
    
}
