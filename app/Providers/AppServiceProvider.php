<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->bearerToken();
            if($token) {
                return AccessToken::checkToken($token);
            }
            return;
        });
    }
}
