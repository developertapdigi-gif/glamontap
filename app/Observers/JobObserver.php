<?php

namespace App\Observers;

use App\Models\{Job,HomeFeed,User};

class JobObserver
{
    /**
     * Handle the Job "created" event.
     */
    public function created(Job $job): void
    {
        $agency = User::find($job->agency_id);
        $agency->completed_jobs = $this->getJobCount($job->agency_id);
        $agency->save();
        $premium = NULL;
        if($job->agency_id != 1){
            $planName = $agency->activePlan->plan->name;
            if(str_contains($planName, 'Premium') || str_contains($planName, 'Trail'))
            $premium = 1;
            #add Job in feed
            if(in_array($job->status,[1,2])){
                HomeFeed::create([
                    'job_id'=>$job->id,
                    'type'=>1,
                    'user_id'=>$job->agency_id,
                    'premium'=>$premium
                ]);
            }
        }
    }

    /**
     * Handle the Job "updated" event.
     */
    public function updated(Job $job): void
    {
        $agency = User::find($job->agency_id);
        $agency->completed_jobs = $this->getJobCount($job->agency_id);
        $agency->save();
        #add Job in feed
        if( in_array($job->status,[1,2]) ){
            HomeFeed::updateOrCreate(
                [
                    'job_id'=>$job->id
                ],
                [
                    'job_id'=>$job->id,
                    'type'=>1,
                    'user_id'=>$job->agency_id,
                ]
            ); 
        }else{
            $feed = HomeFeed::where('job_id',$job->id)->first();
            if($feed){
                $feed->delete();
            }
        }
    }

    /**
     * Handle the Job "deleted" event.
     */
    public function deleted(Job $job): void
    {
        $agency = User::find($job->agency_id);
        $agency->completed_jobs = $this->getJobCount($job->agency_id);
        $agency->save();
        $feed = HomeFeed::where('job_id',$job->id)->first();
        if($feed){
            $feed->delete();
        }
    }
    private function getJobCount($agency_id){
        return Job::where('agency_id',$agency_id)->whereIn('status',[1,2,4,5,6])->count();
    }
}
