<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PostEndorsement,LikeEndorsement,PostComment,Post,User,Notification};
use Illuminate\Support\Facades\Auth;

class EndrosementPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); 
        $sub_user = 0;
        if($user->user_type == User::ROLE['agency']){
            $agency_id = $user->id;
        }else{
            $agency_id = $user->agency_id;
        }
        $condition = 'user_id='.$agency_id;
        $endrosementposts = PostEndorsement::whereRaw($condition)->orderby('created_at', 'desc')->paginate(10);       
        return view('admin.endrosement-post.index',compact('endrosementposts'));
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
        return view('admin.endrosement-post.show')->with(['model'=>$model]);
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
    public function destroy($id){
        $endorse = PostEndorsement::find($id);
        $user = Auth::user();
        if($user->user_type == User::ROLE['agency']){
            $agency_id = $user->id;
        }else{
            $agency_id = $user->agency_id;
        }
        $model = LikeEndorsement::where(['user_id'=>$agency_id,'endorsement_id'=>$id])->delete();
        return redirect('endrosement-post')->with('success', 'Endorsement Post has been Dislike successfully!');
    }

    public function likeEndorse($id){
        $endorse = PostEndorsement::find($id);
        $user = Auth::user();
        if($user->user_type == User::ROLE['agency']){
            $agency_id = $user->id;
        }else{
            $agency_id = $user->agency_id;
        }
        $model = LikeEndorsement::create(['user_id'=>$agency_id,'post_id'=>$endorse->post_id,'endorsement_id'=>$id]);
        $post = Post::find($endorse->post_id);
        if($post){
            if($post->author_id){
                $notification = new Notification();
                $savedNotification = $notification->saveNotification([
                    'type' => 14,
                    'type_text'=>'Endorsement Post Like',
                    'sender_id'=>$agency_id,
                    'receiver_id'=>$post->author->id,
                    'reference_id'=>$post->id,
                    'message'=> 'Your post has been liked by '.$endorse->agency->agency_name.'.'
                ]);
                if($post->author->device_token){
                    $notification->sendNotification([
                        'message' => [
                            'token' =>$post->author->device_token,
                            'notification' => [
                                'title' =>'Endorsement Post Like',
                                'body'  =>'Your post has been liked by '.$endorse->agency->agency_name.'.'
                            ],
                            'data'=>[
                                'notification_id'=>(string)$savedNotification->id,
                                'type'=>'endrosement_post_like',
                                'id'=>(string)$post->id
                            ]
                        ]
                    ]);
                }
            }
        }
        return redirect('endrosement-post')->with('success', 'Endorsement Post has been Liked successfully!');
    }

    public function comment($post_id){
        $condition = 'post_id='.$post_id;
        $model = PostComment::whereRaw($condition)->orderby('created_at', 'desc')->paginate(5);
        if(count($model))
            $parent_id = $model[0]->id;
        else
            $parent_id = '';
        return view('admin.endrosement-post.comments',
            [
            'comments'=>$model,
            'post_id'=>$post_id,
            'parent_id'=>$parent_id
        ]);
    }

    public function storeComment(Request $request){
        $request->validate(['comment'=>'required']);
        $input = $request->all();
        $user = Auth::user();
        if($user->user_type == User::ROLE['agency']){
            $agency_id = $user->id;
        }else{
            $agency_id = $user->agency_id;
        }
        $input['user_id'] = $agency_id;
        $model = PostComment::create($input);
        $post = Post::find($model->post_id);
        if($post){
            if($post->author_id){
                $notification = new Notification();
                $savedNotification = $notification->saveNotification([
                    'type' => 21,
                    'type_text'=>'Endorsement Comment',
                    'sender_id'=>$agency_id,
                    'receiver_id'=>$post->author->id,
                    'reference_id'=>$post->id,
                    'message'=> 'Comment has been added on your post by '.$model->user->agency_name.'.'
                ]);
                if($post->author->device_token){
                    $notification->sendNotification([
                        'message' => [
                            'token' =>$post->author->device_token,
                            'notification' => [
                                'title' =>'Endorsement Comment',
                                'body'  =>'Comment has been added on your post by '.$model->user->agency_name.'.'
                            ],
                            'data'=>[
                                'notification_id'=>(string)$savedNotification->id,
                                'type'=>'endrosement_comment',
                                'id'=>(string)$post->id
                            ]
                        ]
                    ]);
                }
            }
        }
        return redirect('endrosement-post')->with('success', 'Comment has been added successfully!');
    }

    public function endroseRecord(Request $request){
        $user = Auth::user();
        if($user->user_type == User::ROLE['agency']){
            $userId = $user->id;
            $agency_name = $user->first_name . ' ' . $user->last_name;
        }else{
            $userId = $user->agency_id;
            $agency_name = $user->first_name . ' ' . $user->last_name;
        }
        $model = PostEndorsement::where('user_id',$userId)->where('post_id',$request->id)->first();
        $model->update(['status'=>$request->status]);
        if($request->status == 1){
            $type = 15;
            $title_text = "Endorsement Accepted";
            $notify_type_text = "endrosement_accepted";
            $body = 'Your endorsement post request has been accepted by '.$agency_name.'.';
        }elseif($request->status == 2){
            $type = 16;
            $title_text = "Endorsement Rejected";
            $notify_type_text = "endrosement_rejected";
            $body = 'Your endorsement post request has been rejected by '.$agency_name.'.';
        }
        $post = Post::find($request->id);
        if($post){
            $notification = new Notification();
            $savedNotification = $notification->saveNotification([
                'type' => $type,
                'type_text'=>$title_text,
                'sender_id'=>$userId,
                'receiver_id'=>$post->author->id,
                'reference_id'=>$post->id,
                'message'=> $body
            ]);
            if($post->author->device_token){
                $notification->sendNotification([
                    'message' => [
                        'token' =>$post->author->device_token,
                        'notification' => [
                            'title' =>$title_text,
                            'body'  =>$body
                        ],
                        'data'=>[
                            'notification_id'=>(string)$savedNotification->id,
                            'type'=>$notify_type_text,
                            'id'=>(string)$post->id
                        ]
                    ]
                ]);
            }
        }
        
        return response()->json(['status' => true]);
    }
}
