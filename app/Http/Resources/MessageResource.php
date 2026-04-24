<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {            
        $user = $this->user;
        $isAttachment = false;
        $attachment = '';
        if($this->attachment){
            $isAttachment = true;
            $attachment = json_decode($this->attachment);
        }
        $isSender = false;
        if(Auth::user()->id == $this->sender->id){
            $isSender = true;
        }
        $isonline = false;
        if($this->sender->active_status == 1){
            $isonline = true;
        }
        $count = 0;
        $is_logged_in = $isSeen = false;
        if($this->receiver->active_status == 1){
            $isSeen = true;
        }
        if(Auth::user()->id == $this->sender->id){
            $count = $this->sender->getUnreadSender($this->receiver->id,$this->sender->id);
            $is_logged_in = (boolean)$this->receiver->is_logged_in;
        }elseif(Auth::user()->id == $this->receiver->id){
            $count =  $this->sender->getUnreadSender($this->sender->id,$this->receiver->id);
            $is_logged_in = (boolean)$this->sender->is_logged_in;
        }
        return [  
            'id'=>$this->id,    
            'auth_id'=>Auth::user()->id,    
            'unread_count'=>$count,
            'is_online'=>$isonline,     
            'is_logged_in'=>$is_logged_in,     
            'from_id' =>$this->sender->id,
            'isSender'=>$isSender,
            'isSeen'=>$isSeen,
            'from_user' =>[
                'id'=>$this->sender->id,
                'name'=>$this->sender->first_name,
                'profile_picture'=>$this->sender->profile_picture                
            ] ,
            'to_id' =>$this->receiver->id,
            'to_user' => [
                'id'=>$this->receiver->id,
                'name'=>$this->receiver->first_name,
                'profile_picture'=>$this->receiver->profile_picture
            ], 
            'timeAgo'=>$this->updated_at,
            'body' => $this->body,
            'hasAttachment'=> $isAttachment,
            'attachment' => ($this->attachment) ? url('storage/attachments/'.$attachment->new_name) : null,
        ];
    }
}
