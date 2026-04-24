<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Artisan;

class SettingController extends Controller
{
    public function index(){
            return view('admin.setting.index');
    }
    public function create(){
       return view('admin.setting.create');
    }
    public function store (Request $request){       
        $request->validate([
            'site_logo' => ['required','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'favicon' => ['required','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'site_name' => 'required',
            'emails'=>'required',
            'address' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'weekly_reminder'=>'nullable',
            'monthly_reminder'=>'nullable',
            'fb_link'=>'nullable',
            'twitter_link'=>'nullable',
            'linkedIn_link'=>'nullable'
        ]);
        $input = $request->all();
        if($request->hasfile('site_logo'))
        {
            $fileName = time().'.'.$request->site_logo->extension();
            $request->site_logo->move(public_path('uploads/logo'), $fileName);
            $input['site_logo'] = 'uploads/logo/'.$fileName;
        }
        if($request->hasfile('favicon'))
        {
            $fileName = time().'.'.$request->favicon->extension();
            $request->favicon->move(public_path('uploads/favicon'), $fileName);
            $input['favicon'] = 'uploads/logo/'.$fileName;
        }
        $model = Setting::create($input);
        return redirect()->route('setting.edit',[$model->id])->with('success', 'Setting has been updated successfully!');
    }

    public function edit($id){
        $model = Setting::find($id);
        return view('admin.setting.update',
            [
            'model'=>$model,
            ]);
    }
    public function update(Request $request, string $id)
    {
        $model  = Setting::find($id);
        $request->validate([
            'site_logo' => ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'favicon' => ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'site_name' => 'required',
            'emails'=>'required',
            'address' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'weekly_reminder'=>'nullable',
            'monthly_reminder'=>'nullable',
            'fb_link'=>'nullable',
            'twitter_link'=>'nullable',
            'linkedIn_link'=>'nullable'
        ]);       
        $input       = $request->all();
        if($request->hasfile('site_logo'))
        {

            $fileName = time().'.'.$request->site_logo->extension();
            $request->site_logo->move(public_path('uploads/logo'), $fileName);
            $input['site_logo'] = 'uploads/logo/'.$fileName;
        }else{
            $input['site_logo'] = $model->site_logo;
        }
        if($request->hasfile('favicon'))
        {

            $fileName = time().'.'.$request->favicon->extension();
            $request->favicon->move(public_path('uploads/favicon'), $fileName);
            $input['favicon'] = 'uploads/favicon/'.$fileName;
        }else{
            $input['favicon'] = $model->favicon;
        }
        if(empty($request->survey_days)){
            $input['survey_status']=0;
        }
        if(empty($request->survey_days)){
            $input['survey_status']=0;
        }
        if(empty($request->survey_days_tradies)){
            $input['survey_status_tradies']=0;
        }
        //echo'<pre>';print_r($input);die;
        $model->update($input);
        return redirect()->route('setting.edit',[$model->id])->with('success', 'Setting has been updated successfully!');
    }

    public function fetchData(Request $request){
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

        $totalRecords = Setting::select('count(*) as allcount')         
            ->count();
        $totalRecordswithFilter = Setting::select('count(*) as allcount')                  
                    ->count();
        $collection = Setting::orderBy($columnName,$columnSortOrder)     
           ->select('settings.*')
           ->skip($start)
           ->take($rowperpage)
           ->get();
        foreach ($collection as $key => $value) {
            
            $buttons = '';       
            $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("setting.edit", $value->id) . '"><i class="skill-table-action fas fa-edit"></i></a>';
            
            $data_arr[] = array(
              "site_name" => $value->site_name,
              "address" => $value->address,
              "emails" => $value->emails,
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

    public function cacheRemove(){
        Artisan::call('optimize:clear');
        return redirect()->back()->with('success', 'Your cache has been removed successful!');
    }

    public function mailEdit($id){
        $model = Setting::find($id);
        return view('admin.setting.mail-edit',
            [
            'model'=>$model,
            ]);
    }

    public function mailEditPost(Request $request, string $id){
        $model  = Setting::find($id);
        $request->validate([
            'smtp_host' => 'required',
            'smtp_port'=>'required|numeric',
            'smtp_username' => 'required|email',
            'smtp_password' => 'required',
            'smtp_encryption' => 'required',
            'smtp_from_address' => 'required|email',
        ]);
        $input       = $request->all();
        $model->update($input);
        return redirect()->route('setting.mailedit',[$model->id])->with('success', 'Mail Setting has been updated successfully!');
    }
}
  