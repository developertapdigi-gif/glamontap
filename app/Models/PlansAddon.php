<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlansAddon extends Model
{
    use HasFactory;
    protected $guarded = [];
    CONST STATUS = [1=>'Enable',0=>'Disable'];
}
