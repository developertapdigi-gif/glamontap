<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\CustomerRegister;
use App\Models\EmailOtp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\{Appointment, Post, PostGallery, SkillCategory, User};
use Illuminate\Support\Facades\Auth;  
use App\Rules\MatchOldPassword;

class CustomerController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        // dd($user);
        $appointments = Appointment::where('user_id', $user->id)->latest()->paginate(20);
       

        // $appliedJobs   = JobApplication::where('bidder_id', $user->id)->where('status', 0)->count();
        // $upcomingJobs  = JobApplication::where('bidder_id', $user->id)->where('status', 1)
        //                     ->whereHas('job', fn($q) => $q->where('status', 5))->count();
        // $ongoingJobs   = JobApplication::where('bidder_id', $user->id)->where('status', 1)
        //                     ->whereHas('job', fn($q) => $q->where('status', 4))->count();
        // $completedJobs = JobApplication::where('bidder_id', $user->id)->where('status', 1)
        //                     ->whereHas('job', fn($q) => $q->where('status', 6))->count();

        // $recentJobs = JobApplication::with('job')
        //                 ->where('bidder_id', $user->id)
        //                 ->latest()->take(5)->get();

        return view('admin.customer.dashboard', compact(
            'appointments'
        ));
    }


    public function register()
    {
        return view('admin.customer.register');
    }

    public function customerRegisterPost(Request $request)
    {
        $request->validate([
            'customer_first_name'       => 'required|regex:/^[a-zA-Z ]*$/',
            'customer_last_name'        => 'required|regex:/^[a-zA-Z ]*$/',
            'customer_email'            => 'required|email|unique:users,email',
            'customer_mobile'           => 'required|numeric|unique:users,mobile',
            'customer_address'          => 'required',
            'customer_abn_acn'          => 'nullable|unique:users,abn_acn',
            'customer_password'         => 'required|min:8',
            'customer_confirm_password' => 'required|same:customer_password'
        ], [
            'customer_first_name.required' => "The first name field is required.",
            'customer_last_name.required'  => "The last name field is required.",
            'customer_email.required'      => "The email field is required.",
            'customer_email.email'         => "Please enter a valid email address.",
            'customer_email.unique'        => "This email address already exists.",
            'customer_mobile.required'     => "The mobile field is required.",
            'customer_mobile.unique'       => "This mobile number already exists.",
            'customer_address.required'    => "The address field is required.",
            'customer_abn_acn.unique'     => "This ABN/ACN already exists.",
            'customer_password.required'   => "The password field is required.",
            'customer_password.min'        => "The password must be at least 8 characters long.",
        ]);

        // Map prefixed input names to database columns
        $input = $request->only([
            'customer_first_name',
            'customer_last_name',
            'customer_email',
            'customer_mobile',
            'customer_address',
            'customer_abn_acn',
            'customer_password',
            'customer_confirm_password',
            'customer_latitude',
            'customer_longitude',
            'customer_city',
            'customer_state',
            'customer_country',
            'customer_pincode',
        ]);

        // Rename keys to match database columns
        $mappedInput = [
            'first_name'       => $input['customer_first_name'],
            'last_name'        => $input['customer_last_name'],
            'email'            => $input['customer_email'],
            'mobile'           => $input['customer_mobile'],
            'address'          => $input['customer_address'],
            'abn_acn'          => $input['customer_abn_acn'] ?? null,
            'latitude'         => $input['customer_latitude'] ?? null,
            'longitude'        => $input['customer_longitude'] ?? null,
            'city'             => $input['customer_city'] ?? null,
            'state'            => $input['customer_state'] ?? null,
            'country'          => $input['customer_country'] ?? null,
            'pincode'          => $input['customer_pincode'] ?? null,
            'password'         => Hash::make($input['customer_password']),
            'user_type'        => User::ROLE['customer'],
            'status'           => 1, // Pending OTP verification
        ];

        // Create user
        $user = User::create($mappedInput);
      
        $user->assignRole('customer');


        // Generate token for password reset
        $token = Str::random(40);
        DB::table('password_reset_tokens')->insert([
            'email'      => $user->email,
            'token'      => $token,
            'created_at' => Carbon::now(),
        ]);

        // // Send OTP
        // $otp = mt_rand(10000, 99999);
        // EmailOtp::where('email', $user->email)->delete();
        // EmailOtp::create([
        //     'email' => $user->email,
        //     'otp'   => $otp,
        //     // 'otp_expire_at' => Carbon::now()->addMinutes(10), // Uncomment if you want expiry
        // ]);

        // Send registration email
        $name = $user->first_name . ' ' . $user->last_name;
        try {
            Mail::to($user->email)->send(new customerRegister($name, $token));
        } catch (\Exception $e) {
            // Log error if needed
        }
        return redirect('customer/register')->with('success', 'customer registered successfully.');
    }


    public function profile()
    {
        $model  = Auth::user();
        $skills = SkillCategory::where('status', 1)->get();
        return view('admin.customer.profile.index', compact('model', 'skills'));
    }

    public function updateProfile(Request $request)
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

        return redirect()->route('admin.customer.profile.index')->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'  => ['required', new MatchOldPassword],
            'new_password'      => 'required|min:8|confirmed',
        ]);

        Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('admin.customer.profile.index')->with('success', 'Password updated successfully.');
    }

    // post management 
     public function postList()
    {
        $posts = Post::with('gallery')->where('author_id', Auth::id())->latest()->paginate(10);
        return view('admin.customer.posts.index', compact('posts'));
    }

    public function createPost()
    {
        $skills = SkillCategory::where('status', 1)->get();
        return view('admin.customer.posts.create', compact('skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'media'       => 'required|file|mimes:jpeg,png,jpg,mp4|max:20480',
        ]);

        $post = Post::create([
            'title'             => $request->title,
            'short_description' => $request->description,
            'author_id'         => Auth::id(),
            'skill_id'          => $request->skill_category_id,
            'status'            => 1,
        ]);

        if ($request->hasFile('media')) {
            $file     = $request->file('media');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/uploads'), $filename);
            PostGallery::create([
                'post_id' => $post->id,
                'path'    => 'uploads/uploads/' . $filename,
                'type'    => in_array($file->getClientOriginalExtension(), ['mp4']) ? 2 : 1,
            ]);
        }

        return redirect()->route('customer.posts.list')->with('success', 'Post created successfully.');
    }

    public function show($id)
    {
        $post = Post::with(['gallery', 'SkillCategory'])->where('id', $id)->where('author_id', Auth::id())->firstOrFail();
        return view('admin.customer.posts.show', compact('post'));
    }

        public function edit($id)
    {
        $post   = Post::where('id', $id)->where('author_id', Auth::id())->firstOrFail();
        $skills = SkillCategory::where('status', 1)->get();
        return view('admin.customer.posts.edit', compact('post', 'skills'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('id', $id)->where('author_id', Auth::id())->firstOrFail();

        // Only editable within 2 days
        if ($post->created_at->diffInDays(now()) > 2) {
            return redirect()->route('customer.posts.list')->with('error', 'Post can only be edited within 2 days.');
        }

        $request->validate([
            'title'       => 'required',
            'description' => 'required',
        ]);

        $post->update([
            'title'             => $request->title,
            'short_description' => $request->description,
            'skill_id'          => $request->skill_category_id,
        ]);

        return redirect()->route('customer.posts.list')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        Post::where('id', $id)->where('author_id', Auth::id())->firstOrFail()->delete();
        return redirect()->route('customer.posts.list')->with('success', 'Post deleted successfully.');
    }


}
