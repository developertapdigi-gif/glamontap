<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\UserConnection;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();     
        $user1Id = $user->id;
         $user2Id = $this->id;
        $connection = UserConnection::where(function ($query) use ($user1Id, $user2Id) {
            $query->where('user_id', $user1Id)
                  ->where('connection_id', $user2Id);
        })->orWhere(function ($query) use ($user1Id, $user2Id) {
            $query->where('user_id', $user2Id)
                  ->where('connection_id', $user1Id);
        })->first();

        $isFriend = $isFRqSent = false;      
        if($connection && $connection->status==1) {
            $isFriend = true;           
        }else if($connection && $connection->status == 0){
            $isFRqSent = true;
        }
        $isonline = false;
        if ($this->active_status == 1) {
            $isonline = true;
        }

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'user_type' => $this->user_type,
            'agency_name' => $this->agency_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'abn_acn' => $this->abn_acn,
            "is_online" => $isonline,
            "is_logged_in" => (boolean)$this->is_logged_in,
            'notification_status' => $this->notification,
            'post_count' => $this->posts->count(),
            'connect_count' => $this->connection_count,
            'over_all_rating' => $this->over_all_rating,
            'logo' => $this->logo ? url($this->logo) : '',
            'skill_id' => $this->skill_category_id ? new SkillResource($this->SkillCategory) : null,
            'badge_id' => $this->badge ? new BadgeResource($this->badge) : null,
            'profile_picture' => $this->profile_picture ? url($this->profile_picture) : '',
            'is_request_sent' => $isFRqSent,
            'is_friend' => $isFriend
        ];
    }
}