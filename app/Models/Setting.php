<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    public static function setting(){
    	$model = self::find(1);
        if($model->favicon && (File::exists(public_path($model->favicon)))){
            $thumbnail = asset($model->favicon);
          }else{
            $thumbnail = url('/').'/images/favicon.png';
          }   
          if($model->site_logo && (File::exists(public_path($model->site_logo)))){
            $thumbnail_logo = asset($model->site_logo);
          }else{
            $thumbnail_logo = url('/').'/images/logo.png';
          }
        $values = [
            'name_of_website' => $model->site_name??config('app.name'),
            'favicon'=> $thumbnail,
            'website_logo' => $thumbnail_logo,
            'fb_link'=> $model->fb_link??'https://www.facebook.com/',
            'instagram_link'=> $model->instagram_link??'https://www.instagram.com/',
            'linkedIn_link'=> $model->linkedIn_link??'https://www.linkedin.com/',
            'phone_number' => '123 456 7890',
            'support_email'=> 'support@glamontap.com'
        ];
        return $values;
    }

    public static function settingFeedback(){
      $model = self::find(1);
      $values = [
            'survey_days' => $model->survey_days,
            'survey_status'=> $model->survey_status,
            'survey_days_tradies' => $model->survey_days,
            'survey_status_tradies'=> $model->survey_status_tradies,
        ];
        return $values;
    }
}
