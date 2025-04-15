<?php

namespace App\Providers;

use App\Events\CheckOutEvent;
use App\Events\ForgetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\RegistAccount;
use App\Listeners\CheckOutListener;
use App\Listeners\ForgetPasswordListener;
use App\Listeners\SendOTPConfirmToEmail;


class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Đăng ký các event và listener
        Event::listen(
            RegistAccount::class,
            SendOTPConfirmToEmail::class
        );
        Event::listen(
            CheckOutEvent::class,
            CheckOutListener::class
        );
        Event::listen(
            ForgetPassword::class,
            ForgetPasswordListener::class
        );
    }
}
