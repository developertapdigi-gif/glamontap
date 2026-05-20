<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    use HasFactory;
    protected $table = 'skill_categories';
    protected $fillable = [
        'name',
        'status',
        'image',
    ];

    public static function getStatus(){
        $array= [0=>'Deactivate',1=>'Activate'];
        return $array;
    }

    public function getStatusValue($value){
        if($value == 1)
        return 'Activate';
        else
        return 'Deactivate';
    }

    public static function getAllSkillCategory(){
        $skillcategory = SkillCategory::where('status','1')->get();
        return $skillcategory;
    }

    public static function getAllSkillCategoryCreate(){
        $skillcategory = SkillCategory::where('status','1')->get()->toArray();
        $skillcategory[] = ['id'=>2800000,'name' => 'Others','status'=>1];
        return $skillcategory;
    }

    public function JobSkillCategory(){
        return $this->hasOne(Job::class,'skill_category','id')->where('status', 2);
    }
}
