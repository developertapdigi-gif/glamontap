<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\{Badge,SkillCategory,User,JobApplication,JobTradersComplaint,Post,JobReviews};
use App\Mail\{PasswordReset,UnBlock};
use File;
class TraderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        
        $condition = 'id>0';
        if(!empty($request->query('query'))){
            $query = $request->query('query');
            $condition .= " and (name agency_name '%$query%' or location like '%$query%') ";
        }
        $condition .= ' and user_type='.User::ROLE['trader'];
        $traders = User::whereRaw($condition)->orderby('id', 'desc')->paginate(10)->withQueryString();  
        $skill_categories =SkillCategory::getAllSkillCategory();
        $badges =Badge::getAllBadges();
        return view('admin.trader.list_n_grid',compact('skill_categories','badges','traders'));      
    }
    public function storeImage(Request $request)
    {
        $path = public_path('uploads/profile');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => 'uploads/profile/'.$name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = User::STATUS;;
        $agency = User::getAgencyList();
        $skill_categories =SkillCategory::getAllSkillCategory();
        $badges =Badge::getAllBadges();
        return view('admin.trader.create',[
            'status'=>$status,
            'agency'=>$agency,
            'skill_categories'=>$skill_categories,
            'badges'=>$badges
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {       
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'user_type' => 'nullable',
            'address'=>'required',
            'badge_id'=>'required',
            'skill_category_id'=>'required',
           // 'profile_picture'=> ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]); 
        $input              = $request->all();
        $input['user_type'] = User::ROLE['trader'];
        $input['status']    = 1;
        $input['password']  = Hash::make('apr_800#');
        
        $model = User::create($input);
        $model->assignRole('trader');
        $token =Str::random(40);
        DB::table('password_reset_tokens')->insert([
            'email' => $model->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        try{
            Mail::to($model->email)->send(new PasswordReset($model->first_name,$token));
        }catch(\Exception $e){}
        return redirect('trader')->with('success', 'Trader has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = User::where('id',$id)->with(['agency'])->with('userExperienceCertificate')->get();
        $certificates = $model[0]->userExperienceCertificate;
        if($model[0]->agency)
        $agencyName =$model[0]->agency->first_name.' '.$model[0]->agency->last_name;
        else
        $agencyName = 'NA';
        $completedJobs = JobApplication::with(['jobTraderCompleted'])->whereRaw('bidder_id ='.$id)->orderby('id', 'desc')->get();
        $complaint = JobTradersComplaint::whereRaw('trader_id ='.$id)->orderby('id', 'desc')->paginate(5)->withQueryString();
        $feedback = JobReviews::where('user_id',$id)->get();
        // Get job application if coming from a job context
        $jobId = request('job_id');
        $application = $jobId ? JobApplication::where('task_id', $jobId)->where('bidder_id', $id)->first() : null;
        $job = $jobId ? \App\Models\Job::find($jobId) : null;
        return view('admin.trader.show')->with(['model'=>$model[0],'agency_name'=>$agencyName,'completedJobs'=>$completedJobs,'complaint'=>$complaint,'certificates'=>$certificates,'feedback'=>count($feedback),'application'=>$application,'job'=>$job]);
    }

    public function showPost(string $id)
    {
        $model  = Post::where('author_id',$id)->orderby('created_at', 'desc')->paginate(9);
        return view('admin.trader.show_post')->with(['model'=>$model]);
    }
    public function showFeedback(string $id)
    {
        $model  = JobReviews::where('user_id',$id)->orderby('created_at', 'desc')->paginate(9);
       // echo'<pre>';print_r($model);die;
        return view('admin.trader.show_feedback')->with(['model'=>$model]);
    }
    public function showPostDetail(string $id)
    {
        $model = Post::find($id);
        return view('admin.trader.show_post_detail')->with(['model'=>$model]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = User::find($id);
        $skill_categories =SkillCategory::getAllSkillCategoryCreate();
        $badges =Badge::getAllBadges();
        return view('admin.trader.update',
            [
            'model'=>$model,
            'agency' => $model->getAgencyList(),
            'status' => User::STATUS,
            'skill_categories'=>$skill_categories,
            'badges'=>$badges
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model  = User::find($id);
        $validator =  $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$model->id,
            'mobile' => 'required|unique:users,mobile,'.$model->id,
            'address'=>'required',
            'badge_id'=>'required',
            'skill_category_id'=>'required',
            'other_skill'=>'nullable'
            //'profile_picture'=> ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);
        $input       = $request->all();   
        $other_skill = $request->other_skill;
            if($other_skill){
                $skillcategoryfind = SkillCategory::where('name',$other_skill)->first();
                if($skillcategoryfind){
                    $input['skill_category_id'] = $skillcategoryfind->id;
                }else{
                    $other_id = SkillCategory::create([
                        'name' => $other_skill,
                        'status'=>1
                    ]);
                    $input['skill_category_id'] = $other_id->id;
                }
                
                
            }   
            unset($input['other_skill']);  
        $model->update($input);
        
        return redirect('trader')->with('success', 'Tradie has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->user_type == User::ROLE['admin']){
            $model = User::find($id);
            DB::table('password_reset_tokens')->where('email',$model->email)->delete();
            $model->delete();
        }
        return response()->json(['data' => true]);
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
        $userType = User::ROLE['trader'];
        $condition = "user_type=$userType";
        if($searchValue){
             $condition .= " and (first_name like '%$searchValue%' or email like '%$searchValue%' or address like '%$searchValue%')";
        }
        if($request->filter_skill && $request->filter_skill!='-1'){
            $condition .= " and skill_category_id={$request->filter_skill}";
        }
        if($request->badge_id && $request->badge_id!='-1'){
            $condition .= " and badge_id={$request->badge_id}";
        }
        if($request->over_all_rating && $request->over_all_rating!='-1'){
            $condition .= " and over_all_rating={$request->over_all_rating}";
        }
        if($request->has_complain && $request->has_complain!='-1'){
            $condition .= " and has_complain=1";
        }
        if($request->trader_status == 1){
             $condition .= " and home_seen_trader=1";
        }
        $totalRecords = User::select('count(*) as allcount')
            ->whereRaw($condition)
            ->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')
                    ->whereRaw($condition)
                    ->count();
        $collection = User::orderBy($columnName,$columnSortOrder)
           ->whereRaw($condition)
           ->select('users.*')
           ->skip($start)
           ->take($rowperpage)
           ->get();
        foreach ($collection as $key => $value) {
            $buttons = '';
            if($value->status == 1){
                $buttons .= '<button type="button" id="button-attribute" class="btn btn-icon btn-sm btn-color-dark" onclick="activateRecord('.$value->id.','.$value->status.')" data = "{{$value->status}}">
                     <i class="skill-table-action bi bi-x-lg" id="close" ></i>
                </button>';
            }else{
                $buttons .= '<button type="button" id="button-attribute" class="btn btn-icon btn-sm btn-color-dark" onclick="activateRecord('.$value->id.','.$value->status.')" data = "{{$value->status}}">
                        <i class="skill-table-action bi bi-check skill-tooltip" id="check"></i>
                    </button>';
            }
            
            if ($user->can('admin-trader-view')) {
                $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("trader.show", $value->id) . '"><i class="skill-table-action bi bi-eye-fill"></i></a></button>';
            } 
            if ($value->has_complain==1) {
                $buttons .= '<a class="btn btn-icon btn-sm btn-color-dark" href="' . route("trader.show", $value->id) . '#report_complaint"><i class="skill-table-action fas fa-flag rust-icon"></i></a>';
            }        
            $agency = 'N/A';
            $url = '';
               
                if($value->profile_picture && (File::exists(public_path($value->profile_picture)))){
                    $url .= '<img src="'.asset($value->profile_picture).'" height="50px" class="profile-image">';
                }else{
                    $url .= '<img src="'.url('/').'/images/company-name.png" height="50px" class="profile-image">';
                }
           
            $rating_value = $value->over_all_rating ?? 0;
            $rating = '<input class="rating"  max="5"  step="0.05" style="--fill:orange;--value:'.$rating_value.'" type="range" value="'.$rating_value.'">';
            if($value->badge){
                $class = 'skill-yellow-warning';
                    if($value->badge->name == 'Experience' || $value->badge->name == 'experience'){
                        $class = 'skill-activate';
                    }elseif($value->badge->name == 'Intermediate' || $value->badge->name == 'intermediate'){
                        $class = 'skill-deactivate skill-grey-warninng';
                    }elseif($value->badge->name == 'Expert' || $value->badge->name == 'expert'){
                        $class = 'skill-red-warning';
                    }else{
                        $class = 'skill-yellow-warning';
                    }
                    $badge = '<a class="'.$class.'">'.$value->badge->name.'</a>';
            }else{
                $badge = '<a class="skill-activate">Experience</a>';
            }
            $data_arr[] = array(
                "checkbox"=>'<input type="checkbox" class="item-checkbox" name="home_seen_trader" data-id="'.$value->id .'" '.($value->home_seen_trader ? 'checked' : '').'>',
                "logo"=> $url,
              "first_name" => ucfirst($value->first_name).' '.ucfirst($value->last_name),
              'skill_category_id'=>($value->skill_category_id)?$value->skillCategory->name??'':'0',
              'completed_jobs' => ($value->JobApplication)? count($value->JobApplication):'0',
              "address" => ($value->address)?mb_strimwidth(ucfirst($value->address),0,30,'...'):'NA',
              "created_at" => date('d M Y',strtotime($value->created_at)),
              'badge_id'=> $badge,
              'over_all_rating' => $rating,           
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

    public function changeStatus($id){
        $model = User::find($id);
        if($model){
            if($model->status == 1){
                $model->status = 2;
                $model->is_logged_in=0;
                $model->active_status=2;
                DB::table('oauth_access_tokens')->where('user_id',$model->id)->delete();
            }else{
                if($model->status == 2){
                    $data = ['name'=>$model->first_name,'email' => $model->email];
                    try{
                        Mail::to($model->email)->send(new UnBlock($data));
                    }catch(\Exception $e){}
                }
                $model->status = 1;
            }
            $model->save();
        }
        return response()->json(['data' => true,]);
    }

    public function homeTraderSeen(Request $request){
        $model = User::find($request['id']);
        if($request->checked == 1){
            $model->home_seen_trader = 1;
        }else{
            $model->home_seen_trader = 0;
        }
        $model->save();
        return response()->json(['message' => 'Checkbox state saved.']);
    }

    public function fetchRecentData(Request $request){
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
        $condition = "bidder_id  = '$request->trader_id'";
        
        #hiredstatus 
        if($request->employee_status=='Hired'){
            $condition .= " and status=1";
        }else if($request->employee_status=='Applicant'){
            $condition .= " and status=2";
        }
        $totalRecords = JobApplication::select('count(*) as allcount')  
            ->whereRaw($condition)        
            ->count();
        $totalRecordswithFilter = JobApplication::select('count(*) as allcount')  
                    ->whereRaw($condition)                 
                    ->count();
        $collection = JobApplication::orderBy($columnName,$columnSortOrder) 
            ->whereRaw($condition)    
           ->select('task_applications.*')
           ->skip($start)
           ->take($rowperpage)
           ->get();
            foreach ($collection as $key => $value) {
                
                //$job = Job::find($request->job_id);           
                $data_arr[] = array(
                    "id" =>$value->id,
                    "title" =>$value->job->title,
                    "start_date" => date('d M Y',strtotime($value->start_date)),         
                    "status" =>$value->job->getStatusValue($value->job->status), 
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
}
