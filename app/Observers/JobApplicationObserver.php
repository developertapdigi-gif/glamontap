<?php

namespace App\Observers;

use App\Models\{JobApplication,User,Notification,Job};
class JobApplicationObserver
{
    /**
     * Handle the JobApplication "created" event.
     */
    public function created(JobApplication $application): void
    {
        $bidder = User::find($application->bidder_id);
        $bidder->completed_jobs = $this->getHireCount('bidder_id',$application->bidder_id);
        $bidder->save();
        #agency count
        $agency = User::find($application->agency_id);
        $agency->hiring_count = $this->getHireCount('agency_id',$agency->id);
        $agency->save();

        # Add Notification
        Notification::create([
            'message'=>ucfirst($application->trader->first_name.', '.$application->job->SkillCategory->name.' has applied for the job '.$application->job->title).' required in '.$application->job->location.' . You can now message them from this web portal.',
            'sender_id'=>$application->bidder_id,
            'receiver_id'=>$application->agency_id,
            'reference_id'=>$application->task_id,
            'type'=>2,
            'is_viewed'=>0
        ]);
    }

    /**
     * Handle the JobApplication "updated" event.
     */
    public function updated(JobApplication $application): void
    {
        $bidder = User::find($application->bidder_id);
        if($bidder){
            $bidder->completed_jobs = $this->getHireCount('bidder_id',$application->bidder_id);
            $bidder->save();
        }
        $agency = User::find($application->agency_id);
        if($agency){
            $agency->hiring_count = $this->getHireCount('agency_id',$agency->id);
            $agency->save();
        }
        if($application->status==1){
            if($agency){
             Notification::create([
                'message'=>ucfirst($application->trader->first_name.' your application accepted by '.($agency->agency_name ?? $agency->first_name)),
                'sender_id'=>$agency->id,
                'receiver_id'=>$application->bidder_id,
                'reference_id'=>$application->task_id,
                'type'=>3,
                'is_viewed'=>0
            ]);
            }
        }else if($application->status==2){
            if($agency){
            Notification::create([
                'message'=>ucfirst($application->trader->first_name.' your application rejected by '.($agency->agency_name ?? $agency->first_name)),
                'sender_id'=>$agency->id,
                'receiver_id'=>$application->bidder_id,
                'reference_id'=>$application->task_id,
                'type'=>4,
                'is_viewed'=>0
            ]);
            }
        }else if($application->status==3){
            if($agency && $application->trader){
            Notification::create([
                'message'=>ucfirst($application->trader->first_name).' has marked the job as completed. Please mark the job as completed from your side to continue applying for work, if not done already. ',
                'sender_id'=>$application->trader->id,
                'receiver_id'=>$agency->id,
                'reference_id'=>$application->task_id,
                'type'=>8,
                'is_viewed'=>0
            ]);
            }
        }else if($application->status==4){
            if($agency && $application->trader){
            Notification::create([
                'message'=>ucfirst($application->trader->first_name.' has withdrawn their application from the job '.$application->job->title).'.',
                'sender_id'=>$application->trader->id,
                'receiver_id'=>$agency->id,
                'reference_id'=>$application->task_id,
                'type'=>19,
                'is_viewed'=>0
            ]);
            }
        }
    }

    /**
     * Handle the JobApplication "deleted" event.
     */
    public function deleted(JobApplication $application): void
    {
        $bidder = User::find($application->bidder_id);
        if($bidder){
            $bidder->completed_jobs = $this->getHireCount('bidder_id',$application->bidder_id);
            $bidder->save();
        }
        $agency = User::find($application->agency_id);
        if($agency){
            $agency->hiring_count = $this->getHireCount('agency_id',$agency->id);
            $agency->save();
        }
    }   

    private function getHireCount($filed,$value){
        return JobApplication::where($filed,$value)->where('status',1)->count();
    }
}
