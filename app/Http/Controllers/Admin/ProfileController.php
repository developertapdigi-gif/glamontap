<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use App\Models\User;
class ProfileController extends Controller
{
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
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'  
      ]);    	 
	 if($request->hasfile('profile_picture'))
      {
        $fileName = time().'.'.$request->profile_picture->extension();
        $request->profile_picture->move(public_path('upload/profile'), $fileName);
        $model->profile_picture = $fileName;
      }
      $model->update($request->all());
      return redirect()
              ->route('supanel.profile')
              ->with('status','Profile has been updated successfully!');
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
              ->route('supanel.profile')
              ->with('status','Password has been updated successfully!');
    }
}
