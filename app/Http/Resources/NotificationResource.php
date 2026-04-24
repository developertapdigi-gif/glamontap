<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
class NotificationResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $type = $this->type_text;
        if(in_array($this->type,[6,7])){
            $type = 'post';
        }
        $id = $this->reference_id;
        if(!$this->reference_id){
            if(Auth::user()->id == $this->receiver_id){
              $id = $this->sender_id;  
            }else{
                $id = $this->receiver_id;  
            }
        }
        return [
           'id'=>$this->id,
           'message'=>$this->message,
           'title'=>Notification::getTypename($this->type),
           'is_viewed'=>(boolean)$this->is_viewed,
           'time'=>$this->created_at,
           'data'=>[
            'type'=>$this->type_text,
            'id'=>$id,
           ]
        ];
    }
}