<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobReviews extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function job()
    {
        return $this->hasOne(Job::class, 'id', 'job_id');
    }
}
