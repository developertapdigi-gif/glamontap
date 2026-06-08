<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cookie;
use App\Notifications\EmailVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlans as Plan;
use App\Models\{Job,User,AgencySubscription,SkillCategory,EmailOtp};
use App\Mail\{PasswordReset,AgencyRegister,Confirmation,Otp, tradieRegister};
use App\Rules\AcnExists;
use File;

class UserController extends Controller
{

    public function register(){
        $skills = SkillCategory::where('status', 1)->get();
        return view('admin.users.register', compact('skills'));
    }

    public function tradieRegister(){
        $skills = SkillCategory::where('status', 1)->get();
        return view('admin.users.tradie_register', compact('skills'));
    }

    public function tradieRegisterPost(Request $request)
{
    $request->validate([
        'tradie_first_name'       => 'required|regex:/^[a-zA-Z ]*$/',
        'tradie_last_name'        => 'required|regex:/^[a-zA-Z ]*$/',
        'tradie_email'            => 'required|email|unique:users,email',
        'tradie_mobile'           => 'required|numeric|unique:users,mobile',
        'tradie_address'          => 'required',
        'tradie_skill_category_id' => 'required|exists:skill_categories,id',
        'tradie_abn_acn'          => 'nullable|unique:users,abn_acn',
    ], [
        'tradie_first_name.required' => "The first name field is required.",
        'tradie_last_name.required'  => "The last name field is required.",
        'tradie_email.required'      => "The email field is required.",
        'tradie_email.email'         => "Please enter a valid email address.",
        'tradie_email.unique'        => "This email address already exists.",
        'tradie_mobile.required'     => "The mobile field is required.",
        'tradie_mobile.unique'       => "This mobile number already exists.",
        'tradie_address.required'    => "The address field is required.",
        'tradie_skill_category_id.required' => "The skill category field is required.",
        'tradie_abn_acn.unique'     => "This ABN/ACN already exists.",
    ]);

    // Map prefixed input names to database columns
    $input = $request->only([
        'tradie_first_name',
        'tradie_last_name',
        'tradie_email',
        'tradie_mobile',
        'tradie_address',
        'tradie_skill_category_id',
        'tradie_abn_acn',
        'tradie_latitude',
        'tradie_longitude',
        'tradie_city',
        'tradie_state',
        'tradie_country',
        'tradie_pincode',
    ]);

    // Rename keys to match database columns
    $mappedInput = [
        'first_name'       => $input['tradie_first_name'],
        'last_name'        => $input['tradie_last_name'],
        'email'            => $input['tradie_email'],
        'mobile'           => $input['tradie_mobile'],
        'address'          => $input['tradie_address'],
        'skill_category_id' => $input['tradie_skill_category_id'],
        'abn_acn'          => $input['tradie_abn_acn'] ?? null,
        'latitude'         => $input['tradie_latitude'] ?? null,
        'longitude'        => $input['tradie_longitude'] ?? null,
        'city'             => $input['tradie_city'] ?? null,
        'state'            => $input['tradie_state'] ?? null,
        'country'          => $input['tradie_country'] ?? null,
        'pincode'          => $input['tradie_pincode'] ?? null,
        'password'         => Hash::make('apr_800#'),
        'user_type'        => User::ROLE['trader'],
        'status'           => 0, // Pending OTP verification
    ];

    // Create user
    $user = User::create($mappedInput);
    $user->assignRole('trader');

    // Generate token for password reset
    $token = Str::random(40);
    DB::table('password_reset_tokens')->insert([
        'email'      => $user->email,
        'token'      => $token,
        'created_at' => Carbon::now(),
    ]);

    // Send OTP
    $otp = mt_rand(10000, 99999);
    EmailOtp::where('email', $user->email)->delete();
    EmailOtp::create([
        'email' => $user->email,
        'otp'   => $otp,
        // 'otp_expire_at' => Carbon::now()->addMinutes(10), // Uncomment if you want expiry
    ]);

    // Send registration email
    $name = $user->first_name . ' ' . $user->last_name;
    try {
        Mail::to($user->email)->send(new tradieRegister($name, $token));
    } catch (\Exception $e) {
        // Log error if needed
    }

    return redirect('user/register')->with('success', 'Please check your email to set password.');
}

    
    
    
    public function tradieVerify(Request $request){
        return view('admin.users.tradie_verify', ['email' => $request->email]);
    }

    public function tradieVerifyPost(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp'   => 'required',
        ]);

        $otpModel = EmailOtp::where('email', $request->email)->where('otp', $request->otp)->first();
        if (!$otpModel) {
            return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        User::where('email', $request->email)->update([
            'status'            => 1,
            'email_verified_at' => now(),
        ]);
        EmailOtp::where('email', $request->email)->delete();

        return redirect('user/login')->with('success', 'Email verified! You can now login.');
    }
    public function registerpost(Request $request)
{
    $request->validate([
        'company_first_name' => 'required|regex:/^[a-zA-Z ]*$/',
        'company_last_name'  => 'required|regex:/^[a-zA-Z ]*$/',
        'company_email'      => 'required|email|unique:users,email',
        'company_mobile'     => 'nullable|numeric|unique:users,mobile',
        'company_abn_acn'    => ['nullable', 'min:9', 'max:11', 'unique:users,abn_acn', new AcnExists],
        'company_address'    => 'required',
    ], [
        'company_first_name.required' => "The first name field is required.",
        'company_last_name.required'  => "The last name field is required.",
        'company_email.required'      => "Please enter a valid email address.",
        'company_email.email'         => "Please enter a valid email address.",
        'company_email.unique'        => "This email address already exists.",
        'company_mobile.unique'       => "This mobile number already exists.",
        'company_abn_acn.required'    => "The ACN field is required.",
        'company_abn_acn.unique'      => "This ACN already exists.",
        'company_abn_acn.min'         => "Please enter 9 to 11 digits in the ACN/ABN field.",
        'company_abn_acn.max'         => "Please enter 9 to 11 digits in the ACN/ABN field.",
        'company_address.required'    => "The address field is required.",
    ]);

    // Remove spaces from mobile if provided
    if ($request->company_mobile) {
        $request->merge(['company_mobile' => str_replace(' ', '', $request->company_mobile)]);
    }

    // Map prefixed input names to database columns
    $input = $request->only([
        'company_first_name',
        'company_last_name',
        'company_email',
        'company_mobile',
        'company_abn_acn',
        'company_address',
        'company_latitude',
        'company_longitude',
        'company_city',
        'company_state',
        'company_country',
        'company_pincode',
        'company_street',
    ]);

    // Rename keys to match database columns
    $mappedInput = [
        'first_name' => $input['company_first_name'],
        'last_name'  => $input['company_last_name'],
        'email'      => $input['company_email'],
        'mobile'     => $input['company_mobile'] ?? null,
        'abn_acn'    => $input['company_abn_acn'] ?? null,
        'address'    => $input['company_address'],
        'latitude'   => $input['company_latitude'] ?? null,
        'longitude'  => $input['company_longitude'] ?? null,
        'city'       => $input['company_city'] ?? null,
        'state'      => $input['company_state'] ?? null,
        'country'    => $input['company_country'] ?? null,
        'pincode'    => $input['company_pincode'] ?? null,
        'street'     => $input['company_street'] ?? null,
        'user_type'  => User::ROLE['agency'],
        'status'     => 1,
        'password'   => Hash::make('apr_800#'),
    ];

    // Create user
    $user = User::create($mappedInput);
    $user->assignRole('agency');

    // Generate token for password reset
    $token = Str::random(40);
    DB::table('password_reset_tokens')->insert([
        'email'      => $user->email,
        'token'      => $token,
        'created_at' => Carbon::now(),
    ]);

    // Add trial plan
    $plan = Plan::find(4);
    $start_date = date('Y-m-d H:i:s');
    $end_date = date('Y-m-d H:i:s', strtotime("+ 14 days"));

    AgencySubscription::create([
        'agency_id'           => $user->id,
        'plan_id'             => $plan->id,
        'payment_status'      => 1,
        'tradesman_limit'     => $plan->tradesman_limit,
        'job_limit'           => $plan->job_limit,
        'subscription_type'   => 1,
        'amount'              => 0,
        'used_job_qty'        => 0,
        'used_tradesman_qty' => 0,
        'start_date'          => $start_date,
        'end_date'            => $end_date,
    ]);

    // Send registration email
    $name = $user->first_name . ' ' . $user->last_name;
    try {
        Mail::to($user->email)->send(new AgencyRegister($name, $token));
    } catch (\Exception $e) {
        // Log error if needed
    }

    return redirect('user/register')->with('success', 'Please check your email to set password.');
}
    public function login(){
        return view('admin.users.login');
    }
    public function loginPost(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'rememberme'=>'nullable'
        ],[
            'email.required'=>"Please enter valid username",
            'email.exists'=>"Please enter valid username and password",
        ]);
        $checkUserRole = User::where('email',$request->email)->whereIn('user_type',[1,2,3,4])->first();
        
        if(!$checkUserRole){
            return redirect()->back()
              ->withInput()
              ->withErrors(['email' => "Password and Email don't match." ]);
        }
        if($checkUserRole->status!=1 || ($checkUserRole->user_type == 4 && $checkUserRole->agency && $checkUserRole->agency->status!=1)){
             return redirect()->back()
              ->withInput()
              ->withErrors(['email' => "Your account has been temporarily blocked. Please contact our support team for assistance." ]);
        }        
        $data = [
            'email' =>$request->email,
            'password' =>$request->password,
            'status' =>1
        ];
        $remember = false;
        if( $request->rememberme){
            $remember = true;
        }        
        if (Auth::attempt($data, $remember)) {
            if($remember){
                Cookie::queue('login_email',$request->email, 3600);
                Cookie::queue('login_password',$request->password, 3600); 
            }else{
                Cookie::queue('login_email','', -1);
                Cookie::queue('login_password','', -1);
            }   
            $checkUserRole->update(['is_logged_in'=>1]);
            if($checkUserRole->hasRole('trader')){
                return redirect()->route('tradie.dashboard')->with('success','Login successfully');
            }
            return redirect()->route('dashboard')->with('success','Login successfully');
        }   
        return redirect()->back()
              ->withInput()
              ->withErrors(['email' => "Password and Email don't match." ]);
    }

    public function updateAgency(Request $request){
        $model = User::findOrFail(Auth::id());       
        $request->validate([
        'agency_name' => 'required|unique:users,agency_name,'.$model->id,
        'address'=>'required',
        'facebook_url'=>'nullable',
        'linkedin_url'=>'nullable',
        'twitter_url'=>'nullable',
    ]);
    $data = $request->except('instagram_url');
    $data['twitter_url'] = $request->instagram_url;
    $model->update($data);
   
    return redirect()
          ->route('profile')
          ->with('success','Agency Profile Detail has been updated successfully!');
    }

    public function  verifyEmail($token){
        $model = User::where('email_verify_token',$token)->first();
        if(!$model){
            abort(404);
        }
        $model->is_email_verified = 1;
        $model->email_verified_at = date('Y-m-d H:i:s');
        $model->save();
        $name = $model->first_name.' '.$model->last_name;
        try{
            Mail::to($model->email)->send(new Welcome($name)); 
        }catch(\Exception $e){}
        return redirect(route('user.login'))->with('success', 'Page has been verified successfully!');
    }
    public function logout(Request $request){
        $model = User::find(Auth::user()->id);
        $model->update([
            'is_logged_in'=>0,
            'active_status'=>2,
        ]);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('user/login');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => [
                'required',
                'string',
                'between:8,20',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/^\S+$/',
            ],
            'new_confirm_password' =>'required|same:new_password',
        ],[
            'new_password.regex' => 'The password must include at least one uppercase letter, one number, and must not contain any spaces.',
        ]);

        User::find(Auth::id())->update(['password'=> Hash::make($request->new_password)]);
        return redirect()
              ->route('profile')
              ->with('success','Password has been updated successfully!');
    }
    public function showResetForm(){
        return view('admin.users.forgot');
    }
    public function postResetForm(Request $request){
        $request->validate([
           'email' => 'required|email|exists:users,email',
        ],[
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'email.exists' => __("Email doesn't exists in our system"),
        ]);
        $user = User::where('email',$request->email)->whereIn('user_type',[1,2,4,3])->first();
        if(!$user){
            return redirect('user/password/reset')
            ->with('error',"Email doesn't exists in our system");
        }
        $token =Str::random(40);
        $data_token = DB::table('password_reset_tokens')->where(['email'=>$request->email]);
        if($data_token)
        $data_token->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        #send email
        $name = $user->first_name.' '.$user->last_name;
        try{
            Mail::to($user->email)->send(new PasswordReset($name,$token));
        }catch(\Exception $e){}        
        return redirect('user/password/reset')
              ->with('success',__("Please check your email for password reset link."));
    }
    public function showNewPassForm(Request $request, $token){       
       $checktoken = DB::table('password_reset_tokens')
                ->where('token','=',$token)
                ->where('created_at','>',Carbon::now()->subHours(2))
                 ->first();
        if($checktoken)
            return view('admin.users.newpass');
        else
            return redirect('user/password/reset')
            ->with('error',"Your session has been expired. Please again add your register email for set a new passowrd.");
    }

    public function setNewPass(Request $request){
        $request->validate([
            'token'=>'nullable',            
            'password' =>  [
                'required',
                'string',
                'between:8,20',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/^\S+$/',
            ],           
            'password_confirmation' => 'required|same:password',
        ],[
            'password.regex' => 'The password must include at least one uppercase letter, one number, and must not contain any spaces.',
        ]);
       $token = DB::table('password_reset_tokens')
                ->where('token','=',$request->token)
                ->where('created_at','>',Carbon::now()->subHours(2))
                ->first();
        if(empty($token->email)){
            return view('admin.users.newpass');
        }
        $user = User::where('email', $token->email)->first();
        if(empty($user->id)){
            return view('admin.users.newpass');
        }
        $user->password = Hash::make($request->password);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->status = 1;
        $user->save();
       //Delete the token
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
       return redirect('user/login')->with('success', 'Password has been updated successfully!');
    }
    public function showProfile(){
        $model = User::findOrFail(Auth::id());
        if($model->user_type == User::ROLE['admin']){
            $agencies = User::where('user_type',User::ROLE['agency'])->orderby('id', 'desc')->paginate(5)->withQueryString();
            return view('admin.users.showprofile',['model'=>$model,'agencies'=>$agencies]);
        }else{
            $userid = ($model->user_type == User::ROLE['agency'])?$model->id:$model->agency_id;
            $completedJobs = Job::whereRaw('agency_id ='.$userid.' and status = 6')->orderby('id', 'desc')->paginate(5)->withQueryString();
            return view('admin.agency.showprofile',['model'=>$model,'completedJobs'=>$completedJobs]);
        }
    }
    public function storeMedia(Request $request)
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
    public function storeLogoMedia(Request $request)
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
     public function getProfile(){
        $model = User::findOrFail(Auth::id());
        return view('admin.users.profile',['model'=>$model]);
    }
    public function updateProfile(Request $request){
        $model = User::findOrFail(Auth::id());
        $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:users,email,'.$model->id,
        'mobile' => 'nullable|unique:users,mobile,'.$model->id,
        //'profile_picture' => ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
    ]);
    if($request->mobile){
        $request->request->set('mobile',str_replace(' ','',$request->mobile));
    }
    
    $model->update($request->all());
    
    return redirect()
          ->route('showprofile')
          ->with('success','Profile has been updated successfully!');
    }

    
    public function fetchSubscriber(Request $request){
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
        
        $now        = Carbon::now();   
        $dateNow    = $now->format('Y-m-d 00:00:00');
        $condition  = 'id>0';     
        $startOfMonth   = $now->startOfMonth()->format('Y-m-d 00:00:00');
        $endOfMonth     = $now->endOfMonth()->format('Y-m-d 00:00:00');
        $condition .= " and plan_id!=4 and start_date BETWEEN '$startOfMonth' and '$endOfMonth'"; 
        $totalRecords = AgencySubscription::select('count(*) as allcount')->count();
        $totalRecordswithFilter = AgencySubscription::select('count(*) as allcount')->whereRaw($condition)->count();

        $collection = AgencySubscription::orderBy($columnName,$columnSortOrder)
            ->whereRaw($condition)
            ->select('agency_subscriptions.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        foreach ($collection as $key => $value) { 
            $url = '';
            if($value->agency->logo && (File::exists(public_path($value->agency->logo)))){
                $url .= '<img src="'.asset($value->agency->logo).'" height="30px" class="profile-image profile-image1">';
            }else{
                $url .= '<img src="'.asset('images/icons/brand-logo2.png').'" height="30px" class="profile-image profile-image1">';
            }          
            $data_arr[] = array(
                "id"=>$value->id,
              "logo" => $url,
              "agency_id" =>ucfirst($value->agency->agency_name),            
              "start_date" =>Date(config('app.date_format'),strtotime($value->start_date)),
              "address"=>mb_strimwidth($value->agency->address,0,30,'...'),
              "status" =>$value->getStatus($value->payment_status)
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