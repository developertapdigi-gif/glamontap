<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobLike extends Model
{
    use HasFactory;
    protected $table = 'task_likes';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
