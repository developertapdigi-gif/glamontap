<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCommentLike extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(PostComment::class);
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
