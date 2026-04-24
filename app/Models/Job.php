<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\JobObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Http;
#[ObservedBy([\App\Observers\JobObserver::class])]
class Job extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $guarded = [];
    CONST STATUS = [
        0=>'Draft',
        1=>'Approved',
        2=>'Approved',
        3=>'Cancelled',
        4=>'Ongoing',
        5=>'Upcoming',
        6=>'Completed',
    ];
    CONST JOBLABEL=[
        1=> 'Open',
        2=> 'Upcoming',
        3=> 'Ongoing',
        4=> 'Completed',
        5=> 'Draft',
        6=> 'Featured Jobs',
    ];
    CONST EXPERIENCE_RANGE = ['Beginner','Intermediate','Experienced'];

    public function skill(){
        return $this->hasOne(SkillCategory::class,'id','skill_category');
    }
    public function getStatusValue($value){
        if($value == 1)
        return 'Submit for approval';
        elseif($value== 2)
        return 'Approved';
        elseif($value== 3)
        return 'Cancelled';
        elseif($value== 4)
        return 'Ongoing';
        elseif($value== 5)
        return 'Upcoming';
        elseif($value== 6)
        return 'Completed';
        else
        return 'Draft';

    }
    public function agency()
    {
        return $this->hasOne(User::class, 'id', 'agency_id');
    }
    public function badge()
    {
        return $this->hasOne(Badge::class, 'id', 'experiance_range');
    }
    public function SkillCategory()
    {
        return $this->hasOne(SkillCategory::class, 'id', 'skill_category');
    }
    public function likes(){
        return $this->hasMany(JobLike::class,'task_id','id');
    }
    public function agent(){
        return $this->hasOne(User::class,'id','created_by');
    }
    public function trader(){
        return $this->hasOne(User::class,'id','bidder_id');
    }
    public function applications()
    {
        return $this->hasMany(JobApplication::class,'task_id','id')->whereIn('task_applications.status',[1,3,4]);
    }
     
    /* */
    public function bidding()
    {
        return $this->hasMany(JobApplication::class,'task_id','id');
    } 
    public function notification(){
        return $this->hasMany(Notification::class,'reference_id','id')->whereNotIn('notifications.type',[1,13])->orderBy('id','desc');
    }
    public function notificationAgency(){
        return $this->hasMany(Notification::class,'reference_id','id')->whereIn('notifications.type',[2,8])->orderBy('id','desc');
    }

    /* public static function getSuburbFromAddressNominatim($address)
    {
        $response = Http::withHeaders([
        'User-Agent' => 'YourAppName/1.0 (your@email.com)'
        ])->get("https://nominatim.openstreetmap.org/search", [
            'q' => $address,
            'format' => 'json',
            'addressdetails' => 1,
        ]);

        $results = $response->json();
        if (!empty($results[0]['address']['suburb'])) {
            return $results[0]['address']['suburb'];
        } elseif (!empty($results[0]['address']['city_district'])) {
            return $results[0]['address']['city_district'];
        }elseif (!empty($results[0]['address']['city'])) {
            return $results[0]['address']['city'];
        }elseif (!empty($results[0]['address']['state_district'])) {
            return $results[0]['address']['state_district'];
        }elseif (!empty($results[0]['address']['state'])) {
            return $results[0]['address']['state'];
        }

        return null;
    } */
 }
