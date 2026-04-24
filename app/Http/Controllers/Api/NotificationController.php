<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\{User,Notification};
use App\Http\Resources\{NotificationCollection,NotificationResource};
use App\Services\FirebaseNotificationService;
class NotificationController extends BaseController
{
	public function setting(Request $request)
	{
	    $user = $request->user(); 
	    if($user->notification==1){
	        $user->notification = 0;
	        $message = 'Notification disabled now';
	    }else{
	        $message = 'Notification enabled now';
	        $user->notification = 1;
	    }        
	    $user->save();        
	    return $this->responseApi([], true,$message, 200);
	}
	public function getListing(Request $request){
		$user 		= $request->user(); 
		$pageSize 	= $request->page_size ?? $this->pageSize;     
		$notifications = Notification::where('receiver_id',$user->id)->whereNotNull('type_text')->orderBy('id','desc')->paginate($pageSize);  
        return new NotificationCollection($notifications); 
	}

	public function delete(Request $request){
		$user = $request->user(); 
		Notification::find($request->id)->delete();
		return $this->responseApi([], true,'Notification deleted', 200);
	}

	public function markRead(Request $request){
		$user = $request->user(); 
		$model = Notification::find($request->id);
		if($model){
			$model->is_viewed =1;
			$model->save();
			return $this->responseApi([], true,'Notification readed', 200);
		}else{
			return $this->responseApi([], false,'Notification id is invalid', 400);
		}
	}

	public function unreadCount(Request $request){
		$user = $request->user(); 
		$count = Notification::where('receiver_id',$user->id)->whereNotNull('type_text')->where('is_viewed',0)->count();
		return $this->responseApi(['count'=>$count], true,'Notification fetched', 200);
	}

	public function notificationTest(Request $request,FirebaseNotificationService $firebase){
		$message = [
	        'message' => [
	            'token' => $request->device_token,
	            'notification' => [
	                'title' => $request->title,
	                'body'  => $request->body
	            ],
	            'data'=>[
	            	'notification_id'=>'1',
	                'type'=>$request->type,
	                'id'=>$request->id
	            ]
	        ]
	    ];
		$response =  $firebase->sendPushNotificationSync($message);
		print_r($response); die;
	}
}