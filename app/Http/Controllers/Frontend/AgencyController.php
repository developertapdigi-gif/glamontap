<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Mail\Confirmation;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use App\Models\User;

class AgencyController extends Controller
{
    public function dashboard(){
        return view('frontend.users.welcome');
    }
    public function register(){
        return view('frontend.users.register');
    }
    public function registerpost(Request $request){
        $request->validate([
            'first_name' =>'required',
            'last_name' =>'required',
            'email' => 'required|email|unique:users',
            'mobile' =>'required|unique:users',
            'abn_acn' => 'required|unique:users',
        ],[
            'email.required'=>"Please enter valid username",
            'abn_acn.required'=>"The ABN or ACN field is required",
            'email.unique'=>"This email address already exists",
            'mobile.unique'=>"This mobile number already exists",
            'abn_acn.unique'=>"This ABN/ACN already exists",
        ]);
        $input  = $request->all();
        $input['user_type'] = User::ROLE['agency'];
        $input['status']    = 1;
        $input['password']  = Hash::make('apr_800#');

        $user = User::create($input);
        $user->assignRole('agency');

        $token =    Str::random(40);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
            $name = $user->first_name.' '.$user->last_name;
            Mail::to($user->email)->send(new Confirmation($name,$token));
        return redirect('register')->with('success', 'Please check your email for password reset link.');
    }

    public function showForgotForm(){
        return view('frontend.users.forgot');
    }
    public function postResetForm(Request $request){
        $request->validate([
           'email' => 'required|email|exists:users,email',
        ],[
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'email.exists' => __("Email doesn't exists in our system"),
        ]);

        $user = User::where('email',$request->email)->first();
        $token =Str::random(40);
        $passwrd_reset = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
        ]);
        if($passwrd_reset){
            $passwrd_reset->delete();
        }
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        #send email
        $name = $user->first_name.' '.$user->last_name;
        Mail::to($user->email)->send(new Confirmation($name,$token));
        return redirect('password/forgot')
              ->with('success',__("Please check your email for password reset link."));
    }

    public function ConfirmPasswordForm(Request $request){
        return view('frontend.users.confirm');
    }
    public function createNewPass(Request $request){
        $request->validate([
           'token'=>'nullable',
           'password_confirmation' => 'required',
           'password' => 'required|confirmed|min:6',
       ]);
      $token = DB::table('password_reset_tokens')
               ->where('token','=',$request->token)
               ->where('created_at','>',Carbon::now()->subHours(2))
                ->first();
       if(empty($token->email)){
           return view('frontend.users.confirm');
       }
       $user = User::where('email', $token->email)->first();
       if(empty($user->id)){
           return view('frontend.users.confirm');
       }
       $user->password = Hash::make($request->password);
       $user->status = 1;
       $user->save();
      //Delete the token
       DB::table('password_reset_tokens')->where('email', $user->email)->delete();
      return redirect('login')->with('success', 'Password has been updated successfully!');
   }
    public function login(){
        return view('frontend.users.login');
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
        $checkUserRole = User::where('email',$request->email)->whereIn('user_type',[2,3])->first();
        //print_r($checkUserRole->user_type);die;
        if(!$checkUserRole){
            return redirect()->back()
              ->withInput()
              ->withErrors(['email' => 'Wrong email or password.' ]);
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
            return redirect('/')->with('success','Login successfully');

        }
       // if unsuccessful -> redirect back
        return redirect()->back()
              ->withInput()
              ->withErrors(['email' => 'Wrong email or password.' ]);
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(Auth::id())->update(['password'=> Hash::make($request->new_password)]);
        return redirect()
              ->route('profile')
              ->with('status','Password has been updated successfully!');
    }
    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function getProfile(){
        $model = User::findOrFail(Auth::id());
        return view('frontend.users.profile',['model'=>$model]);
    }

    public function updateProfile(Request $request){
        $model = User::findOrFail(Auth::id());
        $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:users,email,'.$model->id,
        'mobile' => 'required|unique:users,mobile,'.$model->id,
        'profile_picture' => ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
    ]);
    $request->request->set('mobile',str_replace(' ','',$request->mobile));
    $model->update($request->all());
    if($request->hasfile('profile_picture')){
        $fileName = time().'.'.$request->profile_picture->extension();
        $request->profile_picture->move(public_path('uploads/profile'), $fileName);
        $request->request->remove('profile_picture');
        $model->profile_picture = 'uploads/profile/'.$fileName;
        $model->save();
    }
    return redirect()
          ->route('profile')
          ->with('status','Profile has been updated successfully!');
    }

    public function updateAgency(Request $request){
        $model = User::findOrFail(Auth::id());
        $request->validate([
        'agency_name' => 'required',
        'address'=>'required',
        'latitude'=>'required',
        'longitude'=>'required',
        'logo' => ['nullable']
    ]);
    $model->update($request->all());
    if($request->hasfile('logo')){
        $fileName = time().'.'.$request->logo->extension();
        $request->logo->move(public_path('uploads/logo'), $fileName);
        $request->request->remove('logo');
        $model->logo = 'uploads/logo/'.$fileName;
        //print_r($model->logo);die;
        $model->save();
    }
    return redirect()
          ->route('profile')
          ->with('status','Agency Detasils has been updated successfully!');
    }


}
