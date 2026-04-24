<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class JobLikeResource extends JsonResource
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
            'user'=>$user->first_name.' '.$user->last_name,
            'profile_picture '=>$user->profile_picture  ? url($user->profile_picture ): '',
            'type'=>$this->type,
        ];
    }
}
