<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use ImanRjb\JwtAuth\Services\AccessToken\AccessToken;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->bearerToken();
            if($token) {
                return AccessToken::checkToken($token);
            }
            return ;
        });
    }
}
