<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserFeedbackSurvey;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FeedbackSurveysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $text = [1=>'All',2=>'Companies',3=>'Tradies'];
        $skill_categories = $feedbacksurvey = UserFeedbackSurvey::orderby('id', 'desc')->paginate(10);
        return view('admin.feedback-survey.index',compact('skill_categories','text'));
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $text = [1=>'All',2=>'Companies',3=>'Tradies'];
        $searchValue = $search_arr['value']; // Search value
        $condition ='';
        $userIds = [];
        $feedbackUserIds = UserFeedbackSurvey::distinct()->pluck('user_id')->toArray();

        $userQuery = User::whereIn('id', $feedbackUserIds);

        if ($request->job_status == $text[2]) {
            $userQuery->where('user_type', '2');
        } elseif ($request->job_status == $text[3]) {
            $userQuery->where('user_type', '3');
        }

        if (!empty($searchValue)) {
            $userQuery->where('first_name', 'like', "%{$searchValue}%");
        }
        $userIds = $userQuery->pluck('id')->toArray();
        //print_r($userIds);die;

        if (!empty($userIds)) {
            $condition = "user_id IN (" . implode(',', $userIds) . ")";
        } else {
            // No users match job status + search + feedback — return empty result
            $response = [
                "draw" => intval($draw),
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => []
            ];
            echo json_encode($response);
            exit;
        }
        if(!empty($condition)){
            $totalRecords = UserFeedbackSurvey::select('count(*) as allcount')
            ->whereRaw($condition)
            ->count();
        }else{
            $totalRecords = UserFeedbackSurvey::select('count(*) as allcount')
            ->count();
        }
        if(!empty($condition)){
            $totalRecordswithFilter = UserFeedbackSurvey::select('count(*) as allcount')
                    ->whereRaw($condition)
                    ->count();
        }else{
            $totalRecordswithFilter = UserFeedbackSurvey::select('count(*) as allcount')
                    ->count();
        }
        if(!empty($condition)){
            $collection = UserFeedbackSurvey::orderBy($columnName,$columnSortOrder)
            ->whereRaw($condition)
            ->select('user_feedback_surveys.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        }else{
            $collection = UserFeedbackSurvey::orderBy($columnName,$columnSortOrder)
            ->select('user_feedback_surveys.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        }
        foreach ($collection as $key => $value) {
            $buttons = '';    
            $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" data-bs-toggle="modal" data-bs-target="#filterModal" data-modelId="'.$value->id.'" id = "for_feedback"><i class="skill-table-action bi bi-eye-fill"></i></a>';          
            $rating_value = $value->rating ?? 0;
            $rating = '<input class="rating"  max="5"  step="0.05" style="--fill:orange;--value:'.$rating_value.'" type="range" value="'.$rating_value.'">';
            $data_arr[] = array(
              "id" => $value->id,
              "name" => $value->user->first_name,
              "rating" => $rating,
              "message" => mb_strimwidth($value->comment,0,30,'...'),
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

    public function getFeedback($id){
        if(!request()->ajax()){
            return redirect()->route('feedback-survey.index');
        }
        $feedback = UserFeedbackSurvey::where('user_id', $id)->orWhere('id', $id)->first();
        if(!$feedback){
            return response()->json(['status' => 'empty', 'data' => null]);
        }
        return response()->json([
            'status' => 'success',
            'data' => [
                'rating'  => $feedback->rating,
                'comment' => $feedback->comment,
            ]
        ]);
    }

}
