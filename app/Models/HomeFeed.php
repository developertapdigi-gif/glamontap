<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeFeed extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function job()
    {
        return $this->hasOne(Job::class, 'id', 'job_id');
    }
    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
    public function addedBy()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
