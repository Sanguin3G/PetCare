<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // $this->registerPolicies();
        // @method static void routes()
        // Passport::routes();
        Passport::tokensExpireIn(now()->addDays(15)); // Access Token hết hạn sau 15 ngày
        Passport::refreshTokensExpireIn(now()->addDays(30)); // Refresh Token hết hạn sau 30 ngày
        Passport::personalAccessTokensExpireIn(now()->addMonths(6)); // Personal Token hết hạn sau 6 tháng
    }
}
