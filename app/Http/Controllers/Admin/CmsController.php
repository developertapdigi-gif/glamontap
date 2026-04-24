<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cms;

class CmsController extends Controller
{
    public function index(Request $request){       
        return view('admin.cms.index');
    }
    public function create(){        
        $status = Cms::STATUS;        
        return view('admin.cms.create')->with([                  
            'status'=>$status
        ]);
    }
    public function store(Request $request){
        $validator =  $request->validate([
            'page_title' => 'required|unique:cms',            
            'page_content' => 'required',           
            'url_key' => 'required |alpha_dash| unique:cms',
            'status' => 'required', 
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'nullable'
        ]);         
        
        $input = $request->all();   
        $input['updated_by'] = Auth::id();
        $input['created_by'] = Auth::id();
        $model = Cms::create($input);       
        return redirect('cms')->with('success', 'Page has been created successfully!');
    }

    public function edit($id){
        $cms =  Cms::find($id);   
        $status = Cms::STATUS;
        return view('admin.cms.update',[
            'model'=>$cms,
            'status'=>$status
        ]);
    }
    public function update(Request $request,$id)
    {
        $cms =  Cms::find($id);
        $validator =  $request->validate([
            'page_title' => 'required|unique:cms,page_title,'.$cms->id,        
            'page_content' => 'required',
            'page_content' => 'required',
            'url_key' => 'required |alpha_dash| unique:cms,url_key,'.$cms->id,
            'status' => 'required',           
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'nullable',                   
        ]);       
        $input = $request->all();       
        $input['updated_by'] = Auth::id();       
        $cms->update($input);   
         return redirect('cms')->with('success', 'Page has been updated successfully!');
       
    }
    public function destroy($id)
    {
        $cms = Cms::find($id)->delete();
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
        $condition ='id>0';
        if($searchValue){
             $condition = " (page_title like '%$searchValue%')";
        }
        $totalRecords = Cms::select('count(*) as allcount')
            ->whereRaw($condition)
            ->count();
        $totalRecordswithFilter = Cms::select('count(*) as allcount')
                    ->whereRaw($condition)
                    ->count();
        $collection = Cms::orderBy($columnName,$columnSortOrder)
            ->whereRaw($condition)
            ->select('cms.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        foreach ($collection as $key => $value) {
            $buttons = '';            
            if ($user->can('admin-cms-update')) {
                $buttons .= ' <a  href="' . route("cms.edit", $value->id) . '"><i class="skill-table-action bi-pencil-square "></i></a>';
            }
            if ($user->can('admin-cms-delete')) {
                $buttons .= ' <button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="deleteRecord(' . $value->id . ')"><i class="skill-table-action bi-trash3-fill"></i>';
            }
            $data_arr[] = array(
              "id" => $value->id,
              "page_title" => $value->page_title,
              "status" => Cms::STATUS[$value->status],
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
