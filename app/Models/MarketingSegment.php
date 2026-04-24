<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingSegment extends Model
{
    use HasFactory;
    protected $guarded = [];
    CONST STATUS = [1=>'Enable',2=>'Disable'];
}
