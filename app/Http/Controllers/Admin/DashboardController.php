<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\{User,Job,SkillCategory,Badge,SubscriptionPlans,AgencySubscription,PostEndorsement,UserFeedbackSurvey,Setting,Notification,Appointment};
class DashboardController extends Controller
{
    public function index()
    {   
        $today = date('Y-m-d 00:00:00');
        
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
            $now = Carbon::now();
            $startOfMonth = $now->startOfMonth()->format('Y-m-d 00:00:00');
            $endOfMonth = $now->endOfMonth()->format('Y-m-d 00:00:00');
            $subscribers = AgencySubscription::whereRaw("end_date BETWEEN '$startOfMonth' and '$endOfMonth'")->orderby('id', 'desc')->paginate(4)->withQueryString();
            $totalEarnings = AgencySubscription::sum('amount');
            
            return view('admin.users.dashboard', compact('totaljobs','skill_category','badges','plans','agencies','traders','subscribers','totalEarnings'));
        } else {
            $user_id = Auth::user()->user_type == User::ROLE['agency_sub_user'] ? Auth::user()->agency_id : Auth::user()->id;
            
            $upcomingJobs = Job::whereRaw(" agency_id ='$user_id' and DATE(start_date) >= '$today' and is_hired=1 and status!=4")->orderby('id', 'desc')->paginate(5)->withQueryString();
            $asignedJobs = Job::whereRaw("agency_id ='$user_id' and DATE(end_date) > '$today' and is_hired!=1 and status>0")->orderby('id', 'desc')->paginate(5)->withQueryString();
            $completedJobs = Job::whereRaw('agency_id ='.$user_id.' and status = 6')->orderby('id', 'desc')->paginate(5)->withQueryString();
            $ongoingJobs = Job::whereRaw("agency_id ='$user_id' and is_hired=1 and status=4")->orderby('created_at', 'desc')->paginate(5)->withQueryString();
           
            $endrosementposts = PostEndorsement::whereRaw('user_id='.$user_id)->orderby('created_at', 'desc')->get();
            $totaljobs = $upcomingJobs->total() + $asignedJobs->total() + $completedJobs->total() + $ongoingJobs->total();
            
            // Feedback Survey
            $feedback_survey = UserFeedbackSurvey::where('user_id', $user_id)->first();
            $setting_feedback = Setting::settingFeedback();
            $user_created_at = Auth::user()->created_at;
            $createdAt = Carbon::parse($user_created_at)->startOfDay()->addDays((int) $setting_feedback["survey_days"]);
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
            
            // Appointments/Bookings
            $appointments = Appointment::where('salon', $user_id)
                                      ->orderBy('created_at', 'desc')
                                      ->get();
            
            $latestAppointments = Appointment::where('salon', $user_id)
                                        ->whereDate('created_at', Carbon::today())
                                        ->orderBy('created_at', 'desc')
                                        ->get();
            
            $todayAppointments = Appointment::where('salon', $user_id)
                                           ->whereDate('created_at', Carbon::today())
                                           ->orderBy('created_at', 'asc')
                                           ->get();
            
            // Appointment Statistics
            $appointmentStats = [
                'total' => Appointment::where('salon', $user_id)->count(),
                'pending' => Appointment::where('salon', $user_id)->where('status', 'pending')->count(),
                'confirmed' => Appointment::where('salon', $user_id)->where('status', 'confirmed')->count(),
                'completed' => Appointment::where('salon', $user_id)->where('status', 'completed')->count(),
                'cancelled' => Appointment::where('salon', $user_id)->where('status', 'cancelled')->count(),
                'today' => Appointment::where('salon', $user_id)->whereDate('created_at', Carbon::today())->count(),
            ];
            
            return view('admin.users.agency_dashboard', compact(
                'totaljobs',
                'upcomingJobs',
                'asignedJobs',
                'completedJobs',
                'ongoingJobs',
                'endrosementposts',
                'feedback_survey_value',
                'appointments',
                'latestAppointments',
                'todayAppointments',
                'appointmentStats'
            ));
        }
    }

    // Get events for calendar
    public function getAppointmentEvents(Request $request)
    {
        $user_id = Auth::user()->user_type == User::ROLE['agency_sub_user'] ? Auth::user()->agency_id : Auth::user()->id;
        
        $appointments = Appointment::where('salon', $user_id);

        if ($request->start && $request->end) {
            $appointments->whereBetween('created_at', [$request->start, $request->end]);
        }

        $appointments = $appointments->orderBy('created_at', 'asc')->get();

        $events = [];
        foreach ($appointments as $appointment) {
            // Get customer name
            $customer = User::find($appointment->user_id);
            $customerName = $customer ? $customer->first_name . ' ' . $customer->last_name : 'N/A';
            
            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->title ?? 'Appointment',
                'start' => $appointment->created_at->format('Y-m-d H:i:s'),
                'end' => $appointment->updated_at->format('Y-m-d H:i:s'),
                'color' => $this->getAppointmentStatusColor($appointment->status),
                'status' => $appointment->status,
                'customer_name' => $customerName,
                'description' => $appointment->description ?? 'No description',
                'allDay' => false,
                'created_at' => $appointment->created_at->format('Y-m-d H:i:s'),
                'date' => $appointment->date ?? $appointment->created_at->format('Y-m-d'),
                'time' => $appointment->time ?? 'N/A',
            ];
        }

        return response()->json($events);
    }

    private function getAppointmentStatusColor($status)
    {
        $colors = [
            'pending' => '#ffc107',    // Yellow
            'confirmed' => '#0d6efd',  // Blue
            'completed' => '#198754',  // Green
            'cancelled' => '#dc3545',  // Red
        ];
        
        return $colors[$status] ?? '#6c757d';
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
    

    public function customerList(Request $request)
    {
        // Get customers with user_type = 5 (customer role)
        $customerlist = User::where('user_type', User::ROLE['customer'])
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        
        // For grid view mode (if needed)
        $customers = User::where('user_type', User::ROLE['customer'])
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        return view('admin.customer.customer-list', compact('customerlist', 'customers'));

    }


    public function fetchCustomers(Request $request)
    {
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
        
        // Customer user type
        $userType = User::ROLE['customer'];
        $condition = "(user_type = $userType)";
        
        // If customer user, filter by agency_id
        if(User::ROLE['customer'] == $user->user_type){
            $condition .= " and agency_id = $user->id";
        }
        
        // Search functionality
        if($searchValue){
            $condition .= " and (first_name like '%$searchValue%' or last_name like '%$searchValue%' or email like '%$searchValue%' or mobile like '%$searchValue%')";
        }
        
        // Filter by skill (if applicable)
        if($request->filter_skill && $request->filter_skill != '-1'){
            $condition .= " and skill_category_id = {$request->filter_skill}";
        }
        
        // Get total records
        $totalRecords = User::select('count(*) as allcount')
            ->whereRaw($condition)
            ->count();
        
        $totalRecordswithFilter = User::select('count(*) as allcount')
            ->whereRaw($condition)
            ->count();
        
        // Get paginated data
        $collection = User::orderBy($columnName, $columnSortOrder)
            ->whereRaw($condition)
            ->select('users.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        
        // Calculate starting serial number
        $serialNumber = $start + 1;
        
        foreach ($collection as $key => $value) {
            // Prepare data array with serial number
            $data_arr[] = array(
                "id" => $serialNumber++, // Increment serial number for each row
                "first_name" => $value->first_name,
                "last_name" => $value->last_name,
                "email" => $value->email,
                "mobile" => $value->mobile ?? 'N/A',
                "status" => $value->getStatus($value->status), // Assuming getStatus method exists
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