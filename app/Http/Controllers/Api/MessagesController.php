<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\ChMessage as Message;
use App\Models\ChFavorite as Favorite;
use Chatify\Facades\ChatifyMessenger as Chatify;
use App\Models\{User,Notification};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Resources\{MessageResource,MessageCollection};

class MessagesController extends Controller
{
    protected $perPage = 30;    
    public function responseApi($data, $status, $message, $code)
    {
        return response()->json([
            'data' => $data,
            'message' => __($message),
            'status' => $status
        ], $code);
    }
     /**
     * Authinticate the connection for pusher
     *
     * @param Request $request
     * @return void
     */
    public function pusherAuth(Request $request)
    {
        $response =  $response = json_decode(Chatify::pusherAuth(
            $request->user(),
            Auth::user(),
            $request['channel_name'],
            $request['socket_id']
        ),true);
        if(array_key_exists('auth', $response)){    
            $channel_data = json_decode($response['channel_data'],true);

            return response()->json([
                'auth'=>$response['auth'],
                'shared_secret'=>null,
                'channel_data'=>[
                    'user_id'=>$channel_data['user_id'],
                    'user_info'=>[
                        'name'=>$channel_data['user_info']
                    ],
                ],
            ],200);
        }else{
            
        }
    }

    /**
     * Fetch data by id for (user/group)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function idFetchData(Request $request)
    {
        return auth()->user();
        // Favorite
        $favorite = Chatify::inFavorite($request['id']);

        // User data
        if ($request['type'] == 'user') {
            $fetch = User::where('id', $request['id'])->first();
            if($fetch){
                $userAvatar = Chatify::getUserWithAvatar($fetch)->avatar;
            }
        }

        // send the response
        return Response::json([
            'favorite' => $favorite,
            'fetch' => $fetch ?? null,
            'user_avatar' => $userAvatar ?? null,
        ]);
    }

    /**
     * This method to make a links for the attachments
     * to be downloadable.
     *
     * @param string $fileName
     * @return \Illuminate\Http\JsonResponse
     */
    public function download($fileName)
    {
        $path = config('chatify.attachments.folder') . '/' . $fileName;
        if (Chatify::storage()->exists($path)) {
            return response()->json([
                'file_name' => $fileName,
                'download_path' => Chatify::storage()->url($path)
            ], 200);
        } else {
            return response()->json([
                'message'=>"Sorry, File does not exist in our server or may have been deleted!"
            ], 404);
        }
    }

    /**
     * Send a message to database
     *
     * @param Request $request
     * @return JSON response
     */
    public function send(Request $request)
    {
        // default variables
        $error = (object)[
            'status' => 0,
            'message' => null
        ];
        $attachment = null;
        $attachment_title = null;

        // if there is attachment [file]
        if ($request->hasFile('file')) {
            // allowed extensions
            $allowed_images = Chatify::getAllowedImages();
            $allowed_files  = Chatify::getAllowedFiles();
            $allowed        = array_merge($allowed_images, $allowed_files);

            $file = $request->file('file');
            // check file size
            if ($file->getSize() < Chatify::getMaxUploadSize()) {
                if (in_array(strtolower($file->extension()), $allowed)) {
                    // get attachment name
                    $attachment_title = $file->getClientOriginalName();
                    // upload attachment and store the new name
                    $attachment = Str::uuid() . "." . $file->extension();
                    $file->storeAs(config('chatify.attachments.folder'), $attachment, config('chatify.storage_disk_name'));
                } else {
                    $error->status = 1;
                    $error->message = "File extension not allowed!";
                }
            } else {
                $error->status = 1;
                $error->message = "File size you are trying to upload is too large!";
            }
        }

        if (!$error->status) {
            // send to database
            $touser = User::find($request['id']);
            $sender = Auth::user();
            DB::table('ch_messages')->where('from_id',$touser->id)->where('to_id', $sender->id)->update(['seen'=>1]);
            $message = Chatify::newMessage([
                'type' => $request['type'],
                'from_id' => $sender->id,
                'to_id' =>$touser->id,
                'body' => htmlentities(trim($request['message']), ENT_QUOTES, 'UTF-8'),
                'attachment' => ($attachment) ? json_encode((object)[
                    'new_name' => $attachment,
                    'old_name' => htmlentities(trim($attachment_title), ENT_QUOTES, 'UTF-8'),
                ]) : null,
            ]);            
            if($touser->device_token && $touser->active_status != 1 && $touser->notification == 1){
                $title = ucfirst($sender->first_name) .' sent you a message';
                $notification = new Notification();
                $notification->sendNotification([
                    'message' => [
                        'token' =>$touser->device_token,
                        'notification' => [
                            'title' =>$title,
                            'body'  =>$request['message']
                        ],
                        'data'=>[
                            'type'=>'friend_message_sent',
                            'id'=>(string)$sender->id
                        ]
                    ]
                ]);
            }else{
                DB::table('ch_messages')->where('to_id',$sender->id)->where('from_id',$touser->id)->update(['seen'=>1]);
            }

            // fetch message to send it with the response
            $messageData = Chatify::parseMessage($message);
            $data = new MessageResource($message);
            // send to user using pusher
            if (Auth::user()->id != $touser->id) {
                if($touser->user_type==3){
                    Chatify::push("tapdigi-tradehook.".$touser->id,'messaging',$data);
                    Chatify::push('tapdigi-tradehook.'.$request['id'],'new_contact_update',[]);
                }else{
                    Chatify::push("tapdigi-tradehook.".$touser->id, 'messaging', [
                        'from_id' => $sender->id,
                        'to_id' => $request['id'],
                        'message' => Chatify::messageCard($messageData, true)
                    ]);
                }
            }
        }
        $isAttachment = false;
        if($attachment){
            $isAttachment = true;
        }        
        return $this->responseApi($data, true, 'message sent', 200);       
    }

    /**
     * fetch [user/group] messages from database
     *
     * @param Request $request
     * @return JSON response
     */
    public function fetch(Request $request)
    {
        $pageSize  = $request->page_size ?? $request->page_size;  
        $recieverID = $request->id;
        $messages = Message::where('from_id', Auth::user()->id)->where('to_id',$recieverID)
            ->orWhere('from_id',$recieverID)
            ->where('to_id',Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize);
        return new MessageCollection($messages);      
    }

    /**
     * Make messages as seen
     *
     * @param Request $request
     * @return void
     */
    public function seen(Request $request)
    {
        // make as seen
        $seen = Chatify::makeSeen($request['id']);
        // send the response
        return Response::json([
            'status' => $seen,
        ], 200);
    }

    /**
     * Get contacts list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse response
     */
    // get all users that received/sent message from/to [Auth user]
    public function getContacts(Request $request)
    {
        
        $pageSize  = $request->input('page_size', 10);
        $userId    = Auth::user()->id;
        $condition = "(from_id = $userId or to_id=$userId)";
        if($request->term){
            $term = $request->term;
            $condition .= " and body like '%$term%'";
        }
        $messages = Message::LatestConversations($userId)->paginate($pageSize);
        return new MessageCollection($messages); 
    }

    /**
     * Put a user in the favorites list
     *
     * @param Request $request
     * @return void
     */
    public function favorite(Request $request)
    {
        $userId = $request['user_id'];
        // check action [star/unstar]
        $favoriteStatus = Chatify::inFavorite($userId) ? 0 : 1;
        Chatify::makeInFavorite($userId, $favoriteStatus);

        // send the response
        return Response::json([
            'status' => @$favoriteStatus,
        ], 200);
    }

    /**
     * Get favorites list
     *
     * @param Request $request
     * @return void
     */
    public function getFavorites(Request $request)
    {
        $favorites = Favorite::where('user_id', Auth::user()->id)->get();
        foreach ($favorites as $favorite) {
            $favorite->user = User::where('id', $favorite->favorite_id)->first();
        }
        return Response::json([
            'total' => count($favorites),
            'favorites' => $favorites ?? [],
        ], 200);
    }

    /**
     * Search in messenger
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $input = trim(filter_var($request['input']));
        $records = User::where('id','!=',Auth::user()->id)
            ->where('first_name', 'LIKE', "%{$input}%")
            ->whereIn('user_type',[2,3])
            ->paginate($request->per_page ?? $this->perPage);
        return Response::json([
            'records' => $records->items(),
            'total' => $records->total(),
            'last_page' => $records->lastPage()
        ], 200);
    }

    /**
     * Get shared photos
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sharedPhotos(Request $request)
    {
        $images = Chatify::getSharedPhotos($request['user_id']);

        foreach ($images as $image) {
            $image = asset(config('chatify.attachments.folder') . $image);
        }
        // send the response
        return Response::json([
            'shared' => $images ?? [],
        ], 200);
    }

    /**
     * Delete conversation
     *
     * @param Request $request
     * @return void
     */
    public function deleteConversation(Request $request)
    {
       
        $delete = Chatify::deleteConversation($request->user_id);
        Chatify::push('tapdigi-tradehook.'.$request->user_id,'client-deleteConversation',[]);
        return $this->responseApi([], true, 'Conversation deleted successfully', 200);
    }

    public function updateSettings(Request $request)
    {
        $msg = null;
        $error = $success = 0;

        // dark mode
        if ($request['dark_mode']) {
            $request['dark_mode'] == "dark"
                ? User::where('id', Auth::user()->id)->update(['dark_mode' => 1])  // Make Dark
                : User::where('id', Auth::user()->id)->update(['dark_mode' => 0]); // Make Light
        }

        // If messenger color selected
        if ($request['messengerColor']) {
            $messenger_color = trim(filter_var($request['messengerColor']));
            User::where('id', Auth::user()->id)
                ->update(['messenger_color' => $messenger_color]);
        }
        // if there is a [file]
        if ($request->hasFile('avatar')) {
            // allowed extensions
            $allowed_images = Chatify::getAllowedImages();

            $file = $request->file('avatar');
            // check file size
            if ($file->getSize() < Chatify::getMaxUploadSize()) {
                if (in_array(strtolower($file->extension()), $allowed_images)) {
                    // delete the older one
                    if (Auth::user()->avatar != config('chatify.user_avatar.default')) {
                        $path = Chatify::getUserAvatarUrl(Auth::user()->avatar);
                        if (Chatify::storage()->exists($path)) {
                            Chatify::storage()->delete($path);
                        }
                    }
                    // upload
                    $avatar = Str::uuid() . "." . $file->extension();
                    $update = User::where('id', Auth::user()->id)->update(['avatar' => $avatar]);
                    $file->storeAs(config('chatify.user_avatar.folder'), $avatar, config('chatify.storage_disk_name'));
                    $success = $update ? 1 : 0;
                } else {
                    $msg = "File extension not allowed!";
                    $error = 1;
                }
            } else {
                $msg = "File size you are trying to upload is too large!";
                $error = 1;
            }
        }

        // send the response
        return Response::json([
            'status' => $success ? 1 : 0,
            'error' => $error ? 1 : 0,
            'message' => $error ? $msg : 0,
        ], 200);
    }

    /**
     * Set user's active status
     *
     * @param Request $request
     * @return void
     */
    public function setActiveStatus(Request $request)
    {
        $userID = Auth::user()->id;
        $activeStatus = $request['status'] ?? 2;       
        User::where('id',$userID)->update(['active_status' => $activeStatus]);       
        $recieverID = $request['user_id'];  
        if($recieverID){ 
            DB::table('ch_messages')                
                ->where('from_id',$recieverID)
                ->where('to_id', Auth::user()->id)
                ->update(['seen'=>1]);  
        }
        return $this->responseApi([], true, 'Status changed successfully', 200);
    }
}
