<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SkillCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([\App\Observers\PostObserver::class])]
class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'author_id',
        'title',
        'location',
        'short_description',
        'content',
        'thumb_url',
        'skill_id',
        'post_type',
        'status',
    ];

    public function SkillCategory()
    {
        return $this->hasOne(SkillCategory::class, 'id', 'skill_id');
    }

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }
    public function gallery(){
        return $this->hasMany(PostGallery::class,'post_id','id');
    }
    public function oneImageOrVideo()
{
    return $this->hasOne(PostGallery::class)
        ->whereIn('type', ['1', '2'])
        ->oldest(); // or ->latest()
}
    public function comments(){
        return $this->hasMany(PostComment::class,'post_id','id');
    }
    public function likes(){
        return $this->hasMany(PostLike::class,'post_id','id')->where('type',1);
    }

    public function like()
    {
        return $this->hasOne(PostLike::class, 'id', 'post_id')->where('type',1);
    }
    public function endorsements(){
        return $this->hasMany(PostEndorsement::class,'post_id','id');
    }

    public function endorsementStatus()
    {
        $user = Auth::user();
        if($user->user_type == User::ROLE['agency']){
            $agency_id = $user->id;
        }else{
            $agency_id = $user->agency_id;
        }
        return $this->hasOne(PostEndorsement::class, 'post_id', 'id')->where('user_id',$agency_id);
    }


}
