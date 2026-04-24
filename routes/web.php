<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AgencyStatus;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\{HomeController,CkeditorController,CheckoutController};
use App\Http\Controllers\Tradie\{DashboardController as TradieDashboard, JobController as TradieJob, ProfileController as TradieProfile, PostController as TradiePost, ConnectionController as TradieConnection, NotificationController as TradieNotification};
use App\Http\Controllers\Admin\{AgencySubscriptionController,UserController,DashboardController,ProfileController,AgencyController,TraderController,SkillCategoriesController,JobController,RoleController,SettingController,AgentController,NotificationController,SubscriptionPlanController,BadgesController,PostOverWallController,EndrosementPostController,CmsController,PreviewPostJobController,AddonPlansController,FeedbackSurveysController};
/* Common Routes*/
Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.image-upload');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/employer', [HomeController::class, 'employer'])->name('employer');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/mobile/contactus', [HomeController::class, 'contactUs'])->name('contactus');
Route::post('contact/post',[HomeController::class, 'submitForm'])->name('submitform');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/mobile/aboutus', [HomeController::class, 'aboutUs'])->name('aboutus');
Route::get('/mobile/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/mobile/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/terms-condition', [HomeController::class, 'termsCondition'])->name('termsCondition');
Route::get('search/results',[HomeController::class, 'submitSearchForm'])->name('searchform');
Route::get('/post/{id}', [HomeController::class, 'show'])->name('post.show');
Route::post('/post/{id}/react', [HomeController::class, 'react'])->middleware('auth');
#Route::get('/search-results', [HomeController::class, 'searchResult'])->name('searchResults');
Route::get('search/details/{id}/{text}', [HomeController::class, 'showDetails'])->name('get.resultdetail');
Route::get('trader/tradee-post-detail/{id}', [HomeController::class, 'showTraderPost'])->name('get.trader.post.detail');
Route::get('login', [UserController::class, 'login'])->name('login');
Route::name('user.')->prefix('user')->middleware(['guest'])->group(function() {  
        Route::get('login', [UserController::class, 'login'])->name('login');
        Route::post('loginpost', [UserController::class, 'loginPost'])->name('loginpost');
        Route::get('password/reset', [UserController::class, 'showResetForm'])->name('reset.form');
        Route::post('password/email', [UserController::class, 'postResetForm'])->name('reset.email');
        Route::get('password/reset/{token}', [UserController::class, 'showNewPassForm'])->name('reset.token');
        Route::post('password/reset', [UserController::class, 'setNewPass'])->name('reset.setpass');
        Route::get('register',[UserController::class,'register'])->name('register');
        Route::post('registerpost',[UserController::class,'registerpost'])->name('registerpost');
        Route::get('tradie/register',[UserController::class,'tradieRegister'])->name('tradie.register');
        Route::post('tradie/registerpost',[UserController::class,'tradieRegisterPost'])->name('tradie.registerpost');
        Route::get('tradie/verify',[UserController::class,'tradieVerify'])->name('tradie.verify');
        Route::post('tradie/verifypost',[UserController::class,'tradieVerifyPost'])->name('tradie.verifypost');
        });   

Route::group(['middleware' => ['auth']], function() {
    // Tradie Routes
    Route::group(['prefix' => 'tradie', 'as' => 'tradie.', 'middleware' => ['role:trader']], function () {
        Route::get('dashboard', [TradieDashboard::class, 'index'])->name('dashboard');
        Route::post('jobs/apply', [TradieJob::class, 'apply'])->name('jobs.apply');
        Route::get('jobs', [TradieJob::class, 'index'])->name('jobs.index');
        Route::get('jobs/{id}', [TradieJob::class, 'show'])->name('jobs.show');
        Route::post('jobs/withdraw', [TradieJob::class, 'withdraw'])->name('jobs.withdraw');
        Route::post('jobs/{id}/complete', [TradieJob::class, 'markComplete'])->name('jobs.complete');
        Route::post('jobs/review', [TradieJob::class, 'review'])->name('jobs.review');
        Route::post('jobs/report', [TradieJob::class, 'report'])->name('jobs.report');
        Route::get('profile', [TradieProfile::class, 'index'])->name('profile.index');
        Route::post('profile/update', [TradieProfile::class, 'update'])->name('profile.update');
        Route::post('profile/password', [TradieProfile::class, 'changePassword'])->name('profile.password');
        Route::get('posts', [TradiePost::class, 'index'])->name('posts.index');
        Route::get('posts/create', [TradiePost::class, 'create'])->name('posts.create');
        Route::post('posts', [TradiePost::class, 'store'])->name('posts.store');
        Route::get('posts/{id}', [TradiePost::class, 'show'])->name('posts.show');
        Route::get('posts/{id}/edit', [TradiePost::class, 'edit'])->name('posts.edit');
        Route::post('posts/{id}', [TradiePost::class, 'update'])->name('posts.update');
        Route::post('posts/{id}/delete', [TradiePost::class, 'destroy'])->name('posts.destroy');
        Route::get('connections', [TradieConnection::class, 'index'])->name('connections.index');
        Route::post('connections/action', [TradieConnection::class, 'action'])->name('connections.action');
        Route::get('notifications', [TradieNotification::class, 'index'])->name('notifications.index');
    });
    Route::post('tradie/connections/send', [TradieConnection::class, 'sendRequest'])->name('tradie.connections.send');
    Route::get('/checkout/failure',[CheckoutController::class, 'failure'])->name('stripe.failure');
    Route::get('/checkout/success',[CheckoutController::class, 'success'])->name('stripe.success');
    Route::get('/checkout',[CheckoutController::class, 'index'])->name('stripe.checkout');
    Route::get('/checkout',[CheckoutController::class, 'index'])->name('stripe.checkout');
    Route::post('/checkout/charge',[CheckoutController::class, 'charge'])->name('stripe.charge');
    Route::get('/checkout/unsubscribe',[CheckoutController::class, 'unSubscribe'])->name('unSubscribe');
   
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    //Route::get('/search', [DashboardController::class,'search'])->name('dashboard.search');
    Route::post('/notifications/mark-as-read', [DashboardController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/global-search', [DashboardController::class, 'search'])->name('global.search');
    Route::get('/earnings-data', [DashboardController::class, 'getEarningsData']);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/user-feedback-survey', [DashboardController::class, 'feedbackSurvey'])->name('feedbacksurvey');
    // profile
    Route::post('user/media', [UserController::class, 'storeMedia'])->name('user.storeMedia');
    Route::post('user/medialogo', [UserController::class, 'storeLogoMedia'])->name('user.storeLogoMedia');
    Route::get('agency/fetch-recentjobs', [AgencyController::class, 'fetchRecentData'])->name('fetch.recentagencyjobs');
    Route::get('showprofile', [UserController::class, 'showProfile'])->name('showprofile');
    Route::get('profile', [UserController::class, 'getProfile'])->name('profile');
    Route::put('profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/changepassword', [UserController::class, 'changePassword'])->name('changepassword');
    Route::post('profile/updateagency', [UserController::class, 'updateAgency'])->name('updateagency');
    Route::get('trader/show-post/{id}', [TraderController::class, 'showPost'])->name('get.post');
    Route::get('trader/show-feedback/{id}', [TraderController::class, 'showFeedback'])->name('get.feedback');
    Route::get('trader/post-detail/{id}', [TraderController::class, 'showPostDetail'])->name('get.post.detail');
    Route::get('trader/fetch-traders', [TraderController::class, 'fetchData'])->name('fetch.traders');
    Route::get('trader/fetch-recentjobs', [TraderController::class, 'fetchRecentData'])->name('fetch.recentjobs');
    Route::post('trader/image', [TraderController::class, 'storeImage'])->name('trader.storeImage');
    Route::get('trader/changestatus/{id}',[TraderController::class, 'changeStatus'])->name('trader.changestatus');
    Route::post('trader/checkbox', [TraderController::class, 'homeTraderSeen'])->name('checkbox.seen');
    Route::resource('trader',TraderController::class);

    Route::middleware([AgencyStatus::class])->group(function () {
        Route::post('job/media', [JobController::class, 'storeMedia'])->name('job.storeMedia');
        Route::get('job/fetch-jobs', [JobController::class, 'fetchData'])->name('fetch.jobs');
        Route::post('job/approve', [JobController::class, 'approveJob'])->name('job.approve');
        Route::get('job/get-rating/{id}', [JobController::class, 'getRating'])->name('get.rating');
        Route::post('job/rating', [JobController::class, 'ratingEmployee'])->name('job.rating');
        Route::post('job/complaint', [JobController::class, 'complaintEmployee'])->name('job.complaint');
        Route::post('job/extension', [JobController::class, 'extensionEmployee'])->name('job.extension');
        Route::get('job/get-withdraw/{id}', [JobController::class, 'getWithdraw'])->name('get.withdraw');
        Route::get('job/hired-employees', [JobController::class, 'hiredEmployee'])->name('fetch.hiredemployees');
        Route::post('job/approveemployee', [JobController::class, 'approveEmployee'])->name('job.approveemployee');
        Route::post('job/rejectEmployee', [JobController::class, 'rejectEmployee'])->name('job.rejectEmployee');
        Route::post('job/completeJob', [JobController::class, 'completeJob'])->name('job.completeJob');
        Route::post('job/cancelJob', [JobController::class, 'cancelJob'])->name('job.cancelJob');
        Route::post('job/preview', [JobController::class, 'preview'])->name('job.preview');
        Route::get('preview/job', [JobController::class, 'previewData'])->name('job.previewdata');
        Route::post('job/checkbox', [JobController::class, 'homeJobSeen'])->name('job.checkbox.seen');
        Route::resource('job',JobController::class);   
        Route::get('agent/fetch-agents', [AgentController::class, 'fetchData'])->name('fetch.agents');
        Route::post('agent/image', [AgentController::class, 'storeImage'])->name('agent.storeImage');
        Route::get('agent/changestatus/{id}',[AgentController::class, 'changeStatus'])->name('agent.changestatus');
        Route::resource('agent',AgentController::class);
        Route::get('notification/viewed/{id}',[NotificationController::class, 'viewed'])->name('notification.viewed');
        Route::resource('notifications',NotificationController::class);  
        Route::resource('subscription',AgencySubscriptionController::class); 
        Route::get('like-endorse/{id}',[EndrosementPostController::class,'likeEndorse'])->name('like-endorse');
        Route::get('comment/{id}',[EndrosementPostController::class,'comment'])->name('comment');
        Route::post('storecomment',[EndrosementPostController::class,'storeComment'])->name('endrosement-post.storecomment');
        Route::post('endrosement-post/endrose', [EndrosementPostController::class, 'endroseRecord'])->name('endrosement-post.endrose');
        Route::resource('endrosement-post',EndrosementPostController::class);    
    });
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('skill-categories/fetch-categories', [SkillCategoriesController::class, 'fetchData'])->name('fetch.skill-categories');
        Route::get('skill-categories/changestatus/{id}',[SkillCategoriesController::class, 'changeStatus'])->name('skill-categories.changestatus');
        Route::resource('skill-categories',SkillCategoriesController::class);
        Route::get('agency/fetch-agency', [AgencyController::class, 'fetchData'])->name('fetch.agencies');
        Route::get('agency/changestatus/{id}',[AgencyController::class, 'changeStatus'])->name('agency.changestatus');
        Route::post('agency/image', [AgencyController::class, 'storeImage'])->name('agency.storeImage');
        Route::resource('agency',AgencyController::class);
        Route::get('role/fetch-list', [RoleController::class, 'fetchData'])->name('fetch-role');
        Route::resource('role',RoleController::class);
        Route::get('setting/mail-edit/{id}',[SettingController::class, 'mailEdit'])->name('setting.mailedit');
        Route::patch('setting/mail-edit-post/{id}',[SettingController::class, 'mailEditPost'])->name('setting.maileditpost');
        Route::get('cache/remove', [SettingController::class, 'cacheRemove'])->name('cacheRemove');
        Route::get('setting/fetch-settings', [SettingController::class, 'fetchData'])->name('fetch.settings');
        Route::resource('setting',SettingController::class);
        Route::get('plans/list', [SubscriptionPlanController::class, 'fetchData'])->name('fetch.plans');
        Route::post('plans/activate', [SubscriptionPlanController::class, 'activateSubscription'])->name('plans.activate');
        Route::get('subscribers', [SubscriptionPlanController::class, 'getSubscribers'])->name('subscriber.view');
        Route::get('subscriber/list', [SubscriptionPlanController::class, 'fetchSubscriber'])->name('subscriber.list');
        Route::get('subscriber/recentlist', [UserController::class, 'fetchSubscriber'])->name('showprofile.subscriberlist');
        Route::resource('plans',SubscriptionPlanController::class);
        Route::resource('addon-plans',AddonPlansController::class); 
        Route::get('badges/changestatus/{id}',[BadgesController::class, 'changeStatus'])->name('badges.changestatus');
        Route::resource('badges',BadgesController::class);
        Route::get('feedback-survey/get-feedback/{id}', [FeedbackSurveysController::class, 'getFeedback'])->name('get.feedback');
        Route::get('feedback-survey/fetch-rating', [FeedbackSurveysController::class, 'fetchData'])->name('fetch.feedback-surveys');
        Route::resource('feedback-survey',FeedbackSurveysController::class);
        Route::get('post-over-wall/changestatus/{id}',[PostOverWallController::class, 'changeStatus'])->name('post-over-wall.changestatus');
        Route::resource('post-over-wall',PostOverWallController::class);
        Route::get('cms/list', [CmsController::class, 'fetchData'])->name('fetch.cms');
        Route::resource('cms',CmsController::class); 
    });
});


Route::get('/test-mail', function () {
    try {
        Mail::raw('Test email body', function ($m) {
            $m->to('riddhinaincy@gmail.com')
              ->subject('Test ' . rand());
        });

        return '✅ Mail sent successfully!';
    } catch (\Exception $e) {
        return '❌ Mail failed: ' . $e->getMessage();
    }
});

Route::get('/check-mail', function () {
    return [
        'mailer' => config('mail.default'),
        'host' => config('mail.mailers.smtp.host'),
        'port' => config('mail.mailers.smtp.port'),
        'username' => config('mail.mailers.smtp.username'),
    ];
});

