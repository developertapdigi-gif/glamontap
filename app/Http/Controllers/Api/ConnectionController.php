<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\{User,UserConnection,Notification};
use App\Http\Resources\{ConnectionCollection,UserCollection,NotificationCollection,NotificationResource};
class ConnectionController extends BaseController
{
	public function addUser(Request $request)
	{
		$user = $request->user(); 
        $validator = Validator::make($request->all(), [          
            'connection_id' => 'required|exists:users,id,user_type,3',
        ],[
            'connection_id.exists'=>'Invalid User'
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        }else{
        	$isExists = UserConnection::where('connection_id',$request->connection_id)
        	->where('user_id',$user->id)
        	->first();
        	if($isExists){
        		return $this->responseApi(false, false,"This user is already in your connection", 400);
        	}
        	 UserConnection::create([
				'connection_id' => $request->connection_id,
				'user_id' => $user->id,
				'status' => 0,
        	]);  
            $connectionUser = User::find($request->connection_id);
            $notification = new Notification();            
            
            $savedNotification = $notification->saveNotification([
                'type' => 11,
                'type_text'=>'send_friend_request',
                'sender_id'=>$user->id,
                'receiver_id'=>$connectionUser->id,
                'message'=> 'You have received a friend request from '.$user->first_name.'.'
            ]);
            if($connectionUser->device_token && $connectionUser->notification == 1){                
               $result_notify = $notification->sendNotification([
                    'message' => [
                        'token' =>$connectionUser->device_token,
                        'notification' => [
                            'title' =>'Friend Request Received',
                            'body'  =>'You have received a friend request from '.$user->first_name.'.'
                        ],
                        'data'=>[
                            'notification_id'=> (string)$savedNotification->id,
                            'type'=>'send_friend_request',
                            'id'=>(string)$user->id
                        ]
                    ]
                ]);
            }             
        	return $this->responseApi([], true, 'Connection request sent successfully', 200);
        }
	}
	public function removeUser(Request $request)
	{
		$user = $request->user(); 
        $validator = Validator::make($request->all(), [          
            'id' => 'required',
        ],[
            'id.exists'=>'Invalid connection'
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        }else{
            $connection = UserConnection::where('connection_id',$request->id)->where('user_id',$user->id)->first();
        	$connection2 = UserConnection::where('connection_id',$user->id)->where('user_id',$request->id)->first();
        	if( ($connection && $connection->delete() ) || ( $connection2 && $connection2->delete()) ){
                
                $user->connection_count = $user->connection_count-1;
                $user->save();
                
                $secondUser = User::find($request->id);
                $secondUser->connection_count = $secondUser->connection_count-1;
                $secondUser->save();

        		return $this->responseApi([], true, 'Connection removed successfully', 200);
        	}else{
        		return $this->responseApi([], true, 'Please try again', 400);
        	}        	
        }
	}
	public function statusUpdate(Request $request)
	{
		$user = $request->user(); 
        $validator = Validator::make($request->all(), [          
            'id' => 'required',
            'status' =>['required', 'integer', 'between:1,3'],
        ]);
        if ($validator->fails()) {
            return $this->responseApi(false, false,$validator->messages()->first(), 400);
        }else{
        	$connection = UserConnection::where('user_id',$request->id)->where('connection_id',$user->id)->first();
            if($request->status == 2){
                $connection->delete();
            }else{
                $connection->status = $request->status;
                $connection->save();
            }
        	$typeText = [
                1=>'accepted',
                2=>'rejected',
                3=>'blocked'
            ]; 
            if($request->status==1){
                $user->connection_count = $user->connection_count+1;
                $user->save();
                $secondUser = User::find($request->id);
                $secondUser->connection_count = $secondUser->connection_count+1;
                $secondUser->save();
                if($secondUser->device_token){
                    $notification = new Notification();
                    $savedNotification =$notification->saveNotification([
                        'type' => 12,
                        'type_text'=>'accept_friend_request',
                        'sender_id'=>$user->id,
                        'receiver_id'=>$secondUser->id,
                        'message'=> $user->first_name.' has accepted your friend request.'
                    ]);
                    if($secondUser->device_token && $secondUser->notification == 1){
                        $notification->sendNotification([
                            'message' => [
                                'token' =>$secondUser->device_token,
                                'notification' => [
                                    'title' =>'Connection accepted',
                                    'body'  => $user->first_name.' has accepted your friend request.'
                                ],
                                'data'=>[
                                    'notification_id'=> (string)$savedNotification->id,
                                    'type'=>'accept_friend_request',
                                    'id'=>(string)$user->id
                                ]
                            ]
                        ]);
                    }
                    
                }
            }   

        	return $this->responseApi([], true, 'Connection '.$typeText[$request->status].' successfully', 200);  	
        }
	}

	public function listUser(Request $request)
	{
        $user      = $request->user(); 
		$pageSize  = $request->page_size ?? $request->page_size;     
        if($request->status == 1){
            // my connection lists           
            $connectionIds = UserConnection::where('status', 1)
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('connection_id', $user->id);
            })
            ->selectRaw('CASE 
                WHEN user_id = ? THEN connection_id 
                WHEN connection_id = ? THEN user_id 
            END as connected_id', [$user->id, $user->id])
            ->pluck('connected_id')
            ->toArray();            
        }else{
            // I have to accept connection request
            $condition = "connection_id={$user->id} and status=0";
            $connectionIds = UserConnection::whereRaw($condition)          
                ->pluck('user_id')
            ->toArray();
        }        
        $users   = User::query()
                ->whereIn('id',$connectionIds)
                ->where('id','!=',$user->id)
                ->orderBy('id','desc')
                ->paginate($pageSize);
        return new UserCollection($users);    
	}
}