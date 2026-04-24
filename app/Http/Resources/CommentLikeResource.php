<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class CommentLikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {        
        $user = $this->user;    
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'user'=>$this->user->first_name.' '.$this->user->last_name,
            'profile_picture'=>$this->user->profile_picture  ? url($this->user->profile_picture ): '',
            'type'=>$this->type,
        ];
    }
}
