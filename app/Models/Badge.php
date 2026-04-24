<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    protected $table = 'badges';
    CONST CLASSNAME = ['sk-junior'=>'Yellow','sk-junior1'=>'Brown','sk-intermediate'=>'Blue','sk-intermediate1'=>'Sky Blue','sk-experience'=>'Green','sk-expert'=>'Red'];
    CONST STATUS = [0=>'Deactivate',1=>'Activate'];
    protected $fillable = [
        'name',
        'status',
        'minimum_range',
        'maximum_range',
        'class_name'
    ];

    public static function getAllBadges(){
        $badges = Badge::where('status','1')->get();
        return $badges;
    }
    public function JobBadge(){
        return $this->hasOne(Job::class,'experiance_range','id')->where('status', 2);
    }
}
