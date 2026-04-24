<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AuthController,JobController,PostController,NotificationController,ConnectionController,FeedbackSurveyController};

Route::group(['prefix' => 'v1'], function () {
    Route::post('user/register', [AuthController::class, 'register']);    
    Route::post('user/login', [AuthController::class, 'login']);
    Route::post('user/request/forgot-otp', [AuthController::class, 'requestForgotOtp']);   
    Route::post('user/verify/forgot-otp', [AuthController::class, 'forgotOtpVerification']); 
    Route::post('user/set-new-password', [AuthController::class, 'setForgotPassword']); 
    Route::get('settings', [AuthController::class, 'fetchSettings']);
    //Route::post('other-skill-categories', [AuthController::class, 'setOtherSkill']);

    Route::group(['middleware' => 'auth:api'], function () { 
        Route::get('user/logout', [AuthController::class, 'logout']);    
        Route::get('user/profile', [AuthController::class, 'getProfile']);
        Route::get('user/search', [AuthController::class, 'searchUsers']);
        Route::post('profile/update', [AuthController::class, 'profileUpdate']);
        Route::post('profile/edit', [AuthController::class, 'editProfile']);
        Route::post('profile/certificate/delete', [AuthController::class,'deleteCertificate']);
        Route::post('password/update', [AuthController::class, 'passwordUpdate']);
        Route::post('user/profile-image', [AuthController::class, 'updateProfileImage']);
        Route::post('email/otp-verify', [AuthController::class, 'emailOtpVerification']);         
        Route::post('user/report', [AuthController::class, 'flagUser']);   
        Route::get('search/traders', [AuthController::class, 'searchTraders']);      
        Route::post('user/online-status', [AuthController::class, 'setOnlineStatus']);      
        Route::post('user/set-preferences', [AuthController::class, 'setUserFeedPreferences']);      
        Route::get('user/get-preferences', [AuthController::class, 'getUserFeedPreferences']);  
        Route::post('user/update-device-token', [AuthController::class, 'updateDeviceToken']);
        #feedback survey    
        Route::post('feedback/feedback_survey_save', [FeedbackSurveyController::class, 'feedbackSurveySave']);    
        # Connection APIS
        Route::post('connection/add', [ConnectionController::class, 'addUser']);
        Route::post('connection/remove', [ConnectionController::class, 'removeUser']);
        Route::post('connection/action', [ConnectionController::class, 'statusUpdate']);
        Route::get('connection/listing', [ConnectionController::class, 'listUser']);
        # Post APIS
        Route::get('post/comments/{id}', [PostController::class,'getComments']);  
        Route::get('post/likes/{id}', [PostController::class,'getLikes']);  
        Route::post('comment/like-dislike', [PostController::class, 'commentsLikeDislike']);
        Route::post('post/comment/add', [PostController::class, 'addPostComment']);
        Route::post('post/like-dislike', [PostController::class, 'postLikeDislike']);
        Route::post('post/update/{id}', [PostController::class, 'updatePost']);
        Route::post('post/update1/{id}', [PostController::class, 'updatePost1']);
        Route::post('post/add', [PostController::class,'savePost']);
        Route::post('post/add1', [PostController::class,'savePost1']);
        Route::get('post/view/{id}', [PostController::class,'showPost']);  
        Route::get('post/listing', [PostController::class,'getListing']);  
        Route::post('post/get-media', [PostController::class,'getMedia']);  
        Route::post('post/delete', [PostController::class,'deletePost']);  
        Route::post('post/media/delete', [PostController::class,'deleteMedia']);  
        Route::post('post/endorsement/status', [PostController::class,'endorsementStatus']);  
         # Job APIS
        Route::post('job/like-dislike', [JobController::class, 'jobLikeDislike']);
        Route::post('job/review', [JobController::class,'jobReview']);       
        Route::post('job/withdraw', [JobController::class,'withdrawBid']);       
        Route::get('job/completed/{id}', [JobController::class,'markJobComplete']);       
        Route::get('job/view/{id}', [JobController::class,'viewJobDetail']);       
        Route::post('job/apply', [JobController::class,'bidOnJob']);       
        Route::get('home/feeds', [JobController::class, 'homeFeeds']);
        Route::get('job/listing', [JobController::class, 'mapListing']);
        Route::get('trader/jobs', [JobController::class, 'tradersJob']);
        Route::get('trader/job-need-to-complete', [JobController::class, 'needToComplete']);
        Route::post('job/extend-date', [JobController::class, 'extendedJobDate']);

        # General APIS
        Route::get('account/deactivate', [AuthController::class, 'accountDeactivate']);
        Route::get('notification/setting', [NotificationController::class, 'setting']);
        Route::get('notification/listing', [NotificationController::class, 'getListing']);
        Route::get('notification/delete/{id}', [NotificationController::class, 'delete']);
        Route::get('notification/read/{id}', [NotificationController::class, 'markRead']);
        Route::get('notification/unreads', [NotificationController::class, 'unreadCount']);
        Route::post('notification/test', [NotificationController::class, 'notificationTest']);
    });
});

