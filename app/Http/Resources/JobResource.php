<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Job,JobLike,JobApplication,JobReviews,Badge};
class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {      
        $user       = $request->user();   
        $badge      = Badge::find($this->experiance_range);
        if($badge){
           $range = $badge->name;
        }else{
            $range = Job::EXPERIENCE_RANGE[1];
        }
        $likes      = $this->likes;
        $isOwner    = false;
        if($user->id==$this->author_id){
            $isOwner    = true;
        }
        $hasRated   = JobReviews::where('job_id',$this->id)->where('user_id',$user->id)->exists();
        $jobLike    = JobLike::where('task_id',$this->id)->where('user_id',$user->id)->first(); 
        $applied    = JobApplication::where('bidder_id',$user->id)->where('task_id',$this->id)->first();
        $is_applied = 0;
        $end_date = $this->end_date; 
        if($applied){
           $is_applied = 1;
           $end_date   = $applied->end_date;
        }
        
        $today      = date('Y-m-d 00:00:00'); 
        $status = 'Open';
        if($this->start_date>=$today && in_array($this->status,[1,2])){
            $status = 'Open';
        }else if($this->status==4){
            $status = 'Ongoing';
        }else if($this->status==6){
            $status = 'Completed';
        }else if($this->status==3){
            $status = 'Cancelled';
        }
        if($applied && $applied->status==1 && $this->start_date>=$today && $this->status != 4 && $this->status != 3){
            $status = 'Upcoming';            
        }
        $extended_status = 0;
        $entended_date = "";
        if($applied && $applied->is_extended == 1){
            $extended_status = 1;
            $entended_date = $applied->extended_date;
        }
        $marked_complete = 0;
        if($applied && $applied->status == 3){
            $marked_complete = 1;
        }
        return [
            'id'=>$this->id,
            'is_owner'=>$isOwner,
            'title'=>$this->title,
            'location'=>$this->location,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'experiance_range'=>$range,
            'number_of_employees'=>$this->number_of_employees,
            'minimum_price'=>$this->minimum_price,
            'maximum_price'=>$this->maximum_price,
            'start_date'=>$this->start_date,
            'end_date'=>$end_date,
            'status'=>$status,
            'is_applied'=>$is_applied,
            'is_job_extended'=>$extended_status,
            'entended_date' => $entended_date,
            'is_marked_complete'=>$marked_complete,
            'note'=>$this->note,      
            'like_count'=>$likes->count(),
            'has_rated'=>$hasRated,
            'user_likes'=>new JobLikeResource($jobLike),           
            'image'=>$this->image ? url($this->image): '',
            'skill_category'=>$this->skill->name ?? '',
            'agency'=>new UserResource($this->agency)
        ];
    }
}