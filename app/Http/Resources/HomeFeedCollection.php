<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class HomeFeedCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
   public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'links' =>[],
            'meta'=>[],
            'message'=>'Feed fetched successfully',
            'status'=>true,
        ];
    }
}
