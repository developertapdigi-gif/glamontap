<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PostCommentLike;
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {           
        $user       = $request->user();  
        $isOwner    = false;
        if($user->id==$this->user_id){
            $isOwner    = true;
        }        
        $commentLike  = PostCommentLike::where('comment_id',$this->id)
                    ->where('user_id',$user->id)
                    ->first();  
        return [
            'id'=>$this->id,
            'is_owner'=>$isOwner,
            'user_id'=>$this->user_id,
            'comment'=>$this->comment,
            'user'=>$this->user->first_name.' '.$this->user->last_name,
            'profile_picture'=>$this->user->profile_picture  ? url($this->user->profile_picture ): '',
            'like_count'=>$this->likes->count(),
            'user_like'=>new CommentLikeResource($commentLike),     
            'parent_id'=>$this->parent_id,
            'created_at'=>$this->created_at,
        ];
    }
}
