<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencySubscriptionAddon extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function addon(){
        return $this->hasOne(PlansAddon::class,'id','addon_id');
    }
}
