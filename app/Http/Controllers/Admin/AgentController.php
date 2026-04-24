<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SkillCategory;
use App\Models\Badge;
use App\Mail\{AgentRegister,UnBlock,BlockUser};
use File;
class AgentController extends Controller
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
        $condition .= ' and user_type='.User::ROLE['agency_sub_user']; 
        if(User::ROLE['agency'] == Auth::user()->user_type){
            $condition .= ' and agency_id = '.Auth::user()->id;
        }
        $agents = User::whereRaw($condition)->orderby('id', 'desc')->paginate(10)->withQueryString();       
        $skill_categories =SkillCategory::getAllSkillCategory();
        return view('admin.agents.list_n_grid',compact('agents','skill_categories'));
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
        $user = Auth::user(); 
        $sub_user = 0;
        if($user->user_type == User::ROLE['agency']){
            $agency_id = $user->id;
        }else if($user->user_type == User::ROLE['agency']){
            $agency_id = $user->agency_id;
            $sub_user = 1;
        }
        $sub_users = User::where('agency_id',$agency_id)->count();
        if( $sub_users < 5){
            $status = User::STATUS;;
            $skill_categories =SkillCategory::getAllSkillCategory();
            $badges =Badge::getAllBadges();
            return view('admin.agents.create',[
                'status'=>$status,
                'skill_categories'=>$skill_categories,
                'badges'=>$badges
            ]);
        }else{
            return redirect('dashboard')->with('error', "Your limit has been completed!");
        }
        
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
            'mobile' => 'nullable|unique:users',
            'user_type' => 'nullable',
            'address'=>'required',            
        ]); 
        if($request->mobile){
            $request->request->set('mobile',str_replace(' ','',$request->mobile));
        }
        $input              = $request->all();
        $input['user_type'] = User::ROLE['agency_sub_user'];      
        $input['password']  = Hash::make('apr_800#');
        $input['agency_id'] = Auth::user()->id;
        
        $model = User::create($input);
        $model->assignRole('agency_sub_user');
        $token =Str::random(40);
        DB::table('password_reset_tokens')->insert([
            'email' => $model->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        if($model->status==1){
            $agency_name = ($model->agency->agency_name)?$model->agency->agency_name:$model->agency->first_name;
            $data = ['agency' => $agency_name,'name' => $model->first_name];
            try{
                Mail::to($model->email)->send(new AgentRegister($data,$token));
                }catch(\Exception $e){} 
        }        
        return redirect('agent')->with('success', 'Sub User has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = User::find($id);
        return view('admin.agents.show')->with(['model'=>$model]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = User::find($id);
        $skill_categories =SkillCategory::getAllSkillCategory();
        $badges =Badge::getAllBadges();
        return view('admin.agents.update',
            [
            'model'=>$model,
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
            'mobile' => 'nullable|numeric|unique:users,mobile,'.$model->id,
            'address'=>'required',
        ]);
        $input       = $request->all();        
        $model->update($input);
        
        return redirect('agent')->with('success', 'Sub User has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->user_type == User::ROLE['agency'] || Auth::user()->user_type == User::ROLE['admin']){
            $model = User::find($id);
                //if($model->agency_id == Auth::user()->id){
                    DB::table('password_reset_tokens')->where('email',$model->email)->delete();
                    $model->delete();
               // }
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
        $userType = User::ROLE['agency_sub_user'];
        $condition = "(user_type=$userType)";
        if(User::ROLE['agency'] == $user->user_type){
            $condition .= "and agency_id = $user->id";
        }
        if($searchValue){
             $condition .= " and (first_name like '%$searchValue%' or email like '%$searchValue%' or address like '%$searchValue%')";
        }
        if($request->filter_skill && $request->filter_skill!='-1'){
            $condition .= " and skill_category_id={$request->filter_skill}";
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
            if ($user) {
                if($value->status == 1){
                    $buttons .= '<button type="button" id="button-attribute" class="btn btn-icon btn-sm btn-color-dark" onclick="activateRecord('.$value->id.','.$value->status.')" data = "{{$value->status}}">
                         <i class="skill-table-action bi bi-x-lg" id="close" ></i>
                    </button>';
                }else{
                    $buttons .= '<button type="button" id="button-attribute" class="btn btn-icon btn-sm btn-color-dark" onclick="activateRecord('.$value->id.','.$value->status.')" data = "{{$value->status}}">
                            <i class="skill-table-action bi bi-check skill-tooltip" id="check"></i>
                        </button>';
                }  
                if(User::ROLE['agency'] == $user->user_type){
                    $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("agent.edit", $value->id) . '"><i class="skill-table-action fas fa-edit"></i></a>';
                }    
                $buttons .= ' <button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="deleteRecord(' . $value->id . ')"><i class="skill-table-action fas fa-trash"></i>';
            }
            $agency = 'N/A';
            if($value->agency){
                $agency = $value->agency->agency_name??$value->agency->first_name.' '.$value->agency->last_name;
                $url = '';
                if($value->profile_picture && (File::exists(public_path($value->profile_picture)))){
                    $url .= '<img src="'.asset($value->profile_picture).'" height="30px" class="profile-image">';
                }else{
                    $url .= '<img src="'.asset('images/icons/brand-logo2.png').'" height="30px" class="profile-image">';
                } 
                
            }
            $data_arr[] = array(
                "id" => $value->id,
                "logo"=> $url,
              
              "first_name" => $value->first_name.' '.$value->last_name,
              "address" => mb_strimwidth($value->address,0,30,'...'),
              "created_at" => date('d M Y',strtotime($value->created_at)),
              "agency_id" => $agency,
              "email" => $value->email,
              "status" => $value->getStatus($value->status),
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
                $model->active_status=2;
                $data = ['name'=>$model->first_name,'email' => $model->email];
                    try{
                        Mail::to($model->email)->send(new BlockUser($data));
                    }catch(\Exception $e){}
            }else{
                if($model->status == 2){
                    $data = ['name'=>$model->first_name,'email' => $model->email];
                    try{
                        Mail::to($model->email)->send(new UnBlock($data));
                    }catch(\Exception $e){}
                }else{
                    if($model->email_verified_at){}else{
                        $password_token = DB::table('password_reset_tokens')->select(['token'])->where('email',$model->email)->first();
                        if($password_token){
                            $token = $password_token->token;
                        }else{
                            $token =Str::random(40);
                            DB::table('password_reset_tokens')->insert([
                                'email' => $model->email,
                                'token' => $token,
                                'created_at' => Carbon::now()
                            ]);
                        }
                        $agency_name = ($model->agency->agency_name)?$model->agency->agency_name:$model->agency->first_name;
                        $data = ['agency' => $agency_name,'name' => $model->first_name];
                        try{
                        Mail::to($model->email)->send(new AgentRegister($data,$token));
                        }catch(\Exception $e){}
                    }
                }
                $model->status = 1;
            }
        $model->save();
        }
        return response()->json(['data' => true,]);
    }
}