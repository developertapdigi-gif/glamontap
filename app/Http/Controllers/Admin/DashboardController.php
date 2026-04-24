<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\{User,Job,SkillCategory,Badge,SubscriptionPlans,AgencySubscription,PostEndorsement,UserFeedbackSurvey,Setting,Notification};
class DashboardController extends Controller
{

    public function index(){   
        $today  = date('Y-m-d 00:00:00');
        if(Auth::user()->hasRole('trader')){
            return redirect()->route('tradie.dashboard');
        }
        if(Auth::user()->hasRole('admin')){ 
            $agencies = User::where(['user_type'=>User::ROLE['agency']])->orderby('id', 'desc')->paginate(5)->withQueryString();
            $traders = User::where(['user_type'=>User::ROLE['trader']])->orderby('id', 'desc')->paginate(5)->withQueryString();
            $upcomingJobs = Job::whereRaw(" DATE(start_date) >= '$today' and is_hired=1 and status!=4")->count();
            $asignedJobs = Job::whereRaw("DATE(end_date) >= '$today' and is_hired!=1 and status>0")->count();
            $completedJobs = Job::whereRaw('status = 6')->orderby('id', 'desc')->count();
            $ongoingJobs = Job::whereRaw("is_hired=1 and status=4")->count();
            $totaljobs = $upcomingJobs + $asignedJobs + $completedJobs + $ongoingJobs;
            $skill_category = SkillCategory::where(['status'=>1])->count();
            $badges = Badge::where(['status'=>1])->count();
            $plans = SubscriptionPlans::where(['status'=>1])->count();
            $now        = Carbon::now();
            $startOfMonth   = $now->startOfMonth()->format('Y-m-d 00:00:00');
            $endOfMonth     = $now->endOfMonth()->format('Y-m-d 00:00:00');
            $subscribers = AgencySubscription::whereRaw("end_date BETWEEN '$startOfMonth' and '$endOfMonth'")->orderby('id', 'desc')->paginate(4)->withQueryString();
            $totalEarnings = AgencySubscription::sum('amount');
            return view('admin.users.dashboard',compact('totaljobs','skill_category','badges','plans','agencies','traders','subscribers','totalEarnings'));
        }else{
            $user_id = Auth::user()->user_type == User::ROLE['agency_sub_user']?Auth::user()->agency_id:Auth::user()->id;
                $upcomingJobs = Job::whereRaw(" agency_id ='$user_id' and DATE(start_date) >= '$today' and is_hired=1 and status!=4")->orderby('id', 'desc')->paginate(5)->withQueryString();
                $asignedJobs = Job::whereRaw("agency_id ='$user_id' and DATE(end_date) > '$today' and is_hired!=1 and status>0")->orderby('id', 'desc')->paginate(5)->withQueryString();
                $completedJobs = Job::whereRaw('agency_id ='.$user_id.' and status = 6')->orderby('id', 'desc')->paginate(5)->withQueryString();
                $ongoingJobs = Job::whereRaw("agency_id ='$user_id' and is_hired=1 and status=4")->orderby('created_at', 'desc')->paginate(5)->withQueryString();
               
                $endrosementposts = PostEndorsement::whereRaw('user_id='.$user_id)->orderby('created_at', 'desc')->get();
                $totaljobs = $upcomingJobs->total() + $asignedJobs->total() + $completedJobs->total() + $ongoingJobs->total();
                
                $feedback_survey = UserFeedbackSurvey::where('user_id',$user_id)->first();
                $setting_feedback = Setting::settingFeedback();
                /* $user_created_at = Auth::user()->created_at;
                $createdAt = Carbon::parse($user_created_at)->startOfDay()->addDays($setting_feedback["survey_days"]);
                $currentDate = Carbon::now()->startOfDay(); 
                $daysDifference = $createdAt->diffInDays($currentDate); */
                /* echo ($currentDate);
                echo $setting_feedback["survey_days"]+2; */
                /* if ($setting_feedback['survey_status'] == 1 && empty($feedback_survey) && in_array($daysDifference,[0,1,2]) && $currentDate->greaterThanOrEqualTo($createdAt)  && (!session()->has('feedback_survey') ) ) {
                    $feedback_survey_value = 1;
                    session(['feedback_survey' => now()]);
                }else{
                    $feedback_survey_value = 0;
                } */
               $user_created_at = Auth::user()->created_at;
                // $createdAt = Carbon::parse($user_created_at)->startOfDay()->addDays($setting_feedback["survey_days"]);
                $createdAt = Carbon::parse($user_created_at)
                ->startOfDay()
                ->addDays((int) $setting_feedback["survey_days"]);
                $currentDate = Carbon::now()->startOfDay();
                $daysDifference = $createdAt->diffInDays($currentDate);

                if ($setting_feedback['survey_status'] == 1 && empty($feedback_survey)
                    && in_array($daysDifference, [0, 1, 2])
                    && $currentDate->greaterThanOrEqualTo($createdAt)
                    && (!session()->has('feedback_survey'))) {
                    $feedback_survey_value = 1;
                    session(['feedback_survey' => now()]);
                } else {
                    $feedback_survey_value = 0;
                }
                return view('admin.users.agency_dashboard',compact('totaljobs','upcomingJobs','asignedJobs','completedJobs','ongoingJobs','endrosementposts','feedback_survey_value'));
            
        }
    } 

    public function getEarningsData()
    {
        $earnings = AgencySubscription::selectRaw('SUM(amount) as total, MONTH(created_at) as month')
                            ->groupBy('month')
                            ->orderBy('month')
                            ->get();

        $labels = $earnings->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 1));
        });

        $data = $earnings->pluck('total');

        return response()->json(['labels' => $labels, 'data' => $data]);
    }
    
    public function search(Request $request){
        $search = $request->input('query');
        $agency_results=$trader_results=$sub_user_results=$job_result=$skill_result=$plans_result=0;
        if(!empty($search)){
            if(Auth::user()->hasRole('admin')){
                $agency_results = User::whereRaw("(first_name like '%$search%' or email like '%$search%' or last_name like '%$search%' or agency_name like '%$search%' or address like '%$search%') and user_type = 2 and agency_name IS NOT NULL ")->get();
                $trader_results = User::whereRaw("(first_name like '%$search%' or last_name like '%$search%' or email like '%$search%' or address like '%$search%') and user_type = 3 and first_name!=''")->get();
                $sub_user_results = [];
                $skill_result = SkillCategory::where('name', 'like', "%$search%")->get();
                $plans_result = SubscriptionPlans::where('name', 'like', "%$search%")->get();
                $job_result = Job::whereRaw("(title like '%$search%' or location like '%$search%')")->get();
            }else{
                $plans_result = $skill_result = $trader_results = $agency_results = [];
                $user_id = Auth::user()->user_type == User::ROLE['agency_sub_user']?Auth::user()->agency_id:Auth::user()->id;
                $job_result = Job::whereRaw("(title like '%$search%' or location like '%$search%') and agency_id='$user_id'")->get();
                $sub_user_results = User::whereRaw("(first_name like '%$search%' or last_name like '%$search%' or email like '%$search%' or address like '%$search%') and user_type = 4 and agency_id='$user_id' and first_name!=''")->get();
            }
        
        }
        $data = '';
        if(count($agency_results) == 0 && count($trader_results) == 0 && count($sub_user_results) == 0 && count($job_result) == 0 && count($skill_result) == 0 && count($plans_result) == 0)
        $data = 'no';
        return response()->json([
            'status'=>200,
            'data'=> $data,
            'agencies'=> $agency_results,
            'traders'=> $trader_results,
            'sub_users'=> $sub_user_results,
            'posts'=> $job_result,
            'skills'=> $skill_result,
            'subscription_plan'=> $plans_result
        ]);
    }

     public function feedbackSurvey(Request $request){        
        $request->validate([
            'rating' => 'required',
            'comment' => 'required',       
        ],[
          'rating.required'=>'Please enter rating',
          'comment.required'=>'Please enter comment',
      ]); 
        $user = Auth::user();
       // echo'<pre>';print_r($request->all());die;
        $model = UserFeedbackSurvey::where('user_id',$user->id)->first();
        if($model){
            $model->rating = $request->rating;
            $model->comment = $request->comment;
            $model->user_id = $user->id;
        }else{
            $model = new UserFeedbackSurvey;
            $model->rating = $request->rating;
            $model->comment = $request->comment;
            $model->user_id = $user->id;
        }
        
        $model->save();
        $admin = User::where('user_type',1)->first();
        $userdeatil = User::find($model->user_id);
        $notification = new Notification();
            $savedNotification = $notification->saveNotification([
                'type' => 23,
                'type_text'=>'feedback',
                'sender_id'=>$model->user_id,
                'receiver_id'=>$admin->id,
                'reference_id'=>$user->id,
                'is_viewed'=>0,
                'message'=> ucfirst($userdeatil->first_name).' '.ucfirst($userdeatil->last_name) .' has been added feedback on Tradehook.'
            ]);
        return response()->json(['status' => true]);
    }

    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('id');
        
        $notification = Notification::where('id', $notificationId)->first();
        //print_r($notification);die;
        if ($notification) {
            $notification->is_viewed = 1;
            $notification->save();
            return response()->json(['success' => true]);
        } 

        return response()->json(['success' => false], 404);
    }
    
}
