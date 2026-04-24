<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\UserFeedPreferences;

class OtherSkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user       = $request->user();
        $userpreferences = UserFeedPreferences::where('user_id',$user->id)->where('skill_id',$this->id)->first();
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'is_selected'=>$userpreferences?true:false
        ];
    }
}
