<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{PostLike,User,PostEndorsement};
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user        = $request->user();  
        $postLike    = PostLike::where('post_id',$this->id)->where('user_id',$user->id)->first();       
        $hasEndorse  = PostEndorsement::where('post_id',$this->id)->where('user_id',$user->id)->first(); 
        $comments   = $this->comments;
        $likes      = $this->likes; 
        
        $isFriend = $isOwner = $isTagged = $isEndorse = false; 
        if($hasEndorse && $hasEndorse->status==1){
            $isEndorse = true;
        }
        if($hasEndorse){
            $isTagged = true;
        }
                 
        if($user->id==$this->author_id){
            $isOwner    = true;
        }
        if($user->id!=$this->author_id && $user->isFriend($this->author_id,$user->id)){
            $isFriend    = true;
        }
        $endorsements = $this->endorsements;
        $taggedUsers = null;
        $isEditable = true;
        $acceptedUsers = [];
        if($endorsements){
            $userIDs      = $endorsements->pluck('user_id')->toArray();
            $taggedUsers  = UserResource::collection(User::whereIn('id',$userIDs)->get());
            $acceptedIDs  = $endorsements->where('status',1)->pluck('user_id')->toArray();            
            $acceptedUsers= UserResource::collection(User::whereIn('id',$acceptedIDs)->get());
            $isEditable   = $endorsements->where('status',1)->first() ? false : true;
        }       
        return [
            'id'=>$this->id,
            'is_owner'=>$isOwner,
            'is_connection'=>$isFriend,
            'is_endorsement'=>$isEndorse,
            'is_tagged'=>$isTagged,
            'is_editable'=>$isEditable,
            'title'=>$this->title,
            'location'=>$this->location,           
            'content'=>$this->content,
            'skill_id'=>new SkillResource($this->SkillCategory),
            'post_type'=>$this->post_type,
            'status'=>(int) $this->status,
            'created_at'=>$this->created_at, 
            'comment_count'=>$comments->count(),
            'like_count'=>$likes->count(),
            'user_like'=>new LikeResource($postLike),           
            'author'=>new UserResource($this->author),
            'galleries'=>GalleryResource::collection($this->gallery),
            'users'=>$taggedUsers,
            'accepted_users'=>$acceptedUsers,
        ];
    }
}
