<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Chatify\Facades\ChatifyMessenger as Chatify;
use App\Rules\{MatchOldPassword,AbnExists};
use App\Models\{User,SkillCategory,Badge,EmailOtp,UserFlags,UserConnection,UserExperienceCertificate,Job,Post,UserFeedPreferences};
use App\Http\Resources\{UserResource,UserCollection,OtherSkillResource};
use App\Mail\PasswordReset;
use Carbon\Carbon;
use App\Mail\Otp;
class AuthController extends BaseController
{    

    /**
     * Trader Login
     *       
     * @param  [string] email
     * @return [string] password
    */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'os' => 'nullable',
            'device_token' => 'nullable',
        ]);
        if ($validator->fails()) {
            return $this->responseApi($validator->messages()->first(), false, __('Validation Errors'), 400);
        } else {
            $credentials = $request->only(["email", "password"]);
            $user = User::where('email', $credentials['email'])->first();          
            if ($user && $user->hasRole('trader')) {
                if (!Auth::attempt($credentials)) {
                    return $this->responseApi([], false, __('Invalid email or password'), 400);
                }   
                if($user->status == 0){ // user block
                    return $this->responseApi([], false, __('Your account has been blocked by Tradehook. Please contact us.'), 400);
                } 
                if($user->status == 2){ // Deactivate block
                    return $this->responseApi([], false, __('Your account has been deleted. Please contact us.'), 400);
                }   
                #DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();         
                $tokenResult = $user->createToken('authToken');
                $token = $tokenResult->token;
                if ($request->remember_me){
                    $token->expires_at = Carbon::now()->addWeeks(1);
                }
                $token->save();
                #send Email OTP to user  
                if($user->status==0){    
                   $this->sendOtp($user);
                }
                $update = User::where('device_token', $request->device_token)->update(['device_token' => null]);;
                $user->os = $request->os;
                $user->device_token = $request->device_token;
                $user->is_logged_in = 1;
                $user->save();
                $userData = $user->getApiData($user);                                
                $userData['token_type'] = 'Bearer';                
                $userData['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
                $userData['token'] = $tokenResult->accessToken;
                return $this->responseApi($userData, true, 'User Login Successfully', 200);
            } else {
                return $this->responseApi([], false, __('Sorry, This User does not exist'),400);
            }
        }
    }
    /**
     * Register Trader
     *
     * @param  [string] first_name
     * @param  [string] last_name
     * @param  [string] email
     * @param  [string] mobile
     * @param  [string] abn_acn
     * @param  [string] address
     * @return [string] message
     * @return [int] status
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50|min:2|regex:/^[a-zA-Z ]*$/',
            'last_name' => 'required|max:50|min:2|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|min:8|max:15|regex:/^[\+?\d\s]*$/|unique:users,mobile',
            'address'=>'required',
            'os' => 'nullable',
            'pincode' => 'nullable',
            'device_token' => 'nullable',
            'password' =>  [
                'required',
                'string',
                'between:8,20',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/^\S+$/',
            ],
            'abn_acn' => ['required','min:11','max:11','unique:users,abn_acn',new AbnExists],
        ],
        [
            'abn_acn.required'=>"The ABN field is required",
            'abn_acn.unique'=>"This ABN already exists",            
            'abn_acn.min'=>"Please enter 11 digit in the ABN field.",            
            'abn_acn.max'=>"Please enter 11 digit in the ABN field.", 
            'password.regex' => 'The password must include at least one uppercase letter, one number, and must not contain any spaces.',     
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        } else {
            $input = $request->all();           
            $input['password']  = Hash::make($input['password']);                 
            $input['user_type'] = User::ROLE['trader'];                 
            $input['status']    = 0;                 
            $user = User::create($input);           
            $user->assignRole('trader');
            /*Send OTP Email*/       
            $this->sendOtp($user);
            
            $tokenResult = $user->createToken('authToken');
            $token = $tokenResult->token;
            $token->save();
            $userData = $user->getApiData($user);                      
            $userData['token_type'] = 'Bearer';                
            $userData['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(); 
            $userData['token'] = $tokenResult->accessToken;      
            return $this->responseApi($userData, true, 'Account Registered Successfully, Please verify your email Id', 200);
        }
    }   
  
    public function emailOtpVerification(Request $request)
    {
        $user = $request->user(); 
        $validator = Validator::make($request->all(), [          
            'otp' => 'required|exists:email_otps',
        ],[
            'otp.exists'=>'Please enter valid OTP'
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        } else {
            $otpModel = EmailOtp::where('email',$user->email)->where('otp',$request->otp)->first();
            if ($otpModel->otp == $request->otp) 
            {
                $user->status = 1;
                $user->email_verified_at = Carbon::now();
                $user->save();
                EmailOtp::where('email',$user->email)->delete();
                $userData = $user->getApiData($user);
                return $this->responseApi($userData, true, 'Email verified Successfully.', 200);
            }else{
                return $this->responseApi([], false, __('OTP expired or incorrect'), 400);
            }
        }
    }
    /**
     * Profile update 
     *
     * @param  [string] first_name
     * @param  [string] last_name
     * @param  [string] email
     * @param  [string] mobile
     * @param  [string] abn_acn
     * @param  [string] address
     * @return [string] message
     * @return [int] status
     */
    public function editProfile(Request $request){
        $user = $request->user(); 
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50|min:2|regex:/^[a-zA-Z ]*$/',
            'last_name' => 'required|max:50|min:2|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|email|unique:users,email,'. $user->id,
            'mobile' => 'required|min:8|max:15|regex:/^[\+?\d\s]*$/|unique:users,mobile,'. $user->id,
            'address'=>'required',
            'skill_category_id'=>'required',
            'other_skill'=>'nullable',
            'badge_id'=>'required',            
            'abn_acn'=>'required|unique:users,abn_acn,'.$user->id,
            'trader_licence' => 'nullable|max:5120',
            'new_experience_certificate.*' => 'nullable|max:5120',
        ],
        [
            'trader_licence.image' => 'The type of the uploaded file should be an image.',
            'trader_licence.max' => 'Failed to upload an image. The image maximum size is 5 MB.',
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        } else {            
            $certificate = $request->new_experience_certificate;
            $input= $request->all();
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
            /* Delete file if value is empty*/
            if($request->trader_licence==''){
                $user->trader_licence = '';
            }
            if($request->new_experience_certificate==''){
                DB::table('user_experience_certificates')->where('user_id',$user->id)->delete();
            }           
            unset($input['other_skill'],$input['experience_certificate'],$input['new_experience_certificate'],$input['new_experience_certificate[]']);
            $user->update($input);          
            /*Save Licence*/
            if($request->file('new_experience_certificate')){
                $certificate = $request->file('new_experience_certificate');
                DB::table('user_experience_certificates')->where('user_id',$user->id)->delete();
                 foreach($certificate as $_file){
                    $fileName      = strtolower($_file->getClientOriginalName());
                    $fileName      = explode('.', $fileName)[0];
                    $fileName      = str_replace(' ', '-', $fileName);
                    $fileName       = $fileName . '-' . time() . rand(0, 9999) . '.' . $_file->getClientOriginalExtension();
                    $_file->move(public_path() . '/uploads/licence/',$fileName);
                    $image_url = 'uploads/licence/' . $fileName;	
                    UserExperienceCertificate::create([
	    		  		'path'=>$image_url,
	    		  		'type'=>1,
	    		  		'user_id'=>$user->id,
	    		  	]);   
                }                 
            }
            if($request->hasfile('trader_licence')){
                $licence    = $request->file('trader_licence');
                $file_name  = strtolower($licence->getClientOriginalName());
                $file_name  = explode('.', $file_name)[0];
                $file_name  = str_replace(' ', '-', $file_name);
                $filename   = $file_name . '-' . time() . rand(0, 9999) . '.' . $licence->getClientOriginalExtension();
                $licence->move(public_path() . '/uploads/licence/',$filename);
                $image_url = 'uploads/licence/' . $filename;
                $user->trader_licence = $image_url;
                
            }           
            $user->save();
            $userData = $user->getApiData($user);
            return $this->responseApi($userData, true, 'Account Updated Successfully.', 200);
        }
    }

    public function deleteCertificate(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => ['required','exists:users,id'],
            'experience_certificate_id' => ['required','exists:user_experience_certificates,id'],
        ]);
         if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 417);
        }else{
            UserExperienceCertificate::where('id',$request->experience_certificate_id)->first()->delete();
            return $this->responseApi([], true, 'Attachment deleted Successfully', 200);
        }
    }
    
    /**
     * Trader Logout (Revoke the token)
     *       
    */
    public function logout(Request $request){
        $model = User::find($request->user()->id);
        $model->update([
            'is_logged_in'=>0,
            'active_status'=>2,
            'device_token'=>NULL,
        ]);
        $request->user()->token()->revoke();
        return $this->responseApi([], true, 'Logout Successfully', 200);
    }
    /*
        Update users current password
    */
    public function passwordUpdate(Request $request){       
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword],
            'password' =>  [
                'required',
                'string',
                'between:8,20',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/^\S+$/',
            ],
            'confirm_password' => ['same:password'],
        ],[
            'password.regex' => 'The password must include at least one uppercase letter, one number, and must not contain any spaces.',
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        }else{
            $user = $request->user();
            $user->update(['password'=> Hash::make($request->password)]);
            return $this->responseApi([], true, 'Password updated Successfully', 200);
        }
    } 
    /**
     * Send OTP to reset password
     *       
    */
    public function requestForgotOtp(Request $request){       
        $validator = Validator::make($request->all(), [
           'email' => 'required|email|exists:users,email,user_type,3',
        ],[
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'email.exists' => __("Email doesn't exists in our system"),
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        }
        $user = User::where('email',$request->email)->first();           
        $this->sendOtp($user);
        return $this->responseApi([], true, 'OTP sent successfully on your email', 200);
    }
    /*
        Verify sent OTP of reset password
    */
    public function forgotOtpVerification(Request $request){       
        $validator = Validator::make($request->all(), [          
            'otp' => 'required|exists:email_otps',
            'email' => 'required|exists:users',
        ],[
            'otp.exists'=>'Please enter valid OTP',
            'email.exists'=>'Please enter valid email Id'
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        } else {            
            $otpModel = EmailOtp::where('email',$request->email)->where('otp',$request->otp)->first();
            $user     = User::where('email',$request->email)->where('user_type',User::ROLE['trader'])->first();
            if ($otpModel->otp == $request->otp && $user) 
            {                
                $user->status = 1;
                $user->email_verified_at = Carbon::now();
                $user->save();
                EmailOtp::where('email',$user->email)->delete();
                $token =Str::random(40);
                DB::table('password_reset_tokens')->where(['email'=>$request->email])->delete();
                DB::table('password_reset_tokens')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);                      
                $userData = $user->getApiData($user);                                
                $userData['token'] = $token;
                return $this->responseApi($userData, true, 'OTP verified Successfully.', 200);
            }else{
                return $this->responseApi([], false, __('OTP expired or incorrect'), 400);
            }
        }
    }
    /*
        Update new password of user
    */
    public function setForgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email,user_type,3',
            'password' =>  [
                'required',
                'string',
                'between:8,20',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/^\S+$/',
            ],
            'confirm_password' => ['same:password'],
            'token'=>'required|exists:password_reset_tokens',            
        ],[
            'token.exists'=>'Please re-verify your email',
            'password.regex' => 'The password must include at least one uppercase letter, one number, and must not contain any spaces.',
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        }else{
            $user = User::where('email',$request->email)->where('user_type',User::ROLE['trader'])->first();
            $user->update(['password'=> Hash::make($request->password)]);
            DB::table('password_reset_tokens')->where(['email'=>$request->email])->delete();
            return $this->responseApi([], true, 'Password updated Successfully, Please login', 200);
        }
    }

    public function getProfile(Request $request){
        $user = $request->user();        
        if($request->user_id){
            $user = User::find($request->user_id);
        }
        if($user){
            $userData = $user->getApiData($user);
            return $this->responseApi($userData, true, 'Profile data fetched Successfully', 200);
        } else {
            return $this->responseApi([], false, __('Sorry, User does not exist'), 400);
        }
    }
    public function updateProfileImage(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ],
            [
                'image.image' => 'The type of the uploaded file should be an image.',
                'image.max' => 'Failed to upload an image. The image maximum size is 5 MB.',
            ]
        );
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        } else {
            $user       = $request->user();
            $image      = $request->file('image');
            $file_name  = strtolower($image->getClientOriginalName());
            $file_name  = explode('.', $file_name)[0];
            $file_name  = str_replace(' ', '-', $file_name);
            $filename   = $file_name . '-' . time() . rand(0, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path() . '/uploads/profile/',$filename);
            $image_url = 'uploads/profile/' . $filename;
            $user->profile_picture = $image_url;
            $user->save();

            $response = [
                'profile_picture' => url($image_url),
            ];
            return $this->responseApi($response, true, 'Profile image uploaded successfully', 200);
        }
    }
    public function fetchSettings()
    {
        $skills = SkillCategory::where('status',1)->select(['id','name'])->get();
        $badges = Badge::where('status',1)->select(['id','name','minimum_range','maximum_range'])->get();
        $skills[] = ['id'=>2800000,'name' => 'Others','status'=>1];
        $settings = [
            'badges' => $badges,
            'skills' => $skills,
            'job_withdraw_time_limit'=>48,
        ];
        return $this->responseApi($settings, true, 'Settings Fetched', 200);
    }
    private function sendOtp($user){
        $otp = mt_rand(10000, 99999);     
        EmailOtp::where('email',$user->email)->delete();
        EmailOtp::create(['email' => $user->email,'otp' => $otp]);
        Mail::to($user->email)->send(new Otp($user->first_name,$otp)); 
    }

    public function searchUsers(Request $request){
        $user      = $request->user();  
        $pageSize  = $request->page_size ?? $request->page_size;  
        $condition = "user_type in(2,3) and id!={$user->id}";  
        if($request->term){
            $query = $request->term;
            $condition .= " and (first_name like '%$query%' or last_name like '%$query%' or agency_name  like '%$query%')";
        }    
        $posts   = User::query()
                    ->whereRaw($condition)
                    ->orderBy('id','desc')
                    ->paginate($pageSize);
        return new UserCollection($posts);
    }
    public function searchTraders(Request $request){
        $user      = $request->user();  
        $pageSize  = $request->page_size ?? $request->page_size;  
        $sentFriedIds = UserConnection::where('user_id',$user->id)  
            ->where('status',1)        
            ->pluck('connection_id')
            ->toArray();
        $recievedFriedIds = UserConnection::where('connection_id',$user->id)        
            ->where('status',1)     
            ->pluck('user_id')
            ->toArray();
        $allUserIds = array_merge($sentFriedIds, $recievedFriedIds);
        $friendsIds    = $allUserIds ? implode(',', $allUserIds):  0;      
        //$condition = "id!={$user->id} and user_type=3 and id not in($friendsIds)";         
        $condition = "id!={$user->id} and user_type=3";         
        if($request->term){
            $query = $request->term;
            $condition .= " and (first_name like '%$query%' or last_name like '%$query%' or email like '%$query%' or address like '%$query%')";
        }    
        $users   = User::query()
                ->whereRaw($condition)
                ->orderBy('id','desc')
                ->paginate($pageSize);
        return new UserCollection($users);
    }

    public function flagUser(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
               'model_id' =>'required',
               'comment' =>'nullable',
               'type' =>['required', 'integer', 'between:1,3'],
            ],
            [
            'type.between'=>'Type field must be 1 or 3'
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        }else{
            $user       = $request->user(); 
            if($request->type == 2){
                $job = Job::find($request->model_id);
                $agency_update = DB::table('users')->where('id',$job->agency_id)->update(['has_complain'=>1]);
            }else if($request->type == 3){
                $agency_update = DB::table('users')->where('id',$request->model_id)->update(['has_complain'=>1]);
            }else if($request->type == 1){
                $post = Post::find($request->model_id);
                $agency_update = DB::table('users')->where('id',$post->author_id)->update(['has_complain'=>1]);
            }
            UserFlags::create([
                'model_id'=>$request->model_id,
                'type'=>$request->type,
                'comment'=>$request->comment,
                'reported_by'=>$user->id,
            ]);
            return $this->responseApi([], true, 'Report added Successfully', 200);
        }
    }
    public function accountDeactivate(Request $request){
        $user = $request->user(); 
        $user->status = 2;
        $user->is_logged_in = 0;
        $user->active_status = 0;
        $user->save();
        $user->token()->revoke();
        Chatify::push('tapdigi-tradehook.'.$user->id,'user_status_offline',[]);
        return $this->responseApi([], true, 'Your account has been successfully deleted.', 200);
    }   
    public function setOnlineStatus(Request $request){
        $user                   = $request->user();
        $activeStatus           = $request->is_logged_in == 1 ? 1 : 0; 
        $user->is_logged_in     = $activeStatus;
        $user->save();    
        if($request->is_logged_in!=1){
            Chatify::push('tapdigi-tradehook.'.$user->id,'user_status_offline',[]);
        }else{
            Chatify::push('tapdigi-tradehook.'.$user->id,'user_status_online',[]);
        }  
        #send event to my friends        
        $connectionIds = UserConnection::where('status', 1)
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('connection_id', $user->id);
            })
            ->selectRaw('CASE 
                WHEN user_id = ? THEN connection_id 
                WHEN connection_id = ? THEN user_id 
            END as connected_id', [$user->id, $user->id])
            ->pluck('connected_id')
            ->toArray();    
        $users   = User::where('is_logged_in',1)->whereIn('id',$connectionIds)->get();            
        foreach($users as $_friend){
            Chatify::push('tapdigi-tradehook.'.$_friend->id,'new_contact_update',[]);    
        }
        #$userData = $user->getApiData($user);
        return $this->responseApi([], true, 'Status changed successfully', 200);
    }


    public function setUserFeedPreferences(Request $request){
        $user = $request->user();
        $validator = Validator::make($request->all(),[
            'skill_id.*' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        }else{
            $skillIds = explode(",", $request->skill_id);
            $allpreferences = UserFeedPreferences::where('user_id',$user->id)->pluck('skill_id')->toArray();
            $addpreferences = array_diff($skillIds, $allpreferences);
            $deletepreferences = array_diff($allpreferences,$skillIds);
            if($deletepreferences){
                UserFeedPreferences::whereIn('skill_id',$deletepreferences)->where('user_id',$user->id)->delete();
            }
            if($addpreferences){
                foreach($addpreferences as $_newpreferences){
                    UserFeedPreferences::create([
                        'user_id' => $user->id,
                        'skill_id'=>$_newpreferences
                    ]);
                }
            }
            return $this->responseApi([], true, 'Preferences saved successfully', 200);
        }

        
    }

    public function getUserFeedPreferences(){
        $user = request()->user();
        $allpreferences = UserFeedPreferences::where('user_id',$user->id)->get();
        $skills = SkillCategory::where('status',1)->select(['id','name'])->get();
        
        return $this->responseApi(OtherSkillResource::collection($skills), true, 'Preferences Fetched', 200);
    }

    public function setOtherSkill(Request $request){
        $user = request()->user();
        $validator = Validator::make($request->all(),[
            'other_skill' => 'required|unique:skill_categories,name',
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        }else{
            SkillCategory::create([
                'name' => $request->other_skill,
                'status'=>1
            ]);
            return $this->responseApi([], true, 'Skill Category added successfully', 200);
        }
    }

    public function updateDeviceToken(Request $request){
        $user = request()->user();
        $validator = Validator::make($request->all(),[
            'device_token' => 'required',
            'device_name'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        }else{
            if($user->device_token != $request->device_token){
                $user->device_token = $request->device_token;
                $user->os = $request->device_name;;
                $user->save();                
            }
            return $this->responseApi([], true, 'Device Token updates successfully', 200);
        }
    }
}
