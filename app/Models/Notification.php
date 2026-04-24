<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Services\FirebaseNotificationService;
class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];
    CONST TYPE = [
        1=>'New job published',
        2=>'New application Received',
        3=>'Application Accepted',
        4=>'Application Rejected',
        5=>'Review Received',
        6=>'Comment Received',
        7=>'Endorsement Received',
        8=>'Completed Job',
        9=>'Cancel Job',
        10=>'Complaint Trader',
        11=>'Friend Request Received',
        12=>'Accept Friend Request',
        13=>'Extended Job Date',
        14=>'Post Like',
        15=>'Endorsement Accepted',
        16=>'Endorsement Rejected',
        17=>'Post Comment',
        18=>'Post Like',
        19=>'WithDraw Bid',
        20=>'agency extend date to agency',
        21=>'Endorsement Comment'
    ];
    public static function getNotificationsByRecieverId($userid){
        $user = User::find($userid);
        $data = Notification::where('receiver_id', $userid)->where('is_viewed', 0)->orderby('id', 'desc')->paginate(4);
        return $data;
    }

    public static function getNotificationsByRecieverIdCount($userid){
        return Notification::where('receiver_id', $userid)->where('is_viewed', 0)->count();
    }

    //Recent Activities
    public static function getNotificationsForDashboard($userid){
        $user = User::find($userid);
        $data = [];
        if($user->user_type == User::ROLE['agency_sub_user']){
            $data = Notification::whereRaw('receiver_id ='.$userid.' and is_viewed =0')->orderby('id', 'desc')->paginate(4);
        }elseif($user->user_type == User::ROLE['agency']){
            $data = Notification::whereRaw('receiver_id ='.$userid.' and is_viewed =0')->orderby('id', 'desc')->paginate(4);
        }else{
           $data = Notification::where('is_viewed',0)->orderby('id', 'desc')->paginate(4);
        }   
        return $data;
    }

    public function Sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function Receiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function sendNotification($message){       
        $firebaseService = new FirebaseNotificationService();
       return $firebaseService->sendPushNotificationSync($message); 
    }
    public function saveNotification($data){    
        return self::create($data);
    }
    public static function getTypename($typeid){
        $type = [
            1=>'New job published',
            2=>'New application Received',
            3=>'Application Accepted',
            4=>'Application Rejected',
            5=>'Review Received',
            6=>'Comment Received',
            7=>'Endorsement Received',
            8=>'Completed Job',
            9=>'Cancel Job',
            10=>'Complaint Trader',
            11=>'Friend Request Received',
            12=>'Accept Friend Request',
            13=>'Extended Job Date',
            14=>'Endorsement Like',
            15=>'Endorsement Accepted',
            16=>'Endorsement Rejected',
            17=>'Post Comment',
            18=>'Post Like',
            19=>'WithDraw Bid',
            20=>'agency extend date to agency',
            21=>'Endorsement Comment'
        ];
        return $type[$typeid];
    }
}
