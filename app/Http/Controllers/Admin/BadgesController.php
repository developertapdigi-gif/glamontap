<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BadgesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $badges = Badge::orderby('id', 'desc')->paginate(10);
        return view('admin.badges.index',compact('badges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = Badge::STATUS;
        return view('admin.badges.create',['status'=>$status,'classnames' =>Badge::CLASSNAME]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'minimum_range'=>'required',
            'maximum_range'=>'required|gt:minimum_range'
        ]);
        $request->except(['_token', '_method']);
        $input = $request->all();
        $model = Badge::create($input);
        return redirect('badges')->with('success', 'Badges has been created successfully!');
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
        $model = Badge::find($id);
        return view('admin.badges.update',
            [
            'model'=>$model,
            'status' => Badge::STATUS,
            'classnames' =>Badge::CLASSNAME
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model  = Badge::find($id);
        $validator =  $request->validate([
            'name' => 'required|unique:badges,name,'.$model->id,
            'status' => 'required',
            'minimum_range'=>'required',
            'maximum_range'=>'required|gt:minimum_range'
        ]);
        $input       = $request->all();
        $model->update($input);
        return redirect('badges')->with('success', 'Badge has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->user_type == User::ROLE['admin'])
        $model = Badge::find($id)->delete();
    
        return response()->json(['data' => true]);
    }
    public function changeStatus($id){
        $model = Badge::find($id);
        if($model){
            if($model->status == 1)
                $model->status = 0;
            else
            $model->status = 1;
        $model->save();
        }
        return redirect('badges')->with('success', 'Status has been updated successfully!');
    }
}
