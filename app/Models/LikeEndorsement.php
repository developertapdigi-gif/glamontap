<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostEndorsement;

class LikeEndorsement extends Model
{
    use HasFactory;
    protected $table = 'like_endorsement';
    protected $fillable = ['user_id','post_id','endorsement_id'];
    public function PostEndorsement(){
        return $this->hasOne(PostEndorsement::class, 'id', 'endorsement_id');
    }
}
