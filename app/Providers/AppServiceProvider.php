<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                // ->subject('Subject')
                // ->line('This is content')
                // ->action('button', $url);
                ->view('Emails.verify-custom', [
                    'user' => $notifiable,
                    'url' => $url,
                ]);
        });
    }
}
