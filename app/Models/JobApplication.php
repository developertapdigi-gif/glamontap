<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Observers\JobApplicationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([\App\Observers\JobApplicationObserver::class])]
class JobApplication extends Model
{
    use HasFactory;
    protected $table = 'task_applications';
    protected $guarded = [];
    CONST STATUS = [
        0 =>'Pending',
        1 =>'Accepted',
        2 =>'Rejected',
        3 =>'Mark as Completed',
        4=>'Withdraw Bid'
    ];
  
    public function trader()
    {
        return $this->belongsTo(User::class, 'bidder_id');
    }
    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }
    public function job()
    {
        return $this->belongsTo(Job::class,'task_id');
    } 
    public function jobTraderCompleted()
    {
        return $this->hasOne(Job::class,'id','task_id')->where('tasks.status',6);
    }
}
