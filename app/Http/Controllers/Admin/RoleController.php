<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Artisan;

class RoleController extends Controller
{
    private $page_heading;
    public function __construct()
    {
        $this->page_heading =  'Role';        
    }
    public function index(Request $request){
        $page_heading = $this->page_heading .' Management';   
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('admin.roles.index', compact('roles', 'page_heading'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('admin-role-create')) {
          #  return redirect()->route('dashboard');
        }
        $page_heading = $this->page_heading;   
        $permission = Permission::whereRaw('Lower(name) LIKE ? ', "admin-%")->get();
        $permissionLists = [];
        foreach($permission as $row){
                $list = explode('-', $row->name);            
                $pr_group = trim($list[1]);
                $pr_permission = trim($list[2]);
                $permissionLists[$pr_group][$pr_permission] = $row->id;
        }
        return view('admin.roles.create', compact('permission','page_heading','permissionLists'));
    }
    public function store(Request $request){        
        $request->validate([
           'name' => 'required|unique:roles',
           'prev' => 'required'
        ]);

        $current_user_id = Auth::user()->id;
        $role = Role::create(['name'=>$request->name]);
        $id = $role->id;
        if(!empty($request->input('prev'))){
            foreach($request->input('prev') as $prek=>$prev){
                DB::table('role_has_permissions')->insert([ 'permission_id' => $prev, 'role_id' => $id ]);
            }
        }
        Artisan::call('cache:clear');
        return redirect()->route('role.index')->with('success','Role created successfully.');
    }
    public function edit($id)
    {  
        $model = Role::find($id);
        $page_heading = __('Update Property Type - '.$model->name);
        $permission = Permission::whereRaw('Lower(name) LIKE ? ', "admin-%")->get();
        $permissionLists = [];
        foreach($permission as $row){
                $list = explode('-', $row->name);            
                $pr_group = trim($list[1]);
                $pr_permission = trim($list[2]);
                $permissionLists[$pr_group][$pr_permission] = $row->id;
        }        
        return view('admin.roles.update', compact(
            'model',
            'permission',
            'page_heading',
            'permissionLists'
        ));
    }
    public function update(Request $request, $id){
        $model = Role::find($id);
        $request->validate([
           'name' => 'required|unique:roles,name,'.$model->id,
           'prev' => 'required'
        ]);
        $model->update(['name'=>$request->name]);
        DB::table('role_has_permissions')->where('role_id', $id)->delete();
        if(!empty($request->input('prev'))){
            foreach($request->input('prev') as $prek=>$prev){
                DB::table('role_has_permissions')->insert([ 'permission_id' => $prev, 'role_id' => $id ]);
            }
        }
        Artisan::call('cache:clear');
        return redirect()->route('role.index')->with('success','Role created successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {        
        if (!Auth::user()->can('admin-role-delete')) {
           return response()->json(['data' => false]);
        }
        if (Role::find($id)->delete()) {
            return response()->json(['data' => true]);
        } else {
            return response()->json(['data' => false]);
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
        $condition = "name like '%$searchValue%'";
        $totalRecords = Role::select('count(*) as allcount')
            ->whereRaw($condition)
            ->whereNotIN('id',[2,3,4,5])
            ->count();
        $totalRecordswithFilter = Role::select('count(*) as allcount')
                    ->whereRaw($condition)
                    ->whereNotIN('id',[2,3,4,5])
                    ->count();
        $collection = Role::orderBy($columnName,$columnSortOrder)
           ->whereRaw($condition)
           ->whereNotIN('id',[2,3,4,5])
           ->select('roles.*')
           ->skip($start)
           ->take($rowperpage)
           ->get();
        foreach ($collection as $key => $value) {
            $buttons = '';   
            if ($user->can('admin-role-update')) { 
                $buttons .= ' <a class="btn btn-icon btn-sm btn-color-dark" href="' . route("role.edit", $value->id) . '"><i class="fas fa-edit"></i></a>';
            }
            if ($value->id!==1 && $user->can('admin-role-delete')) {
                $buttons .= ' <button type="button" class="btn btn-icon btn-sm btn-color-dark" onclick="removeFunc(' . $value->id . ')"><i class="fas fa-trash"></i>';
            }
            $data_arr[] = array(
              "id" => $value->id,             
              "name" => $value->name,              
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
