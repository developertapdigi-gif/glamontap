<?php

namespace App\Observers;

use App\Models\{Post,HomeFeed};

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {            
        if($post->status==1){
            HomeFeed::create([
                'post_id'=>$post->id,
                'type'=>2,
                'user_id'=>$post->author_id,
            ]);
        }
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        if($post->status==1){
            HomeFeed::updateOrCreate(
                [
                    'post_id'=>$post->id
                ],
                [
                    'post_id'=>$post->id,
                    'type'=>2,
                    'user_id'=>$post->author_id,
                ]
            ); 
        }else{
            $feed = HomeFeed::where('post_id',$post->id)->first();
            if($feed){
                $feed->delete();
            }
        }
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        $feed = HomeFeed::where('post_id',$post->id)->first();
        if($feed){
            $feed->delete();
        }
    }   
}
