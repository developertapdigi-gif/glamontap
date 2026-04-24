<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostGallery extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->hasMany(Post::class,'id','post_id');
    }
}
