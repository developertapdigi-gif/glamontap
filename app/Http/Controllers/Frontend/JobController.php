<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\SkillCategory;
use App\Models\User;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.job.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = Job::STATUS;
        $categories =SkillCategory::getAllSkillCategory();
        $agencies = User::getAgencyList();
        $experience_range = Job::EXPERIENCE_RANGE;
        return view('frontend.job.create',['experience_range'=>$experience_range,'status'=>$status,'categories'=>$categories,'agencies'=>$agencies]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'=> ['required','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title'=>'required',
            'skill_category'=> 'required',
            'experiance_range'=> 'required',
            'number_of_employees'=> 'required',
            'location'=> 'required',
            'start_date'=> 'required|date',
            'end_date'=> 'required|date',
            'minimum_price'=> 'required',
            'maximum_price'=> 'required'
        ],
        );
        $input = $request->all();
        $input['start_date'] = date("Y-m-d H:i:s", strtotime($request->start_date));
        $input['end_date'] = date("Y-m-d H:i:s", strtotime($request->end_date));
        $input['agency_id'] =Auth::user()->id;
        if($request->hasfile('image'))
        {
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/jobs'), $fileName);
            $input['image'] = 'uploads/jobs/'.$fileName;
        }

    //echo'<pre>';print_r($input);die;
        $model = Job::create($input);
        return redirect('/job')->with('success', 'Job has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = Job::find($id);
        return view('frontend.job.show')->with(['model'=>$model]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = Job::find($id);
        $status = Job::STATUS;
        $experience_range = Job::EXPERIENCE_RANGE;
        $categories =SkillCategory::getAllSkillCategory();
        $agencies = User::getAgencyList();
        return view('frontend.job.update',
            [
            'model'=>$model,
            'experience_range'=>$experience_range,
            'status'=>$status,
            'categories'=>$categories,
            'agencies'=>$agencies
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model  = Job::find($id);
        $request->validate([
            //'image'=> ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title'=>'required',
            'skill_category'=> 'required',
            'experiance_range'=> 'required',
            'number_of_employees'=> 'required',
            'location'=> 'required',
            'start_date'=> 'required|date',
            'end_date'=> 'required|date',
            'minimum_price'=> 'required',
            'maximum_price'=> 'required'
        ],
        [
            'start_date.after' => 'Please select current date or greater than current date',
            'end_date.after' => 'Please select greater than Start Date',
        ]);
        $input       = $request->all();
        if($request->hasfile('image'))
        {
            $request->validate([
                'image'=> ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ]);
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/jobs'), $fileName);
            $input['image'] = 'uploads/jobs/'.$fileName;
        }else{
            $input['image'] = $model->image;
        }
        $model->update($input);
        return redirect('job')->with('success', 'Job has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       //print_r(User::ROLE['agency']);die;
        if(Auth::user()->user_type == User::ROLE['agency']){
            $model = Job::find($id);
                if($model->agency_id == Auth::user()->id){
                    $model->delete();
                }
                return response()->json(['data' => true]);
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
        $userType = User::ROLE['agency'];
        $condition = "agency_id = $user->id";

        $totalRecords = Job::select('count(*) as allcount')
            ->whereRaw($condition)
            ->count();
        $totalRecordswithFilter = Job::select('count(*) as allcount')
                    ->whereRaw($condition)
                    ->count();
        $collection = Job::orderBy($columnName,$columnSortOrder)
           ->whereRaw($condition)
           ->select('tasks.*')
           ->skip($start)
           ->take($rowperpage)
           ->get();

        foreach ($collection as $key => $value) {
            $buttons = '';
            $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href=""><i class="skill-table-action bi bi-geo-alt-fill"></i></a>';
              $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("job.show", $value->id) . '"><i class="skill-table-action fas fa-eye"></i></a>';
              $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("job.edit", $value->id) . '"><i class="skill-table-action fas fa-edit"></i></a>';
              $buttons .= ' <button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="deleteRecord(' . $value->id . ')"><i class="skill-table-action fas fa-trash"></i>';
            $data_arr[] = array(
              "id" => $value->title,
              "start_date" => $value->start_date,
              "end_date" => $value->end_date,
              "location"=> $value->location,
              "number_of_employees"=> $value->number_of_employees,
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
}
