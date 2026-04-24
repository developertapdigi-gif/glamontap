<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\{User,Job,HomeFeed};
use Illuminate\Support\Facades\Auth;

class PostOverWallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postwalls = Post::orderby('created_at', 'desc')->paginate(10); 
        $postIds = Post::where('status',1)
                ->pluck('id')
                ->toArray();
        $jobsids = Job::select( "tasks.id")
            ->whereRaw("status in (1,2)")     
            ->pluck('id')
            ->toArray(); 
        $postIds    = $postIds ? implode(',', $postIds):  0;  
        $jobIds     = $jobsids ? implode(',', $jobsids):  0;  
        $condition  = "(job_id in($jobIds) and type=1) or ( post_id in($postIds) and type=2 )";
        $postwalls    = HomeFeed::whereRaw($condition)
                    ->orderByRaw('created_at desc')
                    ->paginate(10)->withQueryString();   
        return view('admin.post-over-wall.index',compact('postwalls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = Post::find($id);
        return view('admin.post-over-wall.show')->with(['model'=>$model]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->user_type == User::ROLE['admin'])
        $model = HomeFeed::find($id)->delete();
    
        return response()->json(['data' => true]);
    }

    public function changeStatus($id){
        $model = Post::find($id);
        if($model){
            if($model->status == 1 || $model->status == 0)
                $model->status = 2;
            else
            $model->status = 1;
        $model->save();
        }
        return response()->json(['data' => true]);
    }
   
}
