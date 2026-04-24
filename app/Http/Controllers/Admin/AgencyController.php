<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\{User,SkillCategory,AgencySubscription,Job,JobTradersComplaint,JobReviews,UserFlags};
use App\Mail\{PasswordReset,ApproveUser,BlockUser,UnBlock};
use File;

class AgencyController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {      
        $condition = 'user_type='.User::ROLE['agency'];
        if(!empty($request->query('query'))){
            $query = $request->query('query');
            $condition .= " and (agency_name like '%$query%' or first_name like '%$query%') ";
        }        
        $agencies = User::whereRaw($condition)->orderby('id', 'desc')->paginate(10)->withQueryString();       
        $skill_categories =SkillCategory::getAllSkillCategory();
        return view('admin.agency.list_n_grid',compact('agencies','skill_categories'));
    }

    public function storeImage(Request $request)
    {
        $path = public_path('uploads/logo');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => 'uploads/logo/'.$name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = User::STATUS;;
        return view('admin.agency.create',['status'=>$status]);
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
            //'profile_picture'=> ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);
        $input              = $request->all();
        $input['user_type'] = User::ROLE['agency'];
        $input['status']    = 1;
        $input['password']  = Hash::make('apr_800#');
        $model = User::create($input);
        $model->assignRole('agency');
        $token =Str::random(40);
        DB::table('password_reset_tokens')->insert([
            'email' => $model->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        try{
            Mail::to($model->email)->send(new PasswordReset($model->first_name,$token));
        }catch(\Exception $e){}
        return redirect('agency')->with('success', 'Agency has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = User::find($id);
        $completedJobs = Job::whereRaw('agency_id ='.$id.' and status = 6')->orderby('id', 'desc')->paginate(5)->withQueryString();
        $complaint = JobTradersComplaint::whereRaw('agency_id ='.$id)->orderby('id', 'desc')->paginate(5)->withQueryString();
        $complaint = Job::join('job_reviews', 'tasks.id', '=', 'job_reviews.job_id')->select('job_reviews.*')->where('agency_id',$id)->get();
         $userflag = UserFlags::join('tasks', 'user_flags.model_id', '=', 'tasks.id')->leftJoin('posts','user_flags.model_id','=','posts.id')->select('tasks.agency_id','posts.author_id','user_flags.*')->where('tasks.agency_id',$id)->orderby('id','desc')->get();
        //echo'<pre>';print_r($userflag);die; 
        return view('admin.agency.show')->with(['model'=>$model,'completedJobs'=>$completedJobs,'complaint'=>$userflag]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = User::find($id);
        return view('admin.agency.update',
            [
            'model'=>$model,
            'status' => User::STATUS
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model  = User::find($id);
        $validator =  $request->validate([
            'first_name' => 'required|regex:/^[a-zA-Z ]*$/',
            'last_name' => 'required|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|email|unique:users,email,'.$model->id,
            //'mobile' => 'nullable|numeric|unique:users,mobile,'.$model->id,
            'address'=>'required',
            //'logo'=> ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);
        $input       = $request->all();
        $model->update($input);
        
        return redirect('agency')->with('success', 'Agency has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->user_type == User::ROLE['admin']){
            $model = User::find($id);
            DB::table('password_reset_tokens')->where('email',$model->email)->delete();
            DB::table('tasks')->where('agency_id',$model->id)->delete();
            DB::table('task_applications')->where('agency_id',$model->id)->delete();
            DB::table('agency_subscriptions')->where('agency_id',$model->id)->delete();
            DB::table('users')->where('agency_id',$model->id)->delete();
            DB::table('user_feedback_surveys')->where('user_id',$model->id)->delete();
            DB::table('ch_messages')->whereRaw("from_id=$model->id or to_id=$model->id")->delete();
            $model->delete();
        }
        return response()->json(['data' => true]);
    }
    public function fetchData(Request $request){
        $user = Auth::user();
        $data_arr = array();
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); 
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column']; 
        $columnName = $columnName_arr[$columnIndex]['data']; 
        $columnSortOrder = $order_arr[0]['dir']; 
        $searchValue = $search_arr['value']; 
        $userType = User::ROLE['agency'];
        $condition = "user_type=$userType";
        if($request->over_all_rating && $request->over_all_rating!='-1'){
            $condition .= " and over_all_rating={$request->over_all_rating}";
        }
        if($request->has_complain && $request->has_complain!='-1'){
            $condition .= " and has_complain=1";
        }
        if($request->subscriber && $request->subscriber!='-1'){
            $activePlans = AgencySubscription::where('payment_status',1)
            ->whereDate('end_date','>=',Carbon::today()) 
            ->pluck('agency_id')
            ->toArray();
            if($activePlans && $request->subscriber==1){
                $agenciIds = implode(',', $activePlans);
                $condition .= " and id in($agenciIds)";
            }else if($activePlans && $request->subscriber==2){
                $agenciIds = implode(',', $activePlans);
                $condition .= " and id not in($agenciIds)";
            }
        }
        if($searchValue){
            $condition .= " and (agency_name like '%$searchValue%' or email like '%$searchValue%' or first_name like '%$searchValue%' or address like '%$searchValue%')";
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
                if ($user->can('admin-agency-view')) {
                    $buttons .= ' <button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="activateRecord(' . $value->id . ','.$value->status.')"><i class="skill-table-action bi bi-x-lg"></i></button>';
                }
            }else{
                if ($user->can('admin-agency-view')) {
                    $buttons .= ' <button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="activateRecord(' . $value->id . ','.$value->status.')"><i class="skill-table-action bi bi-check skill-tooltip"></i></button>';
                }
            }
            if ($user->can('admin-agency-view')) {
                $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("agency.show", $value->id) . '"><i class="skill-table-action bi bi-eye-fill"></i></a>';  
                $buttons .= ' <button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="deleteRecord(' . $value->id . ')"><i class="skill-table-action fas fa-trash"></i></button>';
            }          
            if ($value->has_complain==1) {
                 $buttons .= '<a href="' . route("agency.show", $value->id) . '#report_complaint"class="btn btn-icon btn-sm btn-color-dark"><i class="skill-table-action fas fa-flag rust-icon"></i></a>';
            }
            $url = '';
            if($value->logo && (File::exists(public_path($value->logo)))){
                $url .= '<img src="'.asset($value->logo).'" height="30px" class="profile-image">';
            }else{
                $url .= '<img src="'.asset('images/icons/brand-logo2.png').'" height="30px" class="profile-image">';
            }
            $rating_value = $value->over_all_rating ?? 0;
            $rating = '<input class="rating"  max="5"  step="0.05" style="--fill:orange;--value:'.$rating_value.'" type="range" value="'.$rating_value.'">';
            $data_arr[] = array(
                "id"=>$value->id,
              "logo"=>$url,            
              "first_name" => $value->agency_name ?? 'NA',
              "address" => mb_strimwidth(ucfirst($value->address),0,30,'...'),
              "created_at" => date('d M Y',strtotime($value->created_at)),
              "hiring_count" => $value->hiring_count,
              "completed_jobs" => $value->completed_jobs ?? 0,
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
        $status = $_GET['oldstatus'];
        $model = User::find($id);
        if($model){
            if($status == 1){
                $model->status = 2;
                $model->active_status=2;
                $data = ['name'=>$model->first_name,'agency' => $model->agency_name,'text' => 'blocked'];
                try{
                    Mail::to($model->email)->send(new PasswordReset($model->first_name,$token));
                    Mail::to($model->email)->send(new BlockUser($data));
                }catch(\Exception $e){}   
            }elseif($status == 2){
                $model->status = 1;
                $data = ['name'=>$model->first_name,'email' => $model->email];
                try{
                    Mail::to($model->email)->send(new UnBlock($data));
                }catch(\Exception $e){} 
                
            }else{
            $model->status = 1;
            $data = ['name'=>$model->first_name,'agency' => $model->agency_name,'text' => 'approved'];
            try{
                Mail::to($model->email)->send(new ApproveUser($data));
            }catch(\Exception $e){}   
            }
        $model->save();
        }
        return response()->json(['data' => true]);
    }

    public function fetchRecentData(Request $request){
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
            $condition = "agency_id = '$user->id'";
        }elseif($user->user_type == User::ROLE['admin']){     
            $condition = "agency_id = '$request->agency_id'";
        }else{
            $condition = "agency_id = '$user->agency_id'";
        }

        if($searchValue){
            $condition .= " and (title like '%$searchValue%' or location like '%$searchValue%')";
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
            
            
            $data_arr[] = array(
               // "id" => $value->id,
              "title" =>ucfirst($value->title),
              "start_date" => date('Y-m-d',strtotime($value->start_date)),
              'location'=>mb_strimwidth($value->location,0,30,'...'),  
              'status'=>$value->getStatusValue($value->status),          
             
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
