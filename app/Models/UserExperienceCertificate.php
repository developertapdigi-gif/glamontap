<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExperienceCertificate extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the users that owns the comment.
     */
    public function user()
    {
        return $this->hasMany(User::class,'id','user_id');
    }
}
