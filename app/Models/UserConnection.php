<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConnection extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'connection_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'connection_id');
    }
}
