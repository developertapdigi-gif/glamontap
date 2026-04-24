<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use App\Http\Resources\{PostResource,PostCollection,UserResource,GalleryResource,SkillResource,CommentResource,GalleryCollection,CommentCollection,LikeResource};
use App\Models\{Post,PostGallery,PostComment,PostLike,PostEndorsement,PostCommentLike,User,Notification,SkillCategory};
class PostController extends BaseController
{
	use FileUploadTrait;
    public function deleteMedia(Request $request){
        $validator = Validator::make($request->all(), [
            'post_id' => ['required','exists:posts,id'],
            'gallery_id' => ['required','exists:post_galleries,id'],
        ]);
         if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 417);
        }else{
            PostGallery::where('id',$request->gallery_id)->first()->delete();
            return $this->responseApi([], true, 'Attachment deleted Successfully', 200);
        }
    }
    public function getComments(Request $request,$id){      
        $pageSize  = $request->page_size ?? $this->pageSize;     
        $comments   = PostComment::query()
                    ->where('post_id',$id)
                    ->orderBy('id','asc')
                    ->paginate($pageSize);  
        return new CommentCollection($comments); 
        
    }

    public function getLikes(Request $request,$id){      
        $pageSize  = $request->page_size ?? $this->pageSize;   
        $likes   = PostLike::where('post_id',$id)->orderBy('id','asc')
                    ->paginate($pageSize);  
                   
        return LikeResource::collection($likes); 
        
    }

    public function getListing(Request $request)
    { 
        $user      = $request->user(); 
        $pageSize  = $request->page_size ?? $request->page_size;  
        $condition = 'id>0';  
        if($request->author_id){
        	$condition .= ' and status=1 and author_id='.$request->author_id;
        }else{
            $condition .= ' and author_id='.$user->id;
        }    
        $posts   = Post::query()
        			->whereRaw($condition)
        			->orderBy('id','desc')
        			->paginate($pageSize);
        return new PostCollection($posts);
    }
    /*
    * Add new comment 
    */
    public function addPostComment(Request $request){
        $validator = Validator::make($request->all(), [
            'post_id' => ['required','exists:posts,id'],
            'comment' => 'required',
            'parent_id' => 'nullable',
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 417);
        } else {
            $user       = $request->user();  
            $inputs     = $request->all();
            $inputs['user_id']  = $user->id;
            $comment    = PostComment::create($inputs); 
            $post = Post::find($request->post_id);
            if($post->author_id != $user->id){
                $notification = new Notification();
                $savedNotification = $notification->saveNotification([
                    'type' => 17,
                    'type_text'=>'Post Comment',
                    'sender_id'=>$user->id,
                    'receiver_id'=>$post->author->id,
                    'reference_id'=>$post->id,
                    'message'=> 'Comment has been added on your post by '.$user->first_name.'.'
                ]);
                if($post->author->device_token && $post->author->notification == 1){
                    $notification->sendNotification([
                        'message' => [
                            'token' =>$post->author->device_token,
                            'notification' => [
                                'title' =>'Post Comment',
                                'body'  =>'Comment has been added on your post by '.$user->first_name.'.'
                            ],
                            'data'=>[
                                'notification_id'=>(string)$savedNotification->id,
                                'type'=>'post_comment',
                                'id'=>(string)$post->id
                            ]
                        ]
                    ]);
                }
            }   
            return $this->responseApi($comment, true, 'Comment added Successfully', 200);
        }
    }
    /*
    * 
    * 
    */
    public function postLikeDislike(Request $request){
        $validator = Validator::make($request->all(), [
            'post_id' => ['required','exists:posts,id'],
            'type' =>['required', 'integer', 'between:1,2'],
        ],[
            'type.between'=>'Type field must be 1 or 2'
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 417);
        } else {
            $user       = $request->user();  
            $isExists   = PostLike::where('user_id',$user->id)                      
                        ->where('post_id',$request->post_id)
                        ->first();    
            if($isExists){
                $likes = [
                    'type'=>2,
                    'user_id'=>$isExists->user_id,                   
                    'post_id'=>$isExists->post_id,
                    'updated_at'=>$isExists->updated_at,
                    'created_at'=>$isExists->created_at,
                    'id'=>$isExists->id,
                ];
                $isExists->delete();
                $message = 'Like removed Successfully';               
            }else{
                $inputs     = $request->all();
                $inputs['user_id']  = $user->id;
                $inputs['type']     = 1;
                $message    = 'Like added Successfully';
                $likes      = PostLike::create($inputs);  
                $post = Post::find($request->post_id);
            if($post->author_id != $user->id){
                $notification = new Notification();
                $savedNotification = $notification->saveNotification([
                    'type' => 18,
                    'type_text'=>'Post Like',
                    'sender_id'=>$user->id,
                    'receiver_id'=>$post->author->id,
                    'reference_id'=>$post->id,
                    'message'=> 'Your post has been liked by '.$user->first_name.'.'
                ]);
                if($post->author->device_token  && $post->author->notification == 1){
                    $notification->sendNotification([
                        'message' => [
                            'token' =>$post->author->device_token,
                            'notification' => [
                                'title' =>'Post Like',
                                'body'  =>'Your post has been liked by '.$user->first_name.'.'
                            ],
                            'data'=>[
                                'notification_id'=>(string)$savedNotification->id,
                                'type'=>'post_like',
                                'id'=>(string)$post->id
                            ]
                        ]
                    ]);
                }
            }    
            }              
            return $this->responseApi($likes, true,$message, 200);
            
        }
    }

    public function commentsLikeDislike(Request $request){
        $validator = Validator::make($request->all(), [
            'comment_id' => ['required','exists:post_comments,id'],
            'type' =>['required', 'integer', 'between:1,2'],
        ],[
            'type.between'=>'Type field must be 1 or 2'
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 417);
        } else {
            $user       = $request->user();  
            $isExists   = PostCommentLike::where('user_id',$user->id)                      
                        ->where('comment_id',$request->comment_id)->first();                              
           if($isExists){
                $likes = [
                    'type'=>2,
                    'comment_id'=>$isExists->comment_id,                   
                    'user_id'=>$isExists->user_id,
                    'updated_at'=>$isExists->updated_at,
                    'created_at'=>$isExists->created_at,
                    'id'=>$isExists->id,
                ];
                $isExists->delete();
                $message    = 'Like removed Successfully';                                
            }else{
                $message = 'Like added Successfully';
                $comment    = PostComment::find($request->comment_id);
                $inputs     = $request->all();
                $inputs['user_id']  = $user->id;
                $inputs['post_id']  = $comment->post_id;
                $likes    = PostCommentLike::create($inputs);  
                $post = Post::find($comment->post_id);
                if($comment->user_id != $user->id){
                    $notification = new Notification();
                    $savedNotification = $notification->saveNotification([
                        'type' => 17,
                        'type_text'=>'Post Comment Like',
                        'sender_id'=>$user->id,
                        'receiver_id'=>$comment->user_id,
                        'reference_id'=>$post->id,
                        'message'=> 'Your comment is liked by '.$user->first_name.'.'
                    ]);
                    if($comment->user->device_token && $comment->user->notification == 1){
                        $notification->sendNotification([
                            'message' => [
                                'token' =>$comment->user->device_token,
                                'notification' => [
                                    'title' =>'Post Like',
                                    'body'  =>'Your comment is liked by '.$user->first_name.'.'
                                ],
                                'data'=>[
                                    'notification_id'=>(string)$savedNotification->id,
                                    'type'=>'post_like',
                                    'id'=>(string)$post->id
                                ]
                            ]
                        ]);
                    }
                }
            }            
            return $this->responseApi($likes, true,$message, 200);
            
        }
    }
    /*
        show post details
    */
     public function showPost(Request $request,$id){
        $user       = $request->user();  
        $post       = Post::findOrFail($id);
        $comments   = $post->comments;
        $likes      = $post->likes;
        $postLike    = PostLike::where('post_id',$id)->where('user_id',$user->id)->first(); 
        $isOwner    = false;
        if($user->id==$post->author_id){
            $isOwner    = true;
        }
        $endorsements = $post->endorsements;
        $is_endorsement = $taggedUsers = null;
        $is_tagged = false;
        $acceptedUsers = [];
        if($endorsements){
            $userIDs      = $endorsements->pluck('user_id')->toArray();
            $taggedUsers  = UserResource::collection(User::whereIn('id',$userIDs)->get());
            $acceptedIDs  = $endorsements->where('status',1)->pluck('user_id')->toArray();
            $acceptedUsers= UserResource::collection(User::whereIn('id',$acceptedIDs)->get());
            $is_endorsement = PostEndorsement::where('post_id',$id)->where('user_id',$user->id)->first();
            $is_tagged = true;
            if($is_endorsement){
                $is_endorsement_status = $is_endorsement->status?true:false;
            }else{
                $is_endorsement_status = false;
            }
        }
        $postDetail = [
            'id'=>$post->id,
            'is_owner'=>$isOwner,
            'title'=>$post->title,
            'location'=>$post->location,
            'content'=>$post->content,
            'skill_id'=>$post->skill_id>0 ? new SkillResource($post->SkillCategory) : null,
            'post_type'=>$post->post_type,
            'status'=>$post->status,
            'is_endorsement'=>$is_endorsement_status,
            'is_tagged'=>$is_tagged,
            'created_at'=>$post->created_at,
            'comment_count'=>$comments->count(),
            'like_count'=>$likes->count(),
            'likes'=>LikeResource::collection($post->likes),
            'user_like'=>$postLike ? new LikeResource($postLike) : null,
            'users'=>$taggedUsers,
            'author'=>new UserResource($post->author),
            'galleries'=>GalleryResource::collection($post->gallery),            
            'comments'=>CommentResource::collection($comments),
            'accepted_users'=>$acceptedUsers,
        ];;
        return $this->responseApi($postDetail, true,'Post fetched Successfully', 200);
     }   
    /*
        * Add New Post
    */
    public function savePost(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'location' => 'nullable',
            'status' => 'required',
            //'skill_id' => ['required','exists:skill_categories,id'],
            'other_skill'=>'nullable',
            'users' => 'nullable',
            'image.*' => 'nullable|mimes:png,jpeg,jpg|max:5120',        
            'video' => 'nullable|mimes:mp4,mpeg,mpkg|max:25600',
        ], 
        [
            'skill_id.required' => 'Please select skill',
            'skill_id.exists' => 'Please select valid skill',
            'image.*.mimes' => 'Gallery image must be a image',
            'image.*.max' => 'Image should be 5 MB max.',
            'video.*.max' => 'Video should be 25 MB max.',
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 417);
        } else {
        	$user 		          = $request->user();  
        	$inputs 	          = $request->all();
            $inputs['author_id']  = $user->id;
        	$inputs['type'] 	  = 1;
            $other_skill = $request->other_skill;
            if($other_skill){
                $skillcategoryfind = SkillCategory::where('name',$other_skill)->first();
                if($skillcategoryfind){
                    $inputs['skill_id'] = $skillcategoryfind->id;
                }else{
                    $other_id = SkillCategory::create([
                        'name' => $other_skill,
                        'status'=>1
                    ]);
                    $inputs['skill_id'] = $other_id->id;
                }
            }
            unset($inputs['other_skill']);
        	$post = Post::create($inputs);     	
        	if($request->file('image')){
        		$images = $request->file('image');
        		foreach($images as $_file)
        		{
	    		  	$file_path = $this->ImageUpload($_file, 'uploads/uploads/gallery/');	
	    		  	PostGallery::create([
	    		  		'path'=>$file_path,
	    		  		'type'=>1,
	    		  		'post_id'=>$post->id,
	    		  	]);           
            	}
        	}
        	if($request->file('video')){
        		$video 	   = $request->file('video');
        		$file_path = $this->ImageUpload($video, 'uploads/uploads/gallery/');	
    		  	PostGallery::create([
    		  		'path'=>$file_path,
    		  		'type'=>2,
    		  		'post_id'=>$post->id,
    		  	]);  
        	}
            if($request->users){
                $endorseUsers = explode(',', $request->users);
                foreach ($endorseUsers as $user_id) {
                   PostEndorsement::create([
                        'user_id'=>$user_id,
                        'post_id'=>$post->id,
                        'skill_id'=>$post->skill_id,
                        'status'=>0,
                   ]); 
                   $agency = User::find($user_id);
                   $notification = new Notification();
                            $notification->saveNotification([
                                'type' => 7,
                                'type_text'=>'agency_endorsement_post',
                                'is_sent'=>1,
                                'sender_id'=>$user->id,
                                'receiver_id'=>$agency->id,
                                'reference_id'=>$post->id,
                                'message'=>$user->first_name.' has sent you a request for endorsement. Please review and consider the request. Thank you!'
                            ]);
                        if($agency->device_token && $agency->notification == 1){
                            $notification->sendNotification([
                                'message' => [
                                    'token' =>$agency->device_token,
                                    'notification' => [
                                        'title' =>'Endorsement Received',
                                        'body'  =>$user->first_name.' has sent you a request for endorsement. Please review and consider the request. Thank you!'
                                    ],
                                    'data'=>[
                                        'notification_id'=>(string)$notification->id,
                                        'type'=>'agency_endorsement_post',
                                        'id'=>(string)$post->id
                                    ]
                                ]
                            ]);
                            
                        }
                }
            }
        	return $this->responseApi(PostResource::make($post), true, 'Post added Successfully', 200);
        }
    }

    public function updatePost(Request $request,$id)
    {
    	$user = $request->user();
    	$post = Post::where('id',$id)->where('author_id',$user->id)->first();
        if(!$post){           
            return $this->responseApi([], false,"Invalid Post", 417);
        }
    	$validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'location' => 'nullable',
            'status' => 'required',
            //'skill_id' => ['required','exists:skill_categories,id'],
            'other_skill'=>'nullable',
            'users' => 'nullable',
            'image.*' => 'nullable|mimes:png,jpeg,jpg|max:5048',
            'video' => 'nullable|mimes:mp4,mpeg,mpkg|max:25600',
        ], 
        [
            'skill_id.required' => 'Please select skill',
            'skill_id.exists' => 'Please select valid skill',
            'image.*.mimes' => 'Gallery image must be a image',
            'image.*.max' => 'Image should be 5 MB max.',
            'video.*.max' => 'Video should be 25 MB max.',
        ]);
        if ($validator->fails()) {
            return $this->responseApi([], false,$validator->messages()->first(), 417);            
        } else {
        	$inputs = $request->all();
            $other_skill = $request->other_skill;
            if($other_skill){
                $skillcategoryfind = SkillCategory::where('name',$other_skill)->first();
                if($skillcategoryfind){
                    $inputs['skill_id'] = $skillcategoryfind->id;
                }else{
                    $other_id = SkillCategory::create([
                        'name' => $other_skill,
                        'status'=>1
                    ]);
                    $inputs['skill_id'] = $other_id->id;
                }
                
                
            }
            unset($inputs['other_skill']);
        	$post->update($inputs);	
        	if($request->file('image')){
        		$images = $request->file('image');
        		foreach($images as $_file)
        		{
	    		  	$file_path = $this->ImageUpload($_file, 'uploads/uploads/gallery/');	
	    		  	PostGallery::create([
	    		  		'path'=>$file_path,
	    		  		'type'=>1,
	    		  		'post_id'=>$post->id,
	    		  	]);           
            	}
        	}
        	if($request->file('video')){
        		$video 	   = $request->file('video');
        		$file_path = $this->ImageUpload($video, 'uploads/uploads/gallery/');	
    		  	PostGallery::create([
    		  		'path'=>$file_path,
    		  		'type'=>2,
    		  		'post_id'=>$post->id,
    		  	]);  
        	}
            if($request->users){
                $endorseUsers = explode(',', $request->users);
                $userIds   = PostEndorsement::where('post_id',$id)->pluck('user_id')->toArray();
                $result    = array_diff($userIds,$endorseUsers);
                $existingIds = [];
                foreach($endorseUsers as $user_id){
                    $endorse = PostEndorsement::where('post_id',$id)
                                ->where('user_id',$user_id)
                                ->first();
                    if(!$endorse){
                        PostEndorsement::create([
                            'user_id'=>$user_id,
                            'post_id'=>$post->id,
                            'skill_id'=>$post->skill_id,
                            'status'=>0,
                        ]);
                        $agency = User::find($user_id);
                        $notification = new Notification();
                            $notification->saveNotification([
                                'type' => 7,
                                'type_text'=>'agency_endorsement_post',
                                'is_sent'=>1,
                                'sender_id'=>$user->id,
                                'receiver_id'=>$agency->id,
                                'reference_id'=>$post->id,
                                'message'=>$user->first_name.' sent a endorsement request to you. Please review and consider the request. Thank you!'
                            ]);
                        if($agency->device_token && $agency->notification == 1){
                            
                            $notification->sendNotification([
                                'message' => [
                                    'token' =>$agency->device_token,
                                    'notification' => [
                                        'title' =>'Endorsement Received',
                                        'body'  =>$user->first_name.' sent a endorsement request to you. Please review and consider the request. Thank you!'
                                    ],
                                    'data'=>[
                                        'notification_id'=>(string)$notification->id,
                                        'type'=>'agency_endorsement_post',
                                        'id'=>(string)$post->id
                                    ]
                                ]
                            ]);
                            
                        }
                    }
                    array_push($existingIds, $user_id);
                }
                if(count($existingIds)){
                    PostEndorsement::where('post_id',$id)->whereNotIN('user_id',$existingIds)->delete();
                }  
            }else{
                PostEndorsement::where('post_id',$id)->delete();
            }
        	return $this->responseApi(PostResource::make($post), true, 'Post updated Successfully', 200);
        }
    }
    /*
    * Delete Post
    */
    public function deletePost(Request $request){
        $user       = $request->user();
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|integer|exists:posts,id,author_id,'.$user->id,
        ],[
            'post_id.exists'=>'Invalid Post'
        ]);
        if ($validator->messages()->first()) {
            return $this->responseApi([], false,$validator->messages()->first(), 417);
        } else {           
            $user       = $request->user();
            $model = Post::where('author_id',$user->id)->where('id',$request->post_id)->first();
            if($model){
                PostComment::where('post_id',$model->id)->delete();
                PostLike::where('post_id',$model->id)->delete();
                PostEndorsement::where('post_id',$model->id)->delete();
                PostGallery::where('post_id',$model->id)->delete();
                Notification::where('reference_id',$model->id)->wherein('type',[7,14,15,16,17,18])->delete();
                $model->delete();
            }    
            return $this->responseApi([], true, 'Post Deleted', 200);
        }
    }
    /*
    * Get all Videos
    */
    public function getMedia(Request $request){        
        $validator = Validator::make($request->all(), [           
            'type' =>['required', 'integer', 'between:1,2'],
            'user_id'=>['nullable']
        ],[
            'type.between'=>'Type field must be 1 or 2'
        ]);
        if ($validator->messages()->first()) {
            return $this->responseApi([], false,$validator->messages()->first(), 417);
        }else{
            $user       = $request->user();
            if($request->user_id){
                $user = User::find($request->user_id);
            }
            $pageSize  = $request->page_size ?? $this->pageSize;   
            $type = $request->type;      
            
            $galleries = PostGallery::whereHas("post", function ($q) use ($user) {
                    $q->where('author_id', $user->id);
            })            
            ->whereIn('id', function ($query) use($type) {
                $query->from('post_galleries')->where('type',$type)->selectRaw('MIN(id)')->groupBy('post_id');
            })
            ->orderBy('post_id','desc')
            ->paginate($pageSize);

            return new GalleryCollection($galleries);
        }
    }
    public  function endorsementStatus(Request $request){
        $validator = Validator::make($request->all(), [           
            'status' =>['required', 'integer', 'between:1,2'],
            'post_id' => 'required|integer|exists:posts,id',
        ],[
            'type.between'=>'Type field must be 1 or 2'
        ]);
        if ($validator->messages()->first()) {
            return $this->responseApi([], false,$validator->messages()->first(), 417);
        }else{
            $user  = $request->user();
            $model = PostEndorsement::where('post_id',$request->post_id)->where('user_id',$user->id)->first();
            if($model){
                $model->status = $request->status;
                $model->save();
                $typeText = [
                    1=>'Accepted',
                    2=>'Rejected'
                ];
                if($request->status == 1){
                    $type = 15;
                    $title_text = "Endorsement Accepted";
                    $notify_type_text = "endrosement_accepted";
                    $body = 'Your endorsement post request has been accepted by '.$user->first_name.'.';
                }elseif($request->status == 2){
                    $type = 16;
                    $title_text = "Endorsement Rejected";
                    $notify_type_text = "endrosement_rejected";
                    $body = 'Your endorsement post request has been rejected by '.$user->first_name.'.';
                }
                $post = Post::find($request->post_id);
                if($post){
                    $notification = new Notification();
                    $savedNotification = $notification->saveNotification([
                        'type' => $type,
                        'type_text'=>$title_text,
                        'sender_id'=>$user->id,
                        'receiver_id'=>$post->author->id,
                        'reference_id'=>$post->id,
                        'message'=> $body
                    ]);
                    if($post->author->device_token && $post->author->notification == 1){
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
                return $this->responseApi([], true,'Endorsement '.lcfirst($typeText[$request->status]).' Successfully', 200);
            }else{
                return $this->responseApi([], false,'Invalid endorsement', 400);
            }
            
        }
    }
}
