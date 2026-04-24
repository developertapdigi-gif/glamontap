<?php

namespace App\Http\Controllers\Tradie;

use App\Http\Controllers\Controller;
use App\Models\{User, SkillCategory};
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class ProfileController extends Controller
{
    public function index()
    {
        $model  = Auth::user();
        $skills = SkillCategory::where('status', 1)->get();
        return view('tradie.profile.index', compact('model', 'skills'));
    }

    public function update(Request $request)
    {
        $model = Auth::user();
        $request->validate([
            'first_name'        => 'required',
            'last_name'         => 'required',
            'email'             => 'required|email|unique:users,email,' . $model->id,
            'mobile'            => 'nullable|unique:users,mobile,' . $model->id,
            'address'           => 'required',
            'skill_category_id' => 'required|exists:skill_categories,id',
        ]);

        $model->update($request->except(['password', 'password_confirmation']));

        if ($request->hasFile('profile_picture')) {
            $file     = $request->file('profile_picture');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $model->update(['profile_picture' => 'uploads/profile/' . $filename]);
        }

        return redirect()->route('tradie.profile.index')->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'  => ['required', new MatchOldPassword],
            'new_password'      => 'required|min:8|confirmed',
        ]);

        Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('tradie.profile.index')->with('success', 'Password updated successfully.');
    }
}
