<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlansAddon;

class AddonPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addonplans = PlansAddon::orderby('id', 'desc')->paginate(10)->withQueryString();
        return view('admin.addon-plans.index',compact('addonplans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = PlansAddon::STATUS; 
        return view('admin.addon-plans.create',['status'=>$status]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'status'=>'required',
        ]);     
        $input =    $request->all();
        PlansAddon::create($input);
        return redirect('addon-plans')->with('success', 'Addon plan has been created successfully!');
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
        $model = PlansAddon::find($id);
        return view('admin.addon-plans.edit',
        [
            'model'=>$model,
            'status' =>PlansAddon::STATUS
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model  = PlansAddon::find($id);
        $validator =  $request->validate([
            'name' => 'required|unique:subscription_plans,name,'.$model->id,
            'price' => 'required',
            'status'=>'required'
        ]);
        $input     = $request->all();
        $model->update($input);
        return redirect('addon-plans')->with('success', 'Addon plan has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model  = PlansAddon::find($id);       
        if ($model->delete()) {           
            return response()->json(['data' => true,'Addon Plan deleted successfully']);
        } else {
            return response()->json(['data' => false,'message'=>'Unable to delete this addon plan, As there is quotation']);
        }
    }
}
