<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\Confirmation;
class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('frontend.agents.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = User::STATUS;;
        return view('frontend.agents.create',['status'=>$status]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'user_type' => 'nullable'
        ]);
        $input              = $request->all();
        $input['user_type'] = User::ROLE['trader'];
        $input['status']    = 1;
        $input['password']  = Hash::make('apr_800#');
        $input['agency_id'] = Auth::user()->id;
        $model = User::create($input);
        $model->assignRole('trader');
        $token =Str::random(40);
        DB::table('password_reset_tokens')->insert([
            'email' => $model->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        Mail::to($model->email)->send(new Confirmation($model->first_name,$token));
        return redirect('agent')->with('success', 'Agent has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = User::find($id);
        return view('frontend.agents.show')->with(['model'=>$model]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = User::find($id);
        return view('frontend.agents.update',
            [
            'model'=>$model
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model  = User::find($id);
        $validator =  $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$model->id,
            'mobile' => 'required|unique:users,mobile,'.$model->id,
        ]);
        $input       = $request->all();
        $model->update($input);
        return redirect('agent')->with('success', 'Agent has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->user_type == User::ROLE['agency']){
            $model = User::find($id);
                if($model->agency_id == Auth::user()->id){
                    DB::table('password_reset_tokens')->where('email',$model->email)->delete();
                    $model->delete();
                }
        }
        return response()->json(['data' => true]);
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
        $userType = User::ROLE['trader'];
        $condition = "(user_type=$userType and agency_id = $user->id)";
        if($searchValue){
             $condition .= " and (first_name like '%$searchValue%' or email like '%$searchValue%')";
        }
        $totalRecords = User::select('count(*) as allcount')
            ->whereRaw($condition)
            ->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')
                    ->whereRaw($condition)
                    ->count();
        $collection = User::orderBy($columnName,$columnSortOrder)
           ->whereRaw($condition)
           ->select('users.*')
           ->skip($start)
           ->take($rowperpage)
           ->get();

        foreach ($collection as $key => $value) {
            $buttons = '';
            if ($user) {
                $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("agent.show", $value->id) . '"><i class="fas fa-eye"></i></a>';
            }
            if ($user) {
                $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("agent.edit", $value->id) . '"><i class="fas fa-edit"></i></a>';
            }
            if ($user) {
                $buttons .= ' <button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="deleteRecord(' . $value->id . ')"><i class="fas fa-trash"></i>';
            }
            $agency = 'N/A';
            if($value->agency){
                $agency = $value->agency->first_name.' '.$value->agency->last_name;
            }
            $data_arr[] = array(
              "id" => $value->id,
              "first_name" => $value->first_name.' '.$value->last_name,
              "email" => $value->email,
              "mobile"=> $value->mobile,
              "agency_id" => $agency,
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
}
