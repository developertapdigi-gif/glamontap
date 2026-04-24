<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\{Job,HomeFeed,JobApplication,JobLike,User,UserConnection,Post,JobReviews,PostEndorsement,Notification};
use App\Http\Resources\{JobResource,JobCollection,HomeFeedResource,HomeFeedCollection};
use Carbon\Carbon;
class JobController extends BaseController
{
    public function homeFeeds(Request $request){
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'logitude' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 400);
        }
        $user           = $request->user();  
        $skillId        = $user->skill_category_id;   
        $lat            = $request->latitude;
        $long           = $request->logitude;  
        $maxDistance    = 50;
        $today          = now()->toDateString();     
        if($long){
            $user->longitude = $long;
            $user->latitude = $lat;
            $user->save();
        }
        $skillIds       = $user->feedPreferences->pluck('skill_id')->toArray(); 
        if(count($skillIds)){     
            $friends = UserConnection::where('status', 1)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                ->orWhere('connection_id', $user->id);
            })
            ->selectRaw('CASE WHEN user_id = ? THEN connection_id ELSE user_id END AS user_id', [$user->id])
            ->pluck('user_id')
            ->toArray();

            $endorsementIds = PostEndorsement::where('user_id',$user->id)->pluck('post_id')->toArray();              
            $skillIds       = $user->feedPreferences->pluck('skill_id')->toArray(); 
            $postIds = Post::where(function ($query) use ($friends, $endorsementIds, $skillIds, $user) {            
                $query->when(!empty($friends), function ($q) use ($friends) {
                    $q->whereIn('author_id', $friends);
                });            
                $query->when(!empty($endorsementIds), function ($q) use ($endorsementIds) {
                    $q->orWhereIn('id', $endorsementIds);
                });            
                $query->when(!empty($skillIds), function ($q) use ($skillIds) {
                    $q->orWhereIn('skill_id', $skillIds);
                });            
                $query->orWhere('author_id', $user->id);
            })
            ->where('status', 1)
            ->pluck('id')
            ->toArray();
        }else{
            $postIds = Post::where('status',1)->pluck('id')->toArray();
        }                 
        
        /**** Find job with same skill *************/
        $pendingApplicationsJobIds  = JobApplication::where('bidder_id',$user->id)
            ->pluck('task_id')
            ->toArray(); 
        
        $jobsids = Job::select('id')
        ->whereNotIn('id', $pendingApplicationsJobIds)
        ->whereIn('status',[1, 2]) 
        ->whereDate('end_date', '>=', $today)
        ->whereRaw("6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))) < ?",[$lat, $long, $lat, $maxDistance])
        ->pluck('id')
        ->toArray();
        // Combine job IDs and post IDs efficiently
        $postIds = array_unique($postIds);      
        $query = HomeFeed::query();      
        if (!empty($jobsids)) {
            $query->orWhere(function ($q) use ($jobsids) {
                $q->whereIn('job_id', $jobsids)
                  ->where('type', 1);
            });
        }
        if (!empty($postIds)) {
            $query->orWhere(function ($q) use ($postIds) {
                $q->whereIn('post_id', $postIds)
                  ->where('type', 2);
            });
        }
      
        if (empty($allJobIds) && empty($postIds)) {
            $query->whereRaw('1 = 0'); // No matching records
        }        
        $query->orderByDesc('premium')->orderByDesc('created_at');      
        $pageSize = $request->page_size ?? config('app.default_page_size', 10);
        $posts = $query->paginate($pageSize);
        return new HomeFeedCollection($posts);
    }
    public function mapListing(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'logitude' => 'required',
            'address' => 'nullable',          
            'skill_id' => ['nullable','exists:skill_categories,id'],
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 400);
        }
        $user       = $request->user();                    
        if ($request->has('latitude') && $request->has('logitude')) {
            $latitude = $request->input('latitude');
            $longitude = $request->input('logitude');
            if ($user->latitude !== $latitude || $user->longitude !== $longitude) {
                $user->update([
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]);
            }
        }    
        $lat = $request->latitude ?? $user->latitude;
        $long = $request->logitude ?? $user->longitude;       
        $today = Carbon::today()->toDateString(); 
        $maxDistance =100;    
        $applicationsJobIds  = JobApplication::where('bidder_id',$user->id)
            ->pluck('task_id')
            ->toArray(); 
        $jobsQuery = Job::select('id')
        ->whereDate('end_date', '>=', $today)
        ->where(function ($query) use ($request) {           
            if ($request->has('skill_id') && !empty($request->input('skill_id'))) {
                $skillIdExplode  = explode(',',$request->input('skill_id'));
                $query->whereIn('skill_category',$skillIdExplode);
            }                
            if ($request->has('address') && !empty($request->input('address'))) {
                $address = '%' . $request->input('address') . '%';
                $query->where(function ($q) use ($address) {
                    $q->where('title', 'like', $address)
                      ->orWhere('location', 'like', $address);
                });
            }
        })
        ->when($applicationsJobIds, function ($query) use ($applicationsJobIds) {
            $query->whereNotIn('id', $applicationsJobIds);
        })
        ->when($lat && $long, function ($query) use ($lat, $long, $maxDistance) {
            $query->whereRaw("6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))) < ?",[$lat, $long, $lat, $maxDistance]);
        });      
        $jobIds = $jobsQuery->pluck('id');       
        $pageSize = $request->input('page_size', config('app.default_page_size', 10));
        $jobs = Job::whereIn('id', $jobIds)
                   ->whereIn('status', [1, 2])
                   ->orderByDesc('id')
                   ->paginate($pageSize);
        return new JobCollection($jobs);
    }
    public function tradersJob(Request $request)
    { 
        $validator = Validator::make($request->all(), [           
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(),400);
        }
       $user = $request->user();
        $today = Carbon::today()->toDateString();
        $applicationStatuses = JobApplication::where('bidder_id', $user->id)
            ->whereIn('status', [0, 1,3]) 
            ->select('task_id', 'status')
            ->get()
            ->groupBy('status'); 
        $pendingApplicationsJobIds    = $applicationStatuses->get(0, collect())->pluck('task_id')->toArray();
        $acceptedApplicationsJobIds   = $applicationStatuses->get(1, collect())->pluck('task_id')->toArray();
        $completedApplicationsJobIds  = $applicationStatuses->get(3, collect())->pluck('task_id')->toArray();
        $allJobIds = array_unique(array_merge($acceptedApplicationsJobIds, $completedApplicationsJobIds));
        $jobsQuery = Job::query();    
        switch (strtolower($request->status)) {
            case 'ongoing':
                $jobsQuery->whereIn('id', $acceptedApplicationsJobIds)
                    ->where('status', 4);
                break;

            case 'upcoming':
                $jobsQuery->whereIn('id', $acceptedApplicationsJobIds)
                    ->whereDate('start_date', '>=', $today)
                    ->whereNot('status', 4)
                    ->whereNot('status', 3);
                break;

            case 'new':
            case 'open':
                $jobsQuery->whereIn('id', $pendingApplicationsJobIds)
                    ->whereDate('end_date', '>=', $today);
                break;

            default: // Completed
                $jobsQuery->whereIn('id', $allJobIds)
                      ->where('status', 6);
                break;
        }
        $pageSize = $request->input('page_size', config('app.default_page_size', 10));
        $jobs = $jobsQuery->orderByDesc('id')->paginate($pageSize);

        return new JobCollection($jobs);
    }
    public function bidOnJob(Request $request){        
        $validator = Validator::make($request->all(), [
            'job_id' => ['required','exists:tasks,id'],
            'bid_amount' => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 400);
        }       
        $bidder = $request->user(); 
        $job    = Job::find($request->job_id);
        $isAlreadyApplied = JobApplication::where('bidder_id',$bidder->id)->where('task_id',$job->id)->first();
        if ($isAlreadyApplied) {
            $isAlreadyApplied->bid_amount = $request->bid_amount;
            $isAlreadyApplied->save();
            return $this->responseApi([], true,"Application Updated", 200);
        }
        JobApplication::create([
            'task_id'=>$job->id,
            'start_date'=>$job->start_date,
            'end_date'=>$job->end_date,
            'bidder_id'=>$bidder->id,
            'bid_amount'=>$request->bid_amount,
            'agency_id'=>$job->agency_id,           
            'status'=>0,
        ]);
        return $this->responseApi([], true, 'Your application submitted successfully', 200);

    }   
    public function markJobComplete($id){
        $bidder = request()->user(); 
        $job    = Job::find($id);
        $bid    = JobApplication::where('task_id',$job->id)->where('bidder_id',$bidder->id)->first();
        if($bid){
            $bid->status =3;
            $bid->save();
            return $this->responseApi([], true, 'Job completed successfully', 200);
        }else{
            return $this->responseApi([], false, 'Your application has either been withdrawn or does not exist.', 400);
        }
    }   
    public function withdrawBid(Request $request){
        $validator = Validator::make($request->all(), [
            'job_id' => ['required','exists:tasks,id'],
            'reason'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 400);
        } 
        $bidder = $request->user(); 
        $job    = Job::find($request->job_id);
        $bid    = JobApplication::where('task_id',$job->id)
                ->where('bidder_id',$bidder->id)
                ->first();
        $today  = date('Y-m-d 00:00:00');
        $added_hours = date('Y-m-d H:i:s', strtotime($today . ' +48 hours'));        
        
        if($bid){
            if($job->start_date < $added_hours){
                $trader = User::find($bidder->id);
                if($trader->over_all_rating>1){
                    $trader->over_all_rating = $trader->over_all_rating - 0.5 ;
                }else{
                    $trader->over_all_rating = 1;
                }
                $trader->update();
            }
            $bid->status =4;
            $bid->withdraw_reason = $request->reason;
            $bid->withdraw_date = $today;
            $bid->update();
            return $this->responseApi([], true, 'Your application withdrawn successfully', 200);
        }else{
            return $this->responseApi([], false, 'Your application has either been withdrawn or does not exist.', 400);
        }
    }
    public function jobReview(Request $request){
        $validator = Validator::make($request->all(), [
            'job_id' => ['required','exists:tasks,id'],
            'over_all_rating' =>['required'],
            'comment'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 400);
        } 
        $trader = $request->user();
        $job = Job::find($request->job_id);
        $user = User::find($job->agency_id);
        $cal_agency_rating = $user->over_all_rating?(($user->over_all_rating + $request->over_all_rating)/2) : $request->over_all_rating ;
        $user->update([              
            'over_all_rating'=>$cal_agency_rating,
        ]);
        $review = JobReviews::where('user_id',$trader->id)->where('job_id',$request->job_id)->first();
        if($review){
            $review->update([              
                'over_all_rating'=>$request->over_all_rating,
                'comment'=>$request->comment,
            ]);
            $message ='Your review updated successfully';
        }else{        
            $review = JobReviews::create([
                'user_id'=>$trader->id,
                'job_id'=>$request->job_id,
                'over_all_rating'=>$request->over_all_rating,
                'comment'=>$request->comment,
                'status'=>1,
            ]);
            $message ='Your review added successfully';
        }
        return $this->responseApi($review, true,$message, 200);
    }
    /*
    * 
    * 
    */
    public function jobLikeDislike(Request $request){
        $validator = Validator::make($request->all(), [
            'job_id' => ['required','exists:tasks,id'],
            'type' =>['required', 'integer', 'between:1,2'],
        ],[
            'task_id.required'=>'Job id required',
            'type.between'=>'Type field must be 1 or 2'
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(),400);
        } else {
            $user       = $request->user();  
            $isExists   = JobLike::where('user_id',$user->id)                      
                        ->where('task_id',$request->job_id)
                        ->first();
            if($isExists){
                $isExists->delete();
            }                        
            $typeText = [
                1=>'Like',
                2=>'Dislike'
            ];         
            $likes    = JobLike::create([
                'user_id'=>$user->id,
                'task_id'=>$request->job_id,
                'type'=>$request->type,
            ]);    
            return $this->responseApi($likes, true, $typeText[$request->type].' added Successfully', 200);
            
        }
    }

    public function viewJobDetail($id)
    {
        $job    = Job::find(request()->id);
        if($job){
            $data = new JobResource($job);
            return $this->responseApi($data, true,'Job fetched Successfully', 200);   
        }else{
            return $this->responseApi([],false,'Job not found',400);   
        }
        
    }
    public function needToComplete(Request $request){
        $time      =  date('Hi'); 
        if($time>=1800){        
            $user      = $request->user();
            $today     = date('Y-m-d 00:00:00');
            $jobsIds   = JobApplication::where('bidder_id',$user->id)
                            ->where('status',1)
                            ->pluck('task_id')
                            ->toArray();
            $job = Job::whereIn('id',$jobsIds)->whereNot('status',6)->first();   
            if($job && $job->end_date == $today){                       
                $data = new JobResource($job);
                return $this->responseApi($data, true,'Job fetched Successfully ', 200); 
            }
        }
        return $this->responseApi([],false,'Job not found ',400);          
    }

    public function extendedJobDate(Request $request){
        $validator = Validator::make($request->all(), [
            'job_id' => ['required','exists:tasks,id'],
            'status' =>['required', 'integer', 'between:1,2'],
        ],[
            'task_id.required'=>'Job id required',
            'status.between'=>'Type field must be 1 or 2'
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(),400);
        } else {
            $user       = $request->user();
            $jobAplication = JobApplication::where('bidder_id',$user->id)->where('task_id',$request->job_id)->first();
            $jobAplication->extended_status = $request->status;
            $jobAplication->is_extended     = 0;
            $jobAplication->save();
            if($request->status==1){                
                $job        = Job::find($request->job_id);              
                $bidEndDate = Carbon::parse($jobAplication->extended_date);
                $jobEndDate = Carbon::parse($job->end_date);
                if ($bidEndDate->gt($jobEndDate)) {
                    $job->end_date = $jobAplication->extended_date;
                    $job->save();
                    $jobAplication->end_date = $jobAplication->extended_date;
                    $jobAplication->save();
                }
            }
            if($request->status==1){
                $extenstatus = "accepted";
            }else if($request->status==2){
                $extenstatus = "rejected";
            }else{
                $extenstatus = "pending";
            }
            $user      = $request->user();
            $notification = new Notification();
            $savedNotification = $notification->saveNotification([
                'type' => 13,
                'type_text'=>'agency_extend_date_status',
                'sender_id'=>$user->id,
                'receiver_id'=>$jobAplication->agency_id,
                'reference_id'=>$jobAplication->task_id,
                'message'=> $user->first_name.' has '.$extenstatus.' the request for extension of the job '.$jobAplication->job->title.' to '.date("d-m-Y", strtotime($jobAplication->extended_date)).'.'
            ]);
            $typeText = [
                1=>'accepted',
                2=>'rejected'
            ]; 
            return $this->responseApi([],true,'Extended date is '.$typeText[$request->status].' Successfully', 200);
        }
    }
}
