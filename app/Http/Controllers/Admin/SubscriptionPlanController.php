<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionPlans as Plan;
use App\Models\{User,AgencySubscription};
use Illuminate\Http\Request;
use Carbon\Carbon;
class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $condition = 'id>0';
        if(!empty($request->query('query'))){
            $query = $request->query('query');
            $condition = " (name like '%$query%')";
        }
        
        $plans = Plan::whereRaw($condition)->orderby('id', 'desc')->paginate(10)->withQueryString();
        return view('admin.subscription-plans.list_n_grid',compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = Plan::STATUS; 
        return view('admin.subscription-plans.create',['status'=>$status,'classnames' =>Plan::CLASSNAME]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'monthly_price' => 'required',
            'yearly_price' => 'required',
            'job_limit' => 'required',
            'tradesman_limit' => 'required',
            'description'=>'required',
            'status'=>'required',
            'class_name'=>'required',
            'stripe_product_id'=>'required',
            'stripe_monthly_price_id'=>'required',
            'stripe_yearly_price_id'=>'required',
        ]);     
        $input =    $request->all(); 
        $input['duration'] = 1;
        Plan::create($input);
        return redirect('plans')->with('success', 'Subscription plan has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = Plan::find($id);
        return view('admin.subscription-plans.edit',
        [
            'model'=>$model,
            'status' =>Plan::STATUS,
            'classnames' =>Plan::CLASSNAME
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model  = Plan::find($id);
        $validator =  $request->validate([
            'name' => 'required|unique:subscription_plans,name,'.$model->id,
            'monthly_price' => 'required',
            'yearly_price' => 'required',
            'job_limit' => 'required',
            'tradesman_limit' => 'required',
            'description'=>'required',
            'status'=>'required',
            'class_name'=>'required',
            'stripe_product_id'=>'required',
            'stripe_monthly_price_id'=>'required',
            'stripe_yearly_price_id'=>'required',
        ]);
        $input     = $request->all();
        $model->update($input);
        return redirect('plans')->with('success', 'Subscription plan has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model  = Plan::find($id);       
        if ($model->delete()) {           
            return response()->json(['data' => true,'Plan deleted successfully']);
        } else {
            return response()->json(['data' => false,'message'=>'Unable to delete this plan, As there is quotation']);
        }
    }
    public function activateSubscription(Request $request){
        $model = Plan::find($request->id);
        if($model->status == 0)
            $model->status = 1;
        else
            $model->status = 0;
        
        if ($model->save()) {           
            return response()->json(['status' => true,'Status has been updated successfully!']);
        } else {
            return response()->json(['status' => false,'message'=>'Unable to Change status']);
        }
        
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
        $condition = 'id>0';
        if($searchValue){
             $condition = " (name like '%$searchValue%')";
        }
        $totalRecords = Plan::select('count(*) as allcount')->count();

       $totalRecordswithFilter = Plan::select('count(*) as allcount')->whereRaw($condition)->count();

        $collection = Plan::orderBy($columnName,$columnSortOrder)
            ->whereRaw($condition)
            ->select('subscription_plans.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        foreach ($collection as $key => $value) {
            $buttons = '';          
            if ($user->can('admin-plans-update')) {
                $buttons .= ' <a  href="' . route("plans.edit", $value->id) . '"><i class="skill-table-action bi-pencil-square "></i></a>';
            }
            if ($user->can('admin-plans-delete')) {
                $buttons .= ' <button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="deleteRecord(' . $value->id . ')"><i class="skill-table-action bi-trash3-fill"></i>';
            }
            $data_arr[] = array(
              "id" => $value->id,
              "name" => $value->name,
              "monthly_price" => $value->monthly_price,
              "status" => Plan::STATUS[$value->status],
              "created_at" =>Date(config('app.date_format'),strtotime($value->created_at)),
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
    public function getSubscribers(){
        $agencies = User::where('user_type',User::ROLE['agency'])->where('status',1)->whereNotNull('agency_name')->get();
        $plans    = Plan::where('status',1)->get();
        return view('admin.subscription-plans.subscribers',compact('agencies','plans'));
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
        
        if($request->expiring==1){ // All
            $condition .= " and plan_id >0";          
        }else if($request->expiring==2){ // Expiring this week
            $startOfWeek   = $now->startOfWeek()->format('Y-m-d 00:00:00');
            $endOfWeek     = $now->endOfWeek()->format('Y-m-d 23:59:59');
            $condition .= " and (end_date >='$startOfWeek' and end_date <= '$endOfWeek')";          
        }else if($request->expiring==3){ //Expiring this Month
            $startOfMonth   = $now->startOfMonth()->format('Y-m-d 00:00:00');
            $endOfMonth     = $now->endOfMonth()->format('Y-m-d 00:00:00');
            $condition .= " and end_date BETWEEN '$startOfMonth' and '$endOfMonth'";  
        }else if($request->expiring==4){ // Expired
            $condition .= " and end_date<'$dateNow'";       
        }else if($request->expiring==5){ // subscribers this month
            $startOfMonth   = $now->startOfMonth()->format('Y-m-d 00:00:00');
            $endOfMonth     = $now->endOfMonth()->format('Y-m-d 00:00:00');
            $condition .= " and plan_id!=4 and start_date BETWEEN '$startOfMonth' and '$endOfMonth'";       
        } 
        if($request->plan_id!='-1' && $request->plan_id!=''){
            $condition .= " and plan_id=".$request->plan_id; 
        }  
        if($request->agency_id!='-1' && $request->agency_id!=''){
            $condition .= " and agency_id=".$request->agency_id; 
        }
        if($request->to && $request->from){          
            $condition .= " and DATE(start_date)>='{$request->from}' and DATE(end_date) <= '{$request->to}'";
        }else if( $request->from && empty($request->to) ){            
            $condition .= " and DATE(start_date) >= '{$request->from}'";
        }else if($request->to && empty($request->from)){            
            $condition .= " and DATE(end_date) <= '{$request->to}'";  
        }         

        $totalRecords = AgencySubscription::select('count(*) as allcount')->count();
        $totalRecordswithFilter = AgencySubscription::select('count(*) as allcount')->whereRaw($condition)->count();

        $collection = AgencySubscription::orderBy($columnName,$columnSortOrder)
            ->whereRaw($condition)
            ->select('agency_subscriptions.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        foreach ($collection as $key => $value) {           
            $data_arr[] = array(
              "id" => $value->id,
              "plan_id" => $value->plan->name,
              "subscription_type" =>($value->plan_id == 4)?"14 Days":AgencySubscription::TYPE[$value->subscription_type],
              "agency_id" =>ucfirst($value->agency->agency_name),
              "tradesman_limit" => $value->tradesman_limit,            
              "job_limit" => $value->job_limit,            
              "start_date" =>Date(config('app.date_format'),strtotime($value->start_date)),
              "end_date" =>Date(config('app.date_format'),strtotime($value->end_date))
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
