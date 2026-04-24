<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ApproveJobPost;
use App\Mail\CompleteJob;
use App\Mail\CancelJob;
use App\Mail\RejectJobPost;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\SkillCategory;
use App\Models\{User,AgencySubscription,Notification,JobTradersComplaint};
use App\Models\Badge;
use Carbon\Carbon;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentDate = date('Y-m-d'); 
        $user = Auth::user();
        if($user->user_type == User::ROLE['agency']){
            $condition = 'agency_id = '.$user->id;;
        }elseif($user->user_type == User::ROLE['admin']){     
            $condition = 'id>0';
        }else{
            $condition = 'agency_id = '.$user->agency_id;
        }
        if(!empty($request->all())){
            $query = $request->query('title');
            $skill = ($request->query('skill_id') && $request->skill!='-1')?$request->query('skill_id'):'';
            if($query)
            $condition .= " and (title like '%$query%') ";
           
        }
        $text   = Job::JOBLABEL;
        $today  = date('Y-m-d 00:00:00');
        if($request->type==$text[3]){ // ongoing
            //$condition .= " and DATE(start_date) <= '$today' and DATE(end_date) >= '$today' and is_hired=1 and status!=6";
            $condition .= " and is_hired=1 and status=4";
        }else if($request->type==$text[2]){ //upcoming 
            $condition .= " and DATE(start_date) >= '$today' and is_hired=1 and status!=4  and status!=3";
        
        }else if($request->type==$text[4]){ // complete
           // $condition .= " and status = 6 or DATE(end_date) < '$today')";
            $condition .= " and status = 6";
        }else if($request->type==$text[1]){ // open
           // $condition .= " and DATE(end_date) >= '$today' and is_hired!=1 and status>0";
           $condition .= " and (DATE(end_date) >= '$today' and status IN (1,2) and is_hired!=1)";
        }elseif($request->type==$text[6]){
            $condition .= " and status = 7 ";
        }else{ // draft
            $condition .= " and DATE(end_date) > '$today' and is_hired!=1 and status=0";
        }    
        if($request->skill_id && $request->skill_id!='-1'){
            $condition .= " and skill_category={$request->skill_id}";
        }
        $jobs = Job::whereRaw($condition)->orderby('id', 'desc')->paginate(10)->withQueryString();       
        $skill_categories =SkillCategory::getAllSkillCategory();
        $notfound = "No Result found";
        return view('admin.job.list_n_grid',compact('jobs','skill_categories','text','notfound'));
        
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user(); 
        $sub_user = 0;
        if($user->user_type == User::ROLE['agency']){
            $agency_id = $user->id;
        }else{
            $agency_id = $user->agency_id;
            $sub_user = 1;
        }
        if(User::ROLE['admin']){
            $company_address = Auth::user()->address;
            $company_latitude = Auth::user()->latitude;
            $company_longitude = Auth::user()->longitude;
            $experience_range = Badge::getAllBadges();
            $status = Job::STATUS;
            $categories =SkillCategory::getAllSkillCategoryCreate();
            return view('admin.job.create',['experience_range'=>$experience_range,'status'=>$status,'categories'=>$categories,'company_address'=>$company_address,'company_latitude'=>$company_latitude,'company_longitude'=>$company_longitude]);
        }
        $subcription = AgencySubscription::where('agency_id',$agency_id)->whereDate('end_date','>=',Carbon::today())->first();        
        if($subcription){
            if($subcription->job_limit > $subcription->used_job_qty){
                $status = Job::STATUS;
                $categories =SkillCategory::getAllSkillCategoryCreate();
                $agencies = User::getAgencyList();
                $company_address = '';
                if(Auth::user()->user_type == User::ROLE['agency']){
                    $company_address = Auth::user()->address;
                    $company_latitude = Auth::user()->latitude;
                    $company_longitude = Auth::user()->longitude;
                }elseif(Auth::user()->user_type == User::ROLE['agency_sub_user']){
                    $company_address = Auth::user()->agency->address;
                    $company_latitude = Auth::user()->agency->latitude;
                    $company_longitude = Auth::user()->agency->longitude;
                }
                $experience_range = Badge::getAllBadges();
                return view('admin.job.create',['experience_range'=>$experience_range,'status'=>$status,'categories'=>$categories,'agencies'=>$agencies,'company_address'=>$company_address,'company_latitude'=>$company_latitude,'company_longitude'=>$company_longitude]);
            }else{
                if($sub_user ==1){
                    return redirect('dashboard')->with('error', "You are not allowed to post a job please contact your agency!");
                }else{
                    return redirect('subscription');
                }
            }
    }else{
            return redirect('subscription');
        }
    }

    public function storeMedia(Request $request)
    {
        $path = public_path('uploads/jobs');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => 'uploads/jobs/'.$name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $request->validate([         
            'title'=>'required',
            'skill_category'=> 'required',
            'agency_id'=> 'required',
            'experiance_range'=> 'required',
            'number_of_employees'=> 'required',
            'company_address'=>'required',
            'location'=> 'required',
            'start_date'=> 'required|date',
            'end_date'=> 'required|date|after:start_date',
            'minimum_price'=> 'required',
            'maximum_price'=> 'required|gt:minimum_price',
            'other_skill'=>'nullable'
        ],
        [
            'start_date.after' => 'Please select current date or greater than current date',
            'end_date.after' => 'Please select greater than Start Date',
            'maximum_price'=> 'Please add greater than Minimum price'
        ]);    
        $input = $request->all();
        $input['start_date'] = date("Y-m-d H:i:s", strtotime($request->start_date));
        $input['end_date'] = date("Y-m-d H:i:s", strtotime($request->end_date));
        $input['created_by'] =Auth::user()->id;
        $input['updated_by'] =Auth::user()->id; 
        $other_skill = $request->other_skill;
            if($other_skill){
                $skillcategoryfind = SkillCategory::where('name',$other_skill)->first();
                if($skillcategoryfind){
                    $input['skill_category'] = $skillcategoryfind->id;
                }else{
                    $other_id = SkillCategory::create([
                        'name' => $other_skill,
                        'status'=>1
                    ]);
                    $input['skill_category'] = $other_id->id;
                }
                
                
            }   
            unset($input['other_skill']);
           // $input['agency_id']="";
            //echo'<pre>';print_r($request->all());die;  
            if(!User::ROLE['admin']){ 
                $subscription = AgencySubscription::where('agency_id','=',$request->agency_id);
                        if(!empty($subscription) && $request->status != 0){
                            $subscription->increment('used_job_qty', 1);
                        }
            }
        $model = Job::create($input);
        return redirect('job')->with('success', 'Job has been created successfully!');
    }

    public function preview(Request $request){
        $data = $request->session()->all();
        $agency = User::find($request->agency_id);
        $jobmodel = new Job;
        $data = [
            'image'=>$request->image,
            'title'=>$request->title,
            'skill_category'=>$request->skill_category,
            'agency_id'=>$request->agency_id,
            'experiance_range'=>$request->experiance_range,
            'number_of_employees'=>$request->number_of_employees,
            'status'=> $jobmodel->getStatusValue($request->status),
            'company_address'=>$request->company_address,
            'company_latitude'=>$request->company_latitude,
            'company_longitude'=>$request->company_longitude,
            'location'=>$request->location,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'minimum_price'=>$request->minimum_price,
            'maximum_price'=>$request->maximum_price,
            'note'=>$request->note,
            'agency_name'=>$agency->agency_name,
            'logo'=>$agency->logo,
            'address'=>$agency->address,
            'facebook'=>$agency->facebook_url,
            'linkedin'=>$agency->linkedin_url,
            'twitter'=>$agency->twitter_url,
            'over_all_rating'=>$agency->over_all_rating
        ];      
        $request->session()->put($data);  
        return response()->json(['status'=>200,'message'=>'']); 
    }
    public function previewdata(Request $request){
        $data = $request->session()->all();
        return view('admin.job.preview')->with('data',$data);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = Job::find($id);
        $today  = date('Y-m-d 00:00:00');
        return view('admin.job.show')->with(['model'=>$model,'today'=>$today]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = Job::find($id);
        if(count($model->applications) > 0 ){
            return redirect()->back()->with('error','You are not allowed to edit this job!');
        }
        $status = Job::STATUS;
        $experience_range = Badge::getAllBadges();
        $categories =SkillCategory::getAllSkillCategoryCreate();
        $agencies = User::getAgencyList();
        return view('admin.job.update',
            [
            'model'=>$model,
            'experience_range'=>$experience_range,
            'status'=>$status,
            'categories'=>$categories,
            'agencies'=>$agencies
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model  = Job::find($id);
        $request->validate([
            'title'=>'required',
            'skill_category'=> 'required',
            'experiance_range'=> 'required',
            'number_of_employees'=> 'required',
            'company_address'=>'required',
            'location'=> 'required',
            'start_date'=> 'required|date',
            'end_date'=> 'required|date|after:start_date',
            'minimum_price'=> 'required',
            'maximum_price'=> 'required|gt:minimum_price',
            'other_skill'=>'nullable'
        ],
        [            
            'end_date.after' => 'Please select greater than Start Date',
            'maximum_price'=> 'Please add greater than Minimum price'
        ]);      
        $input['updated_by'] =Auth::user()->id;
        $input       = $request->all();
        
            $other_skill = $request->other_skill;
            if($other_skill){
                $skillcategoryfind = SkillCategory::where('name',$other_skill)->first();
                if($skillcategoryfind){
                    $input['skill_category'] = $skillcategoryfind->id;
                }else{
                    $other_id = SkillCategory::create([
                        'name' => $other_skill,
                        'status'=>1
                    ]);
                    $input['skill_category'] = $other_id->id;
                }
                
                
            }   
            unset($input['other_skill']);
        $model->update($input);
        $subscription = AgencySubscription::where('agency_id','=',$request->agency_id);
        if($model->wasChanged('status')){
            if(!empty($subscription) && $request->status != 0){
                $subscription->increment('used_job_qty', 1);
            }else if($request->status == 0){
                $subscription->decrement('used_job_qty', 1);
            }
        }   
        if($request->ajax()){
            return response()->json(['status' => 200,'message'=>'','url'=>route("job.show", $model->id)]);
        }else{
            return redirect('job')->with('success', 'Job has been updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->user_type == User::ROLE['admin']){
            $model = Job::find($id);
            DB::table('task_applications')->where('task_id',$model->id)->delete();
            $model->delete();
        }
        return response()->json(['data' => true]);
    }
    public function approveJob(Request $request){
        $model = Job::find($request->id);  
        if(Auth::user()->user_type == User::ROLE['admin']){
            $model->update(['status'=>2]);
            $subscription = AgencySubscription::find(['agency_id'=>$model->agency_id]);
            if(!empty($subscription)){
                $subscription->used_job_qty += 1;
                $subscription->update($subscription->used_job_qty);
            }
             /* Send email to Agency*/
            $name = $model->agency->agency_name;
            $agency_email = $model->agency->email;
            try{
                Mail::to($agency_email)->send(new ApproveJobPost($name));
            }catch(\Exception $e){}            
        }else{
            $model->update(['status'=>1]);
        }
       
        return response()->json(['status' => 200,'message'=>'Job approved']);
    }

    //Approve Hired Employee
    public function approveEmployee(Request $request){
        $model = JobApplication::find($request->id);
        $model->status = 1; // Accepted
        $model->agency_id = Auth::user()->id;
        $model->save();
        $job = Job::find($model->task_id);
        $job->update(['is_hired'=>1]);
        $today      = date('Y-m-d 00:00:00');
        $count = JobApplication::where('task_id',$model->task_id)->where('status',1)->count();
        if($job->status != 4 && $job->start_date == $today && $count == $job->number_of_employees){
            $job->update(['status'=>4]);
        } 
        /* Send email to Trader*/
        $name = $model->trader->first_name;
        $trader_email = $model->trader->email;
        $data = [
            'agency' => Auth::user()->agency_name,
            'name' => $name,
            'job_name'=>$job->title,
            'start_date'=>date('d-m-Y',strtotime($job->start_date))
        ];
        $notification = new Notification();
            $savedNotification = $notification->saveNotification([
                'type' => 3,
                'type_text'=>'agency_job_accept',
                'sender_id'=>$model->agency_id,
                'receiver_id'=>$model->trader->id,
                'reference_id'=>$job->id,
                'message'=> ucfirst(Auth::user()->agency_name).' has accepted your request for work at '.$job->location.'. You can now message them from the app.'
            ]);
        if($model->trader->device_token && $model->trader->notification == 1){
            $notification->sendNotification([
                'message' => [
                    'token' =>$model->trader->device_token,
                    'notification' => [
                        'title' =>'Application Accepted',
                        'body'  =>ucfirst(Auth::user()->agency_name).' has accepted your request for work at '.$job->location.'. You can now message them from the app.'
                    ],
                    'data'=>[
                        'notification_id'=> (string)$savedNotification->id,
                        'type'=>'agency_job_accept',
                        'id'=>(string)$job->id
                    ]
                ]
            ]);
           
        }
        try{
            Mail::to($trader_email)->send(new ApproveJobPost($data));
        }catch(\Exception $e){}
        return response()->json(['status' => true]);
    }

    //Reject Hired Employee
    public function rejectEmployee(Request $request){
        $model = JobApplication::find($request->id);
            $model->status = 2; //Rejected
            $model->agency_id = Auth::user()->id;
        $model->save();
        $jobapp = JobApplication::where('task_id',$model->task_id)->get();
        $job = Job::find($model->task_id);
        if(count($jobapp)<=1){
            $job->update(['is_hired'=>0]);
        }
        /* Send email to Trader*/
        $name = $model->trader->first_name;
        $trader_email = $model->trader->email;
        $data = [
            'agency' => Auth::user()->agency_name,
            'name' => $name,
            'job_name' => $job->title,
        ];
        $notification = new Notification();
            $savedNotification = $notification->saveNotification([
                'type' => 4,
                'type_text'=>'agency_job_cancel',
                'sender_id'=>$model->agency_id,
                'receiver_id'=>$model->trader->id,
                'reference_id'=>$job->id,
                'message'=> ucfirst(Auth::user()->agency_name).' has rejected your request for work at '.$job->location.'.'
            ]);
        if($model->trader->device_token && $model->trader->notification == 1){
            
            $notification->sendNotification([
                'message' => [
                    'token' =>$model->trader->device_token,
                    'notification' => [
                        'title' =>'Application Rejected',
                        'body'  => ucfirst(Auth::user()->agency_name).' has rejected your request for work at '.$job->location.'.'
                    ],
                    'data'=>[
                        'notification_id'=>(string)$savedNotification->id,
                        'type'=>'agency_job_cancel',
                        'id'=>(string)$job->id
                    ]
                ]
            ]);
            
        }
        try{
            Mail::to($trader_email)->send(new RejectJobPost($data));
        }catch(\Exception $e){}
        return response()->json(['status' => true]);
    }

    public function fetchData(Request $request){
        $user = Auth::user();
        $data_arr = array();
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        $userType = User::ROLE['admin'];
        $today  = date('Y-m-d 00:00:00');
        $text   = Job::JOBLABEL;
        if($user->user_type == User::ROLE['agency']){
            $condition = 'agency_id = '.$user->id;
        }elseif($user->user_type == User::ROLE['admin']){     
            $condition = 'id>0';
        }else{
            $condition = 'agency_id = '.$user->agency_id;
        }

        if($searchValue){
            $condition .= " and (title like '%$searchValue%' or location like '%$searchValue%')";
        }
       
        # Job Tab filter starts from here        
        if($request->job_status==$text[3]){ //ongoing
            //$condition .= " and DATE(start_date) <= '$today' and DATE(end_date) >= '$today' and is_hired=1 and status!=6 and status!=3";
            $condition .= " and is_hired=1 and status=4";
        }else if($request->job_status==$text[2] ){ //upcoming
            $condition .= " and DATE(start_date) >= '$today' and is_hired=1 and status!=4 and status!=3";
        
        }else if($request->job_status==$text[4]){ //completed
            //$condition .= " and (status = 6 or DATE(end_date) < '$today')";
            $condition .= " and status = 6 ";
        }else if($request->job_status==$text[1]){ //open
            //$condition .= " and DATE(end_date) >= '$today' and is_hired!=1 and status>0";
            $condition .= " and (DATE(end_date) >= '$today' and status IN (1,2) and is_hired!=1)";
        }elseif($request->job_status==$text[6]){
            $condition .= " and (status = 7 or home_seen_job = 1) and DATE(start_date) >= '$today' and status!=4  and status!=3 ";
        }else{
            $condition .= " and DATE(end_date) > '$today' and is_hired!=1 and status = 0";
        }
        if($request->filter_skill && $request->filter_skill!='-1'){
            $condition .= " and skill_category={$request->filter_skill}";
        }
        $totalRecords = Job::select('count(*) as allcount')  
            ->whereRaw($condition)        
            ->count();
        $totalRecordswithFilter = Job::select('count(*) as allcount')  
                    ->whereRaw($condition)                 
                    ->count();
        $collection = Job::orderBy($columnName,$columnSortOrder) 
            ->whereRaw($condition)    
           ->select('tasks.*')
           ->skip($start)
           ->take($rowperpage)
           ->get();
        foreach ($collection as $key => $value) {
            
            $buttons = '';

            $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" target="_blank" data-toggle="tooltip" data-placement="top" data-tooltip="Location" alt="" href="http://maps.google.com/maps?q='.urlencode($value->location).'"><i class="skill-table-action bi bi-geo-alt-fill"></i></a>';    
            
            $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" data-toggle="tooltip" data-placement="top" data-tooltip="View" alt="" href="' . route("job.show", $value->id) . '"><i class="skill-table-action fas fa-eye"></i></a>';         
            
            $data_arr[] = array(
              "id" =>$value->id,
              "checkbox"=>'<input type="checkbox" class="item-checkbox" name="home_seen_job" data-id="'.$value->id .'" '.($value->home_seen_job ? 'checked' : '').'>',
              "title" =>ucfirst($value->title),
              "start_date" => date('d/m/Y',strtotime($value->start_date)),
              "end_date" => date('d/m/Y',strtotime($value->end_date)),
              'location'=>mb_strimwidth($value->location,0,30,'...'),           
              "number_of_employees"=> $value->number_of_employees,
              "skill_category"=> $value->SkillCategory?$value->SkillCategory->name:'NA',
              'minimum_price'=>'$'.$value->minimum_price .' - $'. $value->maximum_price,          
              "buttons"=>$buttons
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
        exit;
    } 
    
    public function homeJobSeen(Request $request){
        $model = Job::find($request['id']);
        if($request->checked == 1){
            $model->home_seen_job = 1;
        }else{
            $model->home_seen_job = 0;
        }
        $model->save();
        return response()->json(['message' => 'Checkbox saved.']);
    }

    public function hiredEmployee(Request $request){
        $data_arr = array();
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        $condition = "task_id  = '$request->job_id'";
        $today  = date('Y-m-d 00:00:00');
        #hiredstatus 
        if($request->employee_status=='Hired'){
            $condition .= " and status=1";
        }else if($request->employee_status=='Applicant'){
            $condition .= " and status=0";
        }
        $totalRecords = JobApplication::select('count(*) as allcount')  
            ->whereRaw($condition)        
            ->whereHas('trader')
            ->count();
        $totalRecordswithFilter = JobApplication::select('count(*) as allcount')  
                    ->whereRaw($condition)             
                    ->whereHas('trader')    
                    ->count();
        $collection = JobApplication::orderBy($columnName,$columnSortOrder) 
            ->whereRaw($condition)    
            ->whereHas('trader')
           ->select('task_applications.*')
           ->skip($start)
           ->take($rowperpage)
           ->get();
        $job = Job::find($request->job_id);
            foreach ($collection as $key => $value) {
                $buttons = '';
                if(Auth::user()->user_type == User::ROLE['admin'] && $job->agency_id != Auth::user()->id){
                    $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("trader.show", $value->bidder_id) . '"><i class="skill-table-action fas fa-eye"></i></a>';
                }else{
                    if($value->status != 2){
                    $buttons .= '<button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="rejectEmployee(' . $value->id . ','.$value->status.')"><i class="skill-table-action fas fa-ban"></i></button>';
                    }
                    if(($value->status==1 || $value->status==4) && $value->is_extended==0  && $value->job->status != 6 && $value->extended_status==0 && $value->job->end_date > $today){
                        $buttons .= '<button type="button" class="btn btn-icon btn-sm btn-color-dark" id="for_extension" data-bs-toggle="modal" data-bs-target="#extensionModal" data-applicationId="'.$value->id.'"><i class="skill-table-action fas fa-calendar-check"></i></button>';
                    }else if(($value->status==1 || $value->status==4) && $value->extended_date){
                        $buttons .= '<button type="button" class="btn btn-icon btn-sm btn-color-dark" id="after_extension" data-bs-toggle="modal" data-bs-target="#afterextensionModal" data-applicationId="'.$value->id.'" data-extensionDate="'.date('d M Y',strtotime($value->extended_date)).'" data-extensionStatus="'.$value->extended_status.'"><i class="skill-table-action fas fa-solid fa-calendar"></i></button>';
                    }
                    if($value->status != 1 && $value->job->status != 6){
                        $buttons .= '<button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="approveEmployee(' . $value->id . ','.$value->status.')"><i class="skill-table-action fas fa-check"></i></button>';
                    }
                    $buttons .= '<button class="primary-btn blue-button" id="for_rating" data-bs-toggle="modal" data-bs-target="#filterModal" data-userId="'.$value->id.'">
                        <i class="fa fa-star unchecked me-0"></i>
                    </button>';
                    $buttons .= '<button type="button" class="btn btn-icon btn-sm btn-color-dark complaintModalbtn" data-bs-toggle="modal" data-bs-target="#complaintModal" data-applicationId="'.$value->id.'"><i class="skill-table-action fas fa-flag"></i></button>';

                    $messageUrl = route("home").'/messages/'.$value->bidder_id;                    
                    $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' .$messageUrl. '" target="_blank"><i class="bi bi-chat-left-text"></i></a>';
                    $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("trader.show", $value->bidder_id) . '?job_id='.$request->job_id.'" target="_blank"><i class="skill-table-action fas fa-eye"></i></a>';
                    if($value->withdraw_reason){
                        $iconurl = asset('images/icons/withdraw-1.svg');
                        $buttons .= '<button type="button" class="btn btn-icon btn-sm btn-color-dark withdrawModalbtn skill-table-action" data-bs-toggle="modal" data-bs-target="#withdrawModal" data-applicationId="'.$value->id.'"><img class=" withdrawl-img" src='.$iconurl.'></button>';
                    }
                }
                $data_arr[] = array(
                    "id" =>$value->id,
                    "name" =>'<a href="'.route("trader.show", $value->bidder_id).'">'.$value->trader->first_name."</a>",
                    "start_date" => date('d M Y',strtotime($value->start_date)),
                    "end_date" => date('d M Y',strtotime($value->end_date)),          
                    "payment" =>$value->bid_amount ?? 0,                             
                    "buttons"=>$buttons
                  );
            }
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
            );
        echo json_encode($response);
        exit;
    }

    public function ratingEmployee(Request $request){        
        $request->validate([
            'rating' => 'required',
            'comment' => 'required',       
        ],[
          'rating.required'=>'Please enter rating',
          'comment.required'=>'Please enter comment',
      ]); 
        $user = Auth::user();
        if($user->user_type == User::ROLE['agency']){
            $agency_id = $user->id;
        }elseif($user->user_type == User::ROLE['admin']){
            $agency_id = $user->id;
        }else{
            $agency_id = $user->agency_id;
        }
        $model = JobApplication::findOrFail($request->task_id);
        $model->rating = $request->rating;
        $model->comment = $request->comment;
        $model->agency_id = $agency_id;
        $model->save();
        $bidderUser = User::find($model->bidder_id);
        if($bidderUser->over_all_rating == 0){
            $bidderUser->over_all_rating = $request->rating;
        }else{
            $bidderUser->over_all_rating = ($bidderUser->over_all_rating + $request->rating)/2;
        }
        $bidderUser->save();
        return response()->json(['status' => true]);
    }

    public function extensionEmployee(Request $request){
        $job_application = JobApplication::find($request->application_id);
        if($job_application)
        {
            $job_application->extended_date = $request->extension_date;
            $job_application->agency_id = Auth::user()->id;
            $job_application->is_extended = 1;           
            $job_application->save();
            $notification = new Notification();
            $savedNotification = $notification->saveNotification([
                'type' => 13,
                'type_text'=>'agency_extend_date',
                'sender_id'=>Auth::user()->id,
                'receiver_id'=>$job_application->bidder_id,
                'reference_id'=>$job_application->task_id,
                'message'=> ucfirst(Auth::user()->agency_name).' has extended the work at '.$job_application->job->location.' to '.date("d-m-Y", strtotime($request->extension_date)).'.'
            ]);
            $savedNotification = $notification->saveNotification([
                'type' => 20,
                'type_text'=>'agency_extend_date_to_agency',
                'sender_id'=>Auth::user()->id,
                'receiver_id'=>Auth::user()->id,
                'reference_id'=>$job_application->task_id,
                'message'=> 'Notification of extension has been sent to the hiree of the job .'
            ]);
            if($job_application->trader->device_token && $job_application->trader->notification == 1){                
                $notification->sendNotification([
                    'message' => [
                        'token' =>$job_application->trader->device_token,
                        'notification' => [
                            'title' =>'Extended Job Date',
                            'body'  => ucfirst(Auth::user()->agency_name).' has extended the work at '.$job_application->job->location.' to '.date("d-m-Y", strtotime($request->extension_date)).'.'
                        ],
                        'data'=>[
                            'notification_id'=>(string)$savedNotification->id,
                            'type'=>'agency_report_trader',
                            'id'=>(string)$job_application->task_id
                        ]
                    ]
                ]);
                
            }
            return response()->json(['status' => true]);
        }
    }
//agency_report_trader
    public function complaintEmployee(Request $request){
        $job_application = JobApplication::find($request->application_id);
        if($job_application){        
            $input['agency_id'] = Auth::user()->id;
            $input['task_id'] = $job_application->task_id;
            $input['trader_id'] = $job_application->bidder_id;
            $input['description'] = $request->description;
            $user = User::find($job_application->bidder_id);
            $user->update(['has_complain'=>1]);
            JobTradersComplaint::create($input);          
            return response()->json(['status' => true]);
        }
    }

    public function completeJob(Request $request){
        $job = $model = Job::find($request->id);
        $model->status = 6;
        $model->update();
        $traders = JobApplication::where('task_id',$request->id)->get();
        $user = Auth::user();
        if($user->user_type == User::ROLE['agency']){
            $userID = $user->id;
            $agency_name = $user->agency_name;
        }elseif($user->user_type == User::ROLE['admin']){
            $userID = $user->id;
            $agency_name = $user->first_name.' '.$user->last_name;
        }else{
            $userID = $user->agency_id;
            $agency_name = $user->agency->agency_name;
        }
        if(count($traders)){
            foreach($traders as $_trader){ 
                $notification = new Notification();
                    $savedNotification = $notification->saveNotification([
                        'type' => 8,
                        'type_text'=>'agency_job_complete',
                        'sender_id'=>$userID,
                        'receiver_id'=>$_trader->bidder_id,
                        'reference_id'=>$request->id,
                        'message'=> ucfirst(Auth::user()->agency_name).' has marked the job as completed. Please mark the job as completed from your side to continue applying for work, if not done already.'
                    ]);
                    $trader_user = User::find($_trader->bidder_id);
                if($trader_user->device_token && $trader_user->notification == 1){
                    
                    $notification->sendNotification([
                        'message' => [
                            'token' =>$trader_user->device_token,
                            'notification' => [
                                'title' =>'Completed Job',
                                'body'  =>ucfirst(Auth::user()->agency_name).' has marked the job as completed. Please mark the job as completed from your side to continue applying for work, if not done already.'
                            ],
                            'data'=>[
                                'notification_id'=>(string)$savedNotification->id,
                                'type'=>'agency_job_complete',
                                'id'=>(string)$job->id
                            ]
                        ]
                    ]);
                }
                $name = $_trader->trader->first_name;
                $trader_email = $_trader->trader->email;
                $data = ['agency' => $agency_name,'name' => $name,'job_name'=>$job->title,'start_date'=>date('d-m-Y',strtotime($job->start_date))];
                try{
                    Mail::to($trader_email)->send(new CompleteJob($data));
                }catch(\Exception $e){}
            }
            return response()->json(['status' => 200,'message'=>'Job Completetd Successfully.']);
        }
    }
    public function cancelJob(Request $request){
        $job = $model = Job::find($request->id);
        $today  = date('Y-m-d 00:00:00');
        $added_hours = date('Y-m-d H:i:s', strtotime($today . ' +48 hours'));
        $model->status = 3;
        $model->update();
        
        $traders = JobApplication::where('task_id',$request->id)->get();
        $user = Auth::user();
        if($user->user_type == User::ROLE['agency']){
            $userID = $user->id;
            $agency_name = $user->agency_name;
        }elseif($user->user_type == User::ROLE['admin']){
            $userID = $user->id;
            $agency_name = $user->first_name.' '.$user->last_name;
        }else{
            $userID = $user->agency_id;
            $agency_name = $user->agency->agency_name;
        }
        if(count($traders)){
            if($model->start_date < $added_hours){
                $user_id = Auth::user()->user_type == User::ROLE['agency_sub_user']?Auth::user()->agency_id:Auth::user()->id;
                $agency = User::find($user_id);
                if($agency->over_all_rating){
                    $agency->over_all_rating = $agency->over_all_rating - 0.5;
                    $agency->update();
                }
            }
            foreach($traders as $_trader){
                $input['sender_id'] = $userID;
                $input['receiver_id'] = $_trader->bidder_id;
                $input['reference_id'] = $request->id;
                $notification = new Notification();
                $savedNotification = $notification->saveNotification([
                    'type' => 9,
                    'type_text'=>'agency_job_withdraw_cancel',
                    'sender_id'=>$userID,
                    'receiver_id'=>$_trader->bidder_id,
                    'reference_id'=>$request->id,
                    'message'=> 'The job '.$job->title.' is cancelled by '.Auth::user()->agency_name.'.'
                ]);
                $trader_user = User::find($_trader->bidder_id);
                if($trader_user->device_token && $trader_user->notification == 1){
                    $notification->sendNotification([
                        'message' => [
                            'token' =>$trader_user->device_token,
                            'notification' => [
                                'title' =>'Cancel Job',
                                'body'  =>'The job '.$job->title.' is cancelled by '.Auth::user()->agency_name.'.'
                            ],
                            'data'=>[
                                'notification_id'=>(string)$savedNotification->id,
                                'type'=>'agency_job_withdraw_cancel',
                                'id'=>(string)$job->id
                            ]
                        ]
                    ]);
                }
                    
                $name = $_trader->trader->first_name;
                $trader_email = $_trader->trader->email;
                $data = ['agency' => $agency_name,'name' => $name,'job_name'=>$job->title,'start_date'=>date('d-m-Y',strtotime($job->start_date))];
                try{
                    Mail::to($trader_email)->send(new CancelJob($data));
                }catch(\Exception $e){}
            }
            return response()->json(['status' => 200,'message'=>'Job cancel Successfully.']);
        }else{
            return response()->json(['status' => 200,'message'=>'Job cancel Successfully.']);
        }
    }

    public function getRating($id){
        $job_application = JobApplication::find($id);
        $data = [
            'rating'=>$job_application->rating,
            'comment'=> $job_application->comment,
        ];
        if(empty($data)){
            $data = '';
        }
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
    }

    public function getWithdraw($id){
        $job_application = JobApplication::find($id);
        $data = [
            'withdraw_reason' => $job_application->withdraw_reason,
            'withdraw_date' => date('d-m-Y',strtotime($job_application->withdraw_date)),
        ];
        if(empty($data)){
            $data = '';
        }
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
    }
}
