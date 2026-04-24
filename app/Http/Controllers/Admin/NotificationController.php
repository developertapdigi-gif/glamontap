<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->isviewed == 1){
            $user = User::find(Auth::user()->id);
            $data = [];
            if($user->user_type == User::ROLE['agency']){
            $data = Notification::where('receiver_id',$user->id.' and is_viewed =0')->get();
            }elseif($user->user_type == User::ROLE['agency_sub_user']){
                $data = Notification::whereRaw('receiver_id ='.$user->agency_id.' and is_viewed =0')->get();
            }
            else{
            $data = Notification::where('is_viewed',0)->orderby('id', 'desc')->get();
            } 
            if($user->user_type == User::ROLE['agency'] || $user->user_type == User::ROLE['agency_sub_user']){
                foreach($data as $notify_view){
                    $notify_view->is_viewed = 1;
                    $notify_view->update();
                }
            }
        }
        $condition = 'id>0';
        if(Auth::user()->user_type == User::ROLE['agency']){
            $condition = ' receiver_id ='. Auth::user()->id;
        }
        $notifications = Notification::whereRaw($condition)->orderby('created_at', 'desc')->paginate(10);       
        return view('admin.notifications.index',compact('notifications'));
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
        //
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
        //
    }

    public function viewed($id){
        $model = Notification::find($id);
       // print_r($model);die;
        if($model){
            $model->is_viewed = 1;
            $model->update();
            return response()->json(['status' => 200]);
        }
    }
}
