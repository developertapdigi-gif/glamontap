<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeFeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'type'=>$this->type,
            'job'=>$this->when($this->type==1,new JobResource($this->job)),
            'post'=>$this->when($this->type==2,new PostResource($this->post))           
        ];
    }
}
