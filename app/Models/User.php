<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Laravel\Cashier\Billable;
use Illuminate\Support\Carbon;
use App\Http\Resources\{BadgeResource,SkillResource,ExperienceCertificateResource};
class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles,HasApiTokens,Billable;
    CONST ROLE = ['admin'=>1,'agency'=>2,'trader'=>3,'agency_sub_user'=>4];
    CONST STATUS = ['Pending','Approved','Blocked'];
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function Agency()
    {
        return $this->belongsTo(static::class, 'agency_id');
    }

    public static function getAgencyList(){
        $agency = User::where('user_type',User::ROLE['agency'])->get();
        return $agency;
    }

    public function getStatus($status){
        if($status == 1){
            return "<a class='skill-activate'>Approve</a>";
        }elseif($status == 2){
            return "<a class='skill-red-warning'>Blocked</a>";
        }else{
            return "<a class='skill-deactivate'>Pending</a>";
        }
    }

    public function getStatusShow($status){
        if($status == 1){
            return "Approve";
        }elseif($status == 2){
            return "Blocked";
        }else{
            return "Pending";
        }
    }
    public function skillCategory(){
        return $this->hasOne(SkillCategory::class,'id','skill_category_id');
    }
    public function badge(){
        return $this->hasOne(Badge::class,'id','badge_id');
    }
    public function JobApplication(){
        return $this->hasMany(JobApplication::class,'bidder_id','id')->where('status',1);
    }
    public function posts(){
        return $this->hasMany(Post::class,'author_id','id');
    }
    public function jobs()
    {
        return $this->hasMany(Job::class,'agency_id','id');
    }
    public function UserExperienceCertificate(){
        return $this->hasMany(UserExperienceCertificate::class,'user_id','id');
    }
    public function feedPreferences(){
        return $this->hasMany(UserFeedPreferences::class,'user_id','id');
    }
    public function getUnReadCountSender(){
        return $this->hasMany(ChMessage::class,'from_id','id')->where('seen',0);
    }
    public function getUnReadCountReceiver(){
        return $this->hasMany(ChMessage::class,'to_id','id')->where('seen',0);
    }
    public function getUnreadSender($from_id,$to_id){
        return ChMessage::where('from_id',$from_id)->where('to_id',$to_id)->where('seen',0)->count();
    }
    public function activePlan()
    {
        return $this->hasOne(AgencySubscription::class,'agency_id','id')->where('payment_status',1);
    }
    public function isFriend($currentUserId, $targetUserId) {      
        $isFriend = DB::table('user_connections')
            ->where(function ($query) use ($currentUserId, $targetUserId) {
                $query->where('user_id', $currentUserId)
                      ->where('connection_id', $targetUserId);
            })
            ->orWhere(function ($query) use ($currentUserId, $targetUserId) {
                $query->where('user_id', $targetUserId)
                      ->where('connection_id', $currentUserId);
            })
            ->where('status', 1) 
            ->exists();

        return $isFriend;
    }
    public function getApiData($user){
        $isonline = false;
        if($user->active_status == 1){
            $isonline = true;
        }
        $feedback_survey_value = $isFriend = $isFRqSent = false;      
        if(Auth::user()){
            $loggedUserId = Auth::user()->id;
            $user1Id = $user->id;
            $user2Id = $loggedUserId; 
            $connection = UserConnection::where(function ($query) use ($user1Id, $user2Id) {
                $query->where('user_id', $user1Id)
                    ->where('connection_id', $user2Id);
            })->orWhere(function ($query) use ($user1Id, $user2Id) {
                $query->where('user_id', $user2Id)
                    ->where('connection_id', $user1Id);
            })->first();            
            if($connection && $connection->status==1) {
                $isFriend = true;           
            }else if($connection && $connection->status == 0){
                $isFRqSent = true;
            }
            $setting_feedback = Setting::settingFeedback();
            $feedback_survey = UserFeedbackSurvey::where('user_id',Auth::user()->id)->first();
            $user_created_at = Auth::user()->created_at;
            $createdAt = Carbon::parse($user_created_at)->startOfDay()->addDays($setting_feedback["survey_days_tradies"]);
            $currentDate = Carbon::now()->startOfDay(); 
            $daysDifference = $createdAt->diffInDays($currentDate);
            if($setting_feedback['survey_status_tradies'] == 1 && empty($feedback_survey) && in_array($daysDifference,[0,1,2]) && $currentDate->greaterThanOrEqualTo($createdAt) ){
                $feedback_survey_value = true;
            }
                
        }        
        return [            
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            "mobile" => $user->mobile,
            "abn_acn" => $user->abn_acn,
            "is_online" => $isonline,
            "is_logged_in" =>(boolean)$user->is_logged_in,     
            "address" => $user->address,
            "postal_code" => (string)$user->pincode,
            'over_all_rating'=>$user->over_all_rating, 
            'notification_status'=>$user->notification, 
            'post_count'=>$this->posts->count(), 
            'connect_count'=>$this->connection_count, 
            'skill_id' => $user->skill_category_id ? new SkillResource($this->SkillCategory) : null,
            'badge_id' =>$user->badge ? new BadgeResource($user->badge) : null,
            'status' => $user->status,
            'profile_picture' => $user->profile_picture ? url($user->profile_picture) : '',      
            'trader_licence' => $user->trader_licence ? url($user->trader_licence): '',  
            'experience_certificate' => $user->experience_certificate ? url($user->experience_certificate): '',  
            'new_experience_certificate' => ExperienceCertificateResource::collection($this->UserExperienceCertificate),  
            'is_request_sent' => $isFRqSent,
            'is_friend' => $isFriend,
            'isFeedbackSurvey' => $feedback_survey_value,
        ];
    }
}
