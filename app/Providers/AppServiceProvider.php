<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Stripe\Stripe;
use App\Models\Setting;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $smtpSettings = Setting::first(); 
        if ($smtpSettings && $smtpSettings->smtp_host) {               
            Config::set('mail.mailers.smtp.host', $smtpSettings->smtp_host);
            Config::set('mail.mailers.smtp.port', $smtpSettings->smtp_port);
            Config::set('mail.mailers.smtp.username', $smtpSettings->smtp_username);
            Config::set('mail.mailers.smtp.password', $smtpSettings->smtp_password);
            Config::set('mail.mailers.smtp.encryption', $smtpSettings->smtp_encryption);
            Config::set('mail.from.address',$smtpSettings->smtp_from_address);
            Config::set('mail.from.name',Config('app.name'));
        }
    }
}
