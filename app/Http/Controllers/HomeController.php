<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\{Setting,User,Job,SkillCategory,Post,PostGallery,PostLike};
use App\Mail\ContactForm;
use App\Models\SubscriptionPlans as Plan;
use App\Models\PlansAddon;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class HomeController  extends Controller
{
	public function index()
    {  
        if(request()->input('emp')){
            session()->forget('employer_mode');
        }
        $today  = date('Y-m-d 00:00:00');
       $jobs =  Job::whereRaw("home_seen_job = 1 and DATE(start_date) >= '$today' and status!=4  and status!=3")->orderby('id', 'asc')->get();
       $minimumRecords = 1;
        if ($jobs->count() == 5) {
	    $recordsToAdd = 1;
	    $duplicateIndex = 1;
	
	    //for ($i = 0; $i < $recordsToAdd; $i++) {
	        $randomJob = $jobs->random();     
	        $duplicateJob = new Job($randomJob->getAttributes());    
	        $duplicateJob->duplicate_id = $duplicateIndex++;
	        $jobs->push($duplicateJob);
	    //}
	} 
    $settings = Setting::first();
    $skills = SkillCategory::where('status', 1)->get();
    $company = User::where('user_type', 2)->where('first_name', '!=', '')->where('status',1)->get();

    $traders = User::where('user_type', 3)->where('first_name', '!=', '')->where('home_seen_trader',1)->get();
    /* if ($traders->count() < $minimumRecords) {
	    $recordsToAdd = $minimumRecords - $traders->count();
	    $duplicateIndex = 1;
        if($traders){
            for ($i = 0; $i < $recordsToAdd; $i++) {
                $randomtrader = $traders->random();     
                $duplicateTrader = new Job($randomtrader->getAttributes());    
                $duplicateTrader->duplicate_id = $duplicateIndex++;
                $traders->push($duplicateTrader);
	        }
        }
	    
	} */
   
    $mixjobs = Job::whereRaw("home_seen_job = 1 and DATE(start_date) >= '$today' and status!=4  and status!=3")->orderby('id', 'asc')->get();
    $mixtraders = User::where('user_type', 3)->where('first_name', '!=', '')->where('home_seen_trader',1)->orderBy('id', 'desc')->get();
    $merged = $mixtraders->merge($mixjobs);
    return view('website.home',compact('jobs','traders','mixjobs','mixtraders','merged', 'skills', 'company'));
    }

    public function employer()
    {  
         session(['employer_mode' => true]);
        $today  = date('Y-m-d 00:00:00');
       $jobs =  Job::whereRaw("home_seen_job = 1 and DATE(start_date) >= '$today' and status!=4  and status!=3")->orderby('id', 'asc')->get();
       
    $settings = Setting::first();
    $traders = User::where('user_type', 3)->where('first_name', '!=', '')->where('home_seen_trader',1)->get();

    $posts = Post::with('author')
    ->where('status', '1')
    ->withCount([
        'likes as likes_count' => function ($query) {
            $query->where('type', 1);
        },
        'likes as dislikes_count' => function ($query) {
            $query->where('type', 2);
        }
    ])
    ->get();

    $company = User::where('user_type', 2)->where('first_name', '!=', '')->where('status',1)->get();
    
    
    $minimumRecords = 1;
       if ($traders->count() == 5) {
	    $recordsToAdd = 1;
	    $duplicateIndex = 1;
        if($traders){
            //for ($i = 0; $i < $recordsToAdd; $i++) {
                $randomtrader = $traders->random();     
                $duplicateTrader = new User($randomtrader->getAttributes());    
                $duplicateTrader->duplicate_id = $duplicateIndex++;
                $traders->push($duplicateTrader);
	        //}
        }
	    
	}
    $mixjobs = Job::whereRaw("home_seen_job = 1 and DATE(start_date) >= '$today' and status!=4  and status!=3")->orderby('id', 'asc')->get();
    $mixtraders = User::where('user_type', 3)->where('first_name', '!=', '')->where('home_seen_trader',1)->orderBy('id', 'desc')->get();
    $merged = $mixtraders->merge($mixjobs);
    $plans = Plan::where('status',1)->orderby('id', 'asc')->paginate(10);
    $addonplans = PlansAddon::where('status',1)->orderby('id', 'asc')->paginate(10);
    return view('website.employer',compact('jobs','traders','mixjobs','mixtraders','merged','plans','addonplans','posts','company'));
    }

    public function show($id)
    {
        $post = Post::with('author')->findOrFail($id);
        $post->increment('views');

        return view('website.post-detail', compact('post'));
    }

    public function addView($id)
    {
       $post = Post::where('id', $id)->increment('views');
        return response()->json(['success' => true]);
    }



    public function react(Request $request, $postId)
    {
        $userId = Auth::id(); // make sure user is logged in

        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }
        

        $type = $request->type; // 1 = like, 2 = dislike

        // Check existing reaction
        $existing = PostLike::where('user_id', $userId)
            ->where('post_id', $postId)
            ->first();

        if ($existing) {
            if ($existing->type == $type) {
                // SAME CLICK AGAIN → REMOVE (toggle off)
                PostLike::where('id', $existing->id)->delete();
            } else {
                // SWITCH like ↔ dislike
                
                  PostLike:: where('id', $existing->id)
                    ->update([
                        'type' => $type,
                        'updated_at' => now()
                    ]);
            }
        } else {
            // NEW reaction
            PostLike::create([
                'user_id' => $userId,
                'post_id' => $postId,
                'type' => $type,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Return updated counts
        $likes = PostLike::where('post_id', $postId)
            ->where('type', 1)
            ->count();

        $dislikes = PostLike::where('post_id', $postId)
            ->where('type', 2)
            ->count();

        return response()->json([
            'likes' => $likes,
            'dislikes' => $dislikes
        ]);
    }

    public function about(){
        if(session('employer_mode')){
            $layout = 'website.layouts.master-employer';
        }else{
            $layout = 'website.layouts.master';
        }
        return view('website.about', compact('layout'));
    }    
    public function termsCondition(){
        if(session('employer_mode')){
            $layout = 'website.layouts.master-employer';
        }else{
            $layout = 'website.layouts.master';
        }
        return view('website.terms-condition', compact('layout'));
    }
    public function contact(){
        if(session('employer_mode')){
            $layout = 'website.layouts.master-employer';
        }else{
            $layout = 'website.layouts.master';
        }
        return view('website.contact', compact('layout'));
    }
     
     public function privacyPolicy(){
        if(session('employer_mode')){
            $layout = 'website.layouts.master-employer';
        }else{
            $layout = 'website.layouts.master';
        }
        return view('website.privacypolicy', compact('layout'));
     }
    public function services(){   
        if(session('employer_mode')){
            $layout = 'website.layouts.master-employer';
        }else{
            $layout = 'website.layouts.master';
        } 
        $plans = Plan::where('status',1)->orderby('id', 'asc')->paginate(10);
        $addonplans = PlansAddon::where('status',1)->orderby('id', 'asc')->paginate(10);
        return view('website.services',compact('plans','addonplans','layout'));
    }
    public function submitForm(Request $request){     
       $request->validate([
              'first_name' => 'required|regex:/^[a-zA-Z ]*$/',
              'last_name' => 'required|regex:/^[a-zA-Z ]*$/',
              'email' => 'required|email:rfc,dns',        
              'phone' => 'nullable',           
              'subject' => 'required',        
              'message' => 'required',        
          ],[
            'first_name.required'=>'Please enter first name',
            'last_name.required'=>'Please enter last name',
            'email.required'=>'Please enter email',
            'subject.required'=>'Please enter subject',
            'message.required'=>'Please enter message',
        ]);      
        $model = Setting::orderBy('id', 'DESC')->get();
        $email_array = preg_split ("/\,/", $model[0]->emails);
       if (!empty($email_array)) {
            $toRecipient = trim(array_shift($email_array));
            $bccRecipients = array_map('trim', $email_array);
            Mail::to($toRecipient)->bcc($bccRecipients)->send(new ContactForm($request));
       }
        return response()->json(['status'=>200,'message'=>'Email has been sent successfully.']);       
    }

    public function contactUs(){
        return view('mobile.contactus');
    }

    public function privacy(){
        return view('mobile.privacy');
    }
    public function aboutUs(){
        return view('mobile.aboutus');
    }
    public function terms(){
        return view('mobile.terms');
    }
    public function submitSearchForm(Request $request)
    {
        $validated = $request->validate([
            'search_input' => 'nullable|string|max:255',
            'search_location' => 'nullable|string|max:255',
            'search_type' => 'nullable|integer|in:1,2,3',
            'search_category' => 'nullable|integer',
            
        ]);

        $searchTerm = $validated['search_input'] ?? '';
        $searchLocation = $validated['search_location'] ?? '';
        $searchType = $validated['search_type'] ?? '';
        $searchCategory = $validated['search_category'] ?? '';
        // echo $searchCategory;
        /* if(!empty($searchTerm)){
            $searchType = $validated['search_type'] ?? 1;
        } */
        
        $results = null;
        $merged = [];
        // Get matching skill IDs
        $skillIds = $this->getMatchingSkillIds($searchTerm);

        switch ($searchType) {
            case 1: // Jobs only
                $results = $this->getJobsQuery($searchTerm,$searchLocation, $skillIds,$searchType, $searchCategory);
                if($results->count() == 0){
                    $merged = $this->getJobsQuery("","", [] ,$searchType, $searchCategory);
                }
                break;
                
            case 2: // Traders only
                $results = $this->getTradersQuery($searchTerm,$searchLocation, $skillIds,$searchType);
                if($results->count() == 0){
                    $merged = $this->getTradersQuery("", "",[] ,$searchType);
                }
                break;
                
            //case 3: // Combined results
            default:
            $searchType = 0;
                $results = $this->combinedSearch($searchTerm, $searchLocation, $skillIds,$searchType, $searchCategory);
                break;
        }
        
        if(!($results->count()) && empty($request['search_type']) ){
            $today  = date('Y-m-d 00:00:00');
            $searchType = '';
            $mixjobs =Job::with(['skillCategory', 'agency'])->whereRaw("home_seen_job = 1 and DATE(start_date) >= '$today' and status!=4  and status!=3")->orderByDesc('created_at');
            $mixtraders = User::where('user_type', 3)->whereNotNull('first_name')->orderByDesc('created_at');
            
            $merged = $this->combinedSearchResult($mixjobs,$mixtraders);
            //echo'<pre>';print_r($merged);die;
            $searchType = $request['search_type'];
        }/* else if(!count($results) && $request['search_type']){

        } */
        return view('website.search-results', [
            'results' => $results,
            'searchType' => $searchType,
            'searchTerm' => $searchTerm,
            'text' => $searchType,
            'merged'=>$merged
        ]);
    }

private function getMatchingSkillIds(string $searchTerm): array
{
    if (empty(trim($searchTerm))) return [];

    $terms = preg_split('/\s+/', $searchTerm, -1, PREG_SPLIT_NO_EMPTY);
    
    return SkillCategory::query()
        ->where(function ($query) use ($terms) {
            foreach ($terms as $term) {
                $query->orWhere('name', 'like', "%{$term}%");
            }
        })
        ->pluck('id')
        ->toArray();
}

private function combinedSearch(string $searchTerm, string $searchLocation, array $skillIds,int $searchType )
{
    // Get unpaginated query builders
    $jobsQuery = $this->getJobsQuery($searchTerm,$searchLocation, $skillIds,$searchType);
    $tradersQuery = $this->getTradersQuery($searchTerm,$searchLocation, $skillIds,$searchType);

    // Transform jobs
    $transformedJobs = collect($jobsQuery->get())->map(fn($job) => (object) [
        'type' => 'job',
        'id' => $job->id,
        'title' => $job->title,
        'name' => $job->skillCategory?->name ?? 'NA',
        'price_range' => '$'.$job->minimum_price.' - $'.$job->maximum_price,
        'location' => $job->location,
        'image' => $job->image,
        'badge' => '',
        'status' => $job->status,
        'agency' => $job->agency?->agency_name ?? 'NA',
        'created_at' => $job->created_at
    ]);

    // Transform traders
    $transformedTraders = collect($tradersQuery->get())->map(fn($trader) => (object) [
        'type' => 'trader',
        'id' => $trader->id,
        'title' => $trader->full_name,
        'name' => trim($trader->first_name . ' ' . $trader->last_name),
        'price_range' => null,
        'location' => $trader->address,
        'profile_picture' => $trader->profile_picture,
        'skill_category'=>$trader->skillCategory?$trader->skillCategory->name:'',
        'badge'=>$trader->badge?$trader->badge->name:'',
        'rating' => $trader->over_all_rating,
        'created_at' => $trader->created_at
    ]);

    // Combine and sort
    $combined = $transformedJobs->merge($transformedTraders)
        ->sortByDesc('created_at');

    // Create custom paginator
    $page = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 10;
    $sliced = $combined->slice(($page - 1) * $perPage, $perPage)->values();

    return new LengthAwarePaginator(
        $sliced,
        $combined->count(),
        $perPage,
        $page,
        [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => request()->query()
        ]
    );
}

public function combinedSearchResult($queryJobs,$queryTraders){
    $transformedJobs = collect($queryJobs->get())->map(fn($job) => (object) [
        'type' => 'job',
        'id' => $job->id,
        'title' => $job->title,
        'name' => $job->skillCategory?->name ?? 'NA',
        'price_range' => '$'.$job->minimum_price.' - $'.$job->maximum_price,
        'location' => $job->location,
        'image' => $job->image,
        'badge'=>'',
        'status' => $job->status,
        'agency' => $job->agency?->agency_name ?? 'NA',
        'created_at' => $job->created_at
    ]);

    // Transform traders
    $transformedTraders = collect($queryTraders->get())->map(fn($trader) => (object) [
        'type' => 'trader',
        'id' => $trader->id,
        'title' => $trader->full_name,
        'name' => trim($trader->first_name . ' ' . $trader->last_name),
        'price_range' => null,
        'location' => $trader->address,
        'profile_picture' => $trader->profile_picture,
        'skill_category'=>$trader->skillCategory?$trader->skillCategory->name:'',
        'badge'=>$trader->badge?$trader->badge->name:'',
        'rating' => $trader->over_all_rating,
        'created_at' => $trader->created_at
    ]);
     $combined = $transformedJobs->merge($transformedTraders)
        ->sortByDesc('created_at');
        $page = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 10;
    $sliced = $combined->slice(($page - 1) * $perPage, $perPage)->values();

    return new LengthAwarePaginator(
        $sliced,
        $combined->count(),
        $perPage,
        $page,
        [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => request()->query()
        ]
    );
}

private function getJobsQuery(string $searchTerm, string $searchLocation, array $skillIds, int $searchType, int $searchCategory)
{
    $today  = date('Y-m-d 00:00:00');
    $query = Job::with(['skillCategory', 'agency'])
        ->whereRaw("home_seen_job = 1 and DATE(start_date) >= '$today' and status!=4  and status!=3")
        ->when($searchCategory, fn($q) => $q->where('skill_category', $searchCategory))
        //->where('status', '>', 0)
        ->orderByDesc('created_at');

    $this->applySearchConditions($query, $searchTerm, $searchLocation, $skillIds,[
        'title'
    ],'location', 'skill_category');
    if($searchType){
        return $query->paginate(10);
    }else{
        return $query;
    }    
}

private function getTradersQuery(string $searchTerm, string $searchLocation, array $skillIds, int $searchType)
{
    $query = User::with('skillCategory')
        ->where('user_type', 3)
        ->whereNotNull('first_name')
        ->orderByDesc('created_at');

    $this->applySearchConditions($query, $searchTerm, $searchLocation, $skillIds, [
        'first_name', 'last_name', 'email'
    ], 'address','skill_category_id');
    if($searchType){
        return $query->paginate(10);
    }else{
        return $query;
    }
}



private function applySearchConditions($query, string $searchTerm, string $searchLocation, array $skillIds, array $fields, string $location, string $skillColumn)
{
    if (empty(trim($searchTerm)) && empty($skillIds) && empty(trim($searchLocation))) {
        return;
    }

    $query->where(function ($q) use ($searchTerm,$searchLocation, $skillIds, $fields, $location, $skillColumn) {
        $terms = preg_split('/\s+/', $searchTerm, -1, PREG_SPLIT_NO_EMPTY);
        
        if (!empty($terms)) {
            foreach ($terms as $term) {
                foreach ($fields as $field) {
                    $q->orWhere($field, 'like', "%{$term}%");
                }
            }
        }
        $locationterms = preg_split('/\s+/', $searchLocation, -1, PREG_SPLIT_NO_EMPTY);
        if (!empty($locationterms)) {
            foreach ($locationterms as $locationterm) {
                    $q->orWhere($location, 'like', "%{$locationterm}%");
            }
        }
        if (!empty($skillIds)) {
            $q->orWhereIn($skillColumn, $skillIds);
        }
    });
}
    public function submitSearchForm2(Request $request)
{
        
        $searchTerm     = $request->input('search_input');
        $searchType     = $request->input('search_type');    
        $traderResults  = null;
        $jobResults     = null;    
	    $searchTerms    = explode(" ", $searchTerm);
        $query          = SkillCategory::query();
        foreach ($searchTerms as $term) {
            $query->orWhere('name', 'like', '%' . $term . '%');
        }
        $skilIds = $query->pluck('id')->toArray();
        if(empty($searchTerm) && empty($searchType)){
            $searchType = 1;
        }
        $today  = date('Y-m-d 00:00:00');
        switch ($searchType) {
            case 1:
                $jobResults = Job::query()
                    //->where('status', '>', 0)
                    ->whereRaw("DATE(start_date) >= '$today' and is_hired=1 and status!=4  and status!=3")
                    ->where(function ($query) use ($searchTerm,$skilIds) {
                        $query->where('title', 'like', '%' . $searchTerm . '%')
                              ->orWhere('location', 'like', '%' . $searchTerm . '%');
                              $query->when(count($skilIds)>0, function ($q) use ($skilIds) {
                                $q->orWhereIn('skill_category', $skilIds);
                            });
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);
                break;
            case 2:
                $traderResults = User::query()
                    ->where('user_type', 3)
                    ->where('first_name', '!=', '')
                    ->where(function ($query) use ($searchTerm,$skilIds) {
                        $query->where('first_name', 'like', '%' . $searchTerm . '%')
                              ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                              ->orWhere('email', 'like', '%' . $searchTerm . '%')
                              ->orWhere('address', 'like', '%' . $searchTerm . '%');
                              $query->when(count($skilIds)>0, function ($q) use ($skilIds) {
                                $q->orWhereIn('skill_category_id', $skilIds);
                            });
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);
                break;

            default:
            $mixdata = 1;
                 $mixjobResults = Job::query()
                   // ->where('status', '>', 0)
                    ->whereRaw("DATE(start_date) >= '$today' and is_hired=1 and status!=4  and status!=3")
                    ->where(function ($query) use ($searchTerm,$skilIds) {
                        $query->where('title', 'like', '%' . $searchTerm . '%')
                              ->orWhere('location', 'like', '%' . $searchTerm . '%');
                              $query->when(count($skilIds)>0, function ($q) use ($skilIds) {
                                $q->orWhereIn('skill_category', $skilIds);
                            });
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);
                    $mixtraderResults = User::query()
                    ->where('user_type', 3)
                    ->where('first_name', '!=', '')
                    ->where(function ($query) use ($searchTerm,$skilIds) {
                        $query->where('first_name', 'like', '%' . $searchTerm . '%')
                              ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                              ->orWhere('email', 'like', '%' . $searchTerm . '%')
                              ->orWhere('address', 'like', '%' . $searchTerm . '%')
                              ->where('over_all_rating','>=',4.00)->orderBy('over_all_rating', 'desc');
                              $query->when(count($skilIds)>0, function ($q) use ($skilIds) {
                                $q->orWhereIn('skill_category_id', $skilIds);
                            });
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);
                break;
        }
        return view('website.search-results', [
            'traders' => $traderResults,
            'jobs' => $jobResults,
            'text' => $searchType,
            'mixdata'=>$mixdata ?? 0
        ]);
}

    


    public function showDetails($id,$text){
        $recent_jobs = $job_result = $trader_results = '';
        $today  = date('Y-m-d 00:00:00');
        if($text == 1){
             $job_result = Job::find($id);
             $recent_jobs = Job::whereRaw("(status > 0) and (skill_category = $job_result->skill_category)")
             ->whereRaw("DATE(start_date) >= '$today' and is_hired=1 and status!=4  and status!=3")
             ->limit(4)->get();
        }elseif($text == 2){
            $trader_results = User::with(['posts' => function ($query) {
                $query->with('gallery')->where('status', 1)->latest()->take(6);
            }])->find($id);
            $recent_jobs = User::whereRaw("(id!=$trader_results->id) and (skill_category_id = $trader_results->skill_category_id)")->limit(4)->get();
        }
        return view('website.search-detail',[
            'job'=>$job_result,
            'trader'=>$trader_results,
            "recent_jobs"=>$recent_jobs,
            'text'=>$text
        ]);
    }

    public function showTraderPost(string $id)
    {
        $model  = Post::find($id);
        return view('website.search-detail-view')->with(['model'=>$model]);
    }


    public function showBySkill($skillId = null)
    {
        // Get all tasks
        $allTasks = DB::table('tasks')
            ->where('status', 1)
            ->get();

        // Get all skills
        $allSkills = DB::table('skill_categories')->get();

        // Default values
        $skill = null;
        $taskByCategory = collect();

        // If skill id exists
        if ($skillId) {

            $skill = DB::table('skill_categories')->find($skillId);

            // Check skill exists
            if (!$skill) {
                abort(404, 'Skill not found');
            }

            // Category tasks
            $taskByCategory = DB::table('tasks')
                ->where('skill_category', $skillId)
                ->where('status', 1)
                ->get();
        }

        // $locations = DB::table('tasks')
        // ->where('status', 1)
        // ->whereNotNull('location')
        // ->where('location', '!=', '')
        // ->select('location')
        // ->distinct()
        // ->orderBy('location')
        // ->pluck('location');
        // dd($locations);

        $locations = DB::table('tasks')
        ->where('status', 1)
        ->whereNotNull('location')
        ->pluck('location')
        ->map(function ($location) {

        $parts = array_map('trim', explode(',', $location));

        if(count($parts) >= 3) {

            $city  = $parts[count($parts)-3];
            $state = $parts[count($parts)-2];

            return $city . ', ' . $state;
        }

        return $location;
    })
    ->unique()
    ->values();

        return view(
            'website.jobs-by-categories',
            compact(
                'taskByCategory',
                'skill',
                'allSkills',
                'allTasks',
                'locations'
            )
        );
    }


    public function showAllJobs()
    {

        $tasks = DB::table('tasks')
            ->where('status', '=', 1)
            ->get();

        return view('website.all-jobs', compact('tasks'));
    }

}
?>
