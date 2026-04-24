<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class JobTradersComplaint extends Model
{
    use HasFactory;
    protected $table = 'task_traders_complaints';
    protected $guarded = [];

    public function agency(){
        return $this->hasOne(User::class,'id','agency_id');
    }
    public function trader(){
        return $this->hasOne(User::class,'id','trader_id');
    }
    public function job(){
        return $this->hasOne(Job::class,'id','task_id');
    }
}
