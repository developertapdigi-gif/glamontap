<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{SkillCategory,LikeEndorsement as Like,User};

class PostEndorsement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'skill_id',
        'status',
    ];

    public function SkillCategory(){
        return $this->hasOne(SkillCategory::class, 'id', 'skill_id');
    }
    Public function Post(){
        return $this->hasOne(Post::class,'id','post_id');
    }
    Public function Like(){
        return $this->hasOne(Like::class,'endorsement_id','id');
    }
    Public function agency(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
