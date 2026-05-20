<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\SkillCategory;
use App\Models\User;

class SkillCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {  
        $condition = 'id>0';
        if(!empty($request->query('query'))){
            $query = $request->query('query');
            $condition .= " and (name title '%$query%' or location like '%$query%') ";
        }
       
        $skill_categories = SkillCategory::whereRaw($condition)->orderby('id', 'desc')->paginate(10)->withQueryString();       
        $skillcategories =SkillCategory::getAllSkillCategory();
        return view('admin.skill-categories.list_n_grid',compact('skill_categories','skillcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = SkillCategory::getStatus(); 
        return view('admin.skill-categories.create',['status'=>$status]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable',
        ]);

        $input = $request->except(['_token', '_method']);

        if ($request->hasFile('image')) {
            $fileName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/skill-categories'), $fileName);
            $input['image'] = 'uploads/skill-categories/' . $fileName;
        }

        $model = SkillCategory::create($input);

        return redirect('skill-categories')->with('success', 'Skill Category has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = SkillCategory::where('id',$id)->get();
        return view('admin.skill-categories.show')->with(['model'=>$model[0]]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = SkillCategory::find($id);
        return view('admin.skill-categories.update',
            [
            'model'=>$model,
            'status' => $model->getStatus()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model  = SkillCategory::find($id);

        $request->validate([
            'name' => 'required|unique:skill_categories,name,'.$model->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $input = $request->except(['_token', '_method']);

        if ($request->hasFile('image')) {
            if ($model->image && file_exists(public_path($model->image))) {
                unlink(public_path($model->image));
            }
            $fileName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/skill-categories'), $fileName);
            $input['image'] = 'uploads/skill-categories/' . $fileName;
        } else {
            unset($input['image']);
        }

        $model->update($input);
        return redirect('skill-categories')->with('success', 'Skill Category has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->user_type == User::ROLE['admin'])
        $model = SkillCategory::find($id)->delete();
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
        $condition ='';
        if($searchValue){
             $condition = " (name like '%$searchValue%')";
        }
        if(!empty($condition)){
            $totalRecords = SkillCategory::select('count(*) as allcount')
            ->whereRaw($condition)
            ->count();
        }else{
            $totalRecords = SkillCategory::select('count(*) as allcount')
            ->count();
        }
        if(!empty($condition)){
            $totalRecordswithFilter = SkillCategory::select('count(*) as allcount')
                    ->whereRaw($condition)
                    ->count();
        }else{
            $totalRecordswithFilter = SkillCategory::select('count(*) as allcount')
                    ->count();
        }
        if(!empty($condition)){
            $collection = SkillCategory::orderBy($columnName,$columnSortOrder)
            ->whereRaw($condition)
            ->select('skill_categories.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        }else{
            $collection = SkillCategory::orderBy($columnName,$columnSortOrder)
            ->select('skill_categories.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        }
        foreach ($collection as $key => $value) {
            $buttons = '';            
            if ($user->can('admin-skillCategories-update')) {
                $buttons .= ' <a  href="' . route("skill-categories.edit", $value->id) . '"><i class="skill-table-action bi-pencil-square "></i></a>';
            }
            if ($user->can('admin-skillCategories-delete')) {
                if (empty($value->JobSkillCategory)) {
                    $buttons .= ' <button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="deleteRecord(' . $value->id . ')"><i class="skill-table-action bi-trash3-fill"></i></button>';
                }
            }
            $imageUrl = null;
            if (!empty($value->image) && file_exists(public_path($value->image))) {
                $imageUrl = asset($value->image);
            }
            $imageHtml = $imageUrl ? '<img src="' . $imageUrl . '" alt="' . e($value->name) . '" style="height:50px; width:50px; object-fit:cover; border-radius:6px;" />' : '<span class="text-muted">No image</span>';
            $statusText = ($value->status == 1) ? 'Activate' : 'Deactivate';
            $data_arr[] = array(
              "id" => $value->id,
              "image" => $imageHtml,
              "name" => $value->name,
              "status" => $statusText,
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
    public function changeStatus($id){
        $model = SkillCategory::find($id);
        if($model){
            if($model->status == 1)
                $model->status = 0;
            else
            $model->status = 1;
        $model->save();
        }
        return redirect('skill-categories?mode=grid');
    }
}
