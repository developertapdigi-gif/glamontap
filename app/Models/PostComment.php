<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;
    protected $table = 'post_comments';
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'parent_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
    public function likes(){
        return $this->hasMany(PostCommentLike::class,'comment_id');
    }
}
